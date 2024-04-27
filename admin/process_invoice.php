<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Database connection
session_start();
include_once "connection.php"; 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_Invoice'])) {
    // Extract data from the form
    $customerName = $_POST['customer_name'];
    $invoiceDate = $_POST['date'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $cgst = $_POST['cgst'];
    $sgst = $_POST['sgst'];
    $totalPrice = $_POST['total_price'];
    $total_price_words = $_POST['total_price_words'] ?? '';

    // Set the timezone to Indian Standard Time (IST)
    date_default_timezone_set('Asia/Kolkata');

    // Get the current Indian time
    $current_time = date('Y-m-d H:i:s');

    // Start a transaction
    $conn->begin_transaction();

    // Check if the customer exists
    $customerId = null;
    if ($phone) {
        $checkCustomerQuery = "SELECT customer_id FROM customers WHERE phone = ?";
        $checkCustomerStmt = $conn->prepare($checkCustomerQuery);
        $checkCustomerStmt->bind_param("s", $phone);
        $checkCustomerStmt->execute();
        $checkCustomerResult = $checkCustomerStmt->get_result();

        if ($checkCustomerResult->num_rows === 0) {
            // Insert data into 'customers' table for new customer
            $insertCustomerQuery = "INSERT INTO customers (full_name, phone, address, created_at) VALUES (?, ?, ?, ?)";
            $insertCustomerStmt = $conn->prepare($insertCustomerQuery);
            $insertCustomerStmt->bind_param("ssss", $customerName, $phone, $address, $current_time);
            if (!$insertCustomerStmt->execute()) {
                $_SESSION['status'] = "Error saving customer: " . $insertCustomerStmt->error; // Display error message
                header('Location: create-invoice');
                $conn->rollback(); // Rollback the transaction in case of failure
                exit(); // Exit the script
            }
            $customerId = $conn->insert_id;
        } else {
            // Fetch existing customer ID
            $customerRow = $checkCustomerResult->fetch_assoc();
            $customerId = $customerRow['customer_id'];
        }
    }

    // Generate order reference
    $orderReference = generateOrderReference($conn);
    $verifyOrderRef = verify_invoice($conn);

    // Insert data into 'invoices' table
    $insertInvoiceQuery = "INSERT INTO invoices (customer_id, verify_invoice ,order_reference, invoice_date, cgst, sgst, total_price, total_price_words) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $insertInvoiceStmt = $conn->prepare($insertInvoiceQuery);
    $insertInvoiceStmt->bind_param("isssddds", $customerId, $verifyOrderRef ,$orderReference, $invoiceDate, $cgst, $sgst, $totalPrice, $total_price_words);
    if (!$insertInvoiceStmt->execute()) {
        $_SESSION['status'] =  "Error saving invoices: " . $insertInvoiceStmt->error; 
        header('Location: create-invoice');
        $conn->rollback(); 
        exit(); // Exit the script
    }
    $invoiceId = $conn->insert_id;

    // Insert data into 'invoice_items' table (assuming array of items is available in $_POST)
    if (isset($_POST['product_code'])) {
        $insertItemQuery = "INSERT INTO invoice_items (invoice_id, code, brand, category, product_name, imei, original_price, selling_price, quantity, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insertItemStmt = $conn->prepare($insertItemQuery);
    
        foreach ($_POST['product_code'] as $key => $productCode) {
            $brand = $_POST['brand'][$key];
            $category = $_POST['category'][$key];
            $productName = $_POST['product_name'][$key];
            $imei = $_POST['imei'][$key];
            $mrp = $_POST['mrp'][$key];
            $sp = $_POST['sp'][$key];
            $quantity = $_POST['quantity'][$key];
            $total = $_POST['total'][$key];    

            // Update product quantity
            updateProductQuantity($conn, $productCode, $quantity, $current_time);
            updateAccessoryQuantitySold($conn, $productCode, $quantity, $current_time);

            $insertItemStmt->bind_param("issssddiis", $invoiceId, $productCode, $brand, $category, $productName, $imei, $mrp, $sp, $quantity, $total);
            if (!$insertItemStmt->execute()) {
                $conn->rollback(); 
                $_SESSION['status'] = "Error saving invoice items: " . $insertItemStmt->error;
                header('Location: create-invoice');
                exit(); // Exit the script
            }

            // Optionally, you can delete the records from 'imei_numbers' table based on the 'imei_number'
            $deleteIMEIQuery = "DELETE FROM imei_numbers WHERE imei_number = ?";
            $deleteIMEIStmt = $conn->prepare($deleteIMEIQuery);
            $deleteIMEIStmt->bind_param("s", $imei);
            $deleteIMEIStmt->execute();
            $deleteIMEIStmt->close();
        }
    }

    // Commit the transaction
    $conn->commit();

    // Close prepared statements and database connection
    if (isset($insertCustomerStmt)) $insertCustomerStmt->close();
    $insertInvoiceStmt->close();
    $insertItemStmt->close();
    $conn->close();
    $encryptedInvoiceId = base64_encode($invoiceId);
    $_SESSION['invoice_id'] = $encryptedInvoiceId;
    $_SESSION['status'] = "Invoice created <b class='text-light'>Successfully</b> <a href='invoice-page?invoice_id=$encryptedInvoiceId' target='_blank' class='badge badge-primary text-bold mr-1 ml-1 text-uppercase'>Click here</a> to print the invoice";
    header('Location: create-invoice');
    exit();
}

// Function to generate order reference
function generateOrderReference($conn) {
    $lastOrderRefQuery = "SELECT MAX(order_reference) AS last_order_ref FROM invoices";
    $lastOrderRefResult = $conn->query($lastOrderRefQuery);
    $lastOrderRefRow = $lastOrderRefResult->fetch_assoc();
    $lastOrderRef = $lastOrderRefRow['last_order_ref'];

    if ($lastOrderRef) {
        $lastNumber = intval(substr($lastOrderRef, 5)); // Extract number after 'SCINV'
        $newNumber = $lastNumber + 1;
        $paddedNumber = str_pad($newNumber, 2, '0', STR_PAD_LEFT);
        $newOrderRef = "SCINV" . $paddedNumber;
    } else {
        $newOrderRef = "SCINV01";
    }

    return $newOrderRef;
}

function verify_invoice($conn) {
    $prefix = "SCINV";
    $numericPartLength = 5;
    do {
        $randomNumber = mt_rand(1, pow(10, $numericPartLength) - 1);
        $paddedNumber = str_pad($randomNumber, $numericPartLength, '0', STR_PAD_LEFT);
        $newVerifyOrderRef = $prefix . $paddedNumber;
        $checkQuery = "SELECT COUNT(*) AS count FROM invoices WHERE verify_invoice = '$newVerifyOrderRef'";
        $checkResult = $conn->query($checkQuery);
        $checkRow = $checkResult->fetch_assoc();
    } while ($checkRow['count'] > 0);
    return $newVerifyOrderRef;
}


// Function to update product quantity in the products table
function updateProductQuantity($conn, $productCode, $quantity, $current_time) {
    $updateProductQuery = "UPDATE products SET qty = qty - ?, updated_at = ? WHERE product_code = ?";
    $updateProductStmt = $conn->prepare($updateProductQuery);
    $updateProductStmt->bind_param("iss", $quantity, $current_time, $productCode);
    $updateProductStmt->execute();
    $updateProductStmt->close();
}

function updateAccessoryQuantitySold($conn, $accessoryCode, $quantity, $current_time) {
    $updateAccessoryQuery = "UPDATE accessory SET acc_qty = acc_qty - ?, updated_at = ? WHERE accessory_code = ?";
    $updateAccessoryStmt = $conn->prepare($updateAccessoryQuery);
    $updateAccessoryStmt->bind_param("iss", $quantity, $current_time, $accessoryCode);
    $updateAccessoryStmt->execute();
    $updateAccessoryStmt->close();
}


?>
