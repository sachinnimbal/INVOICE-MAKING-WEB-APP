<!-- |||||||||||||||||||||||||| Insert into Customer Table Data |||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_Customer'])) {
        $customer_name = $_POST['full_name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
                    
        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');

        // Get the current Indian time
        $current_time = date('Y-m-d H:i:s');

        if (!startsWith($phone, '+91')) {
            $phone = '+91' . $phone;
        }

        // Check database connection
        if ($conn) {
            $duplicate = mysqli_query($conn, "SELECT * FROM `customers` WHERE full_name='$customer_name'");

            if (mysqli_num_rows($duplicate) > 0) {
                $_SESSION['status'] = "Customer Already <b class='text-danger'>Exists!!</b> $customer_name";
            } else {
                // Use prepared statements to prevent SQL injection
                $stmt = mysqli_prepare($conn, "INSERT INTO customers (full_name, phone, address, created_at) VALUES (?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "ssss", $customer_name, $phone, $address, $current_time);

                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['status'] = "Customer Data Saved <b class='text-light'>Successfully</b>";
                    header('Location: index');
                    exit();
                } else {
                    $_SESSION['status'] = "Failed To Save Customer Data";
                    header('Location: index');
                }
            }
        } else {
            $_SESSION['status'] = "Database Connection Failed";
            header('Location: index');
            exit();
        }
        header('Location: index');
        exit();
    }
    function startsWith($haystack, $needle) {
        return strncmp($haystack, $needle, strlen($needle)) === 0;
    }
?>

<!-- |||||||||||||||||||||||||| Insert into Exchange_Product Table Data |||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    function generateNextExchangeCode($conn) {
        $sql = "SELECT MAX(exchange_code) AS max_code FROM `exchange_product` WHERE exchange_code LIKE 'EXCH%'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $maxCode = $row['max_code'];
            if ($maxCode !== null) {
                $numericPart = intval(substr($maxCode, 4)) + 1;

                // Check if the numeric part exceeds certain limits
                if ($numericPart > 9999) {
                    return 'EXCH' . sprintf('%05d', $numericPart);
                } else if ($numericPart > 999) {
                    return 'EXCH' . sprintf('%04d', $numericPart);
                } else if ($numericPart > 99) {
                    return 'EXCH' . sprintf('%03d', $numericPart);
                } else {
                    return 'EXCH' . sprintf('%02d', $numericPart);
                }
            }
        }
        return 'EXCH01';
    }

    function generateNextProductCode($conn) {
        $sql = "SELECT MAX(product_code) AS max_code FROM `products` WHERE product_code LIKE 'SCPRO%'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $maxCode = $row['max_code'];
            if ($maxCode !== null) {
                $numericPart = intval(substr($maxCode, 5)) + 1;

                // Check if the numeric part exceeds 99 to switch to three digits
                if ($numericPart > 999) {
                    return 'SCPRO' . sprintf('%04d', $numericPart);
                } else if ($numericPart > 99) {
                    return 'SCPRO' . sprintf('%03d', $numericPart);
                } else {
                    return 'SCPRO' . sprintf('%02d', $numericPart);
                }
            }
        }
        return 'SCPRO01';
    }

    // Function to generate order reference
    function generateOrderReference($conn) {
        $lastOrderRefQuery = "SELECT MAX(exchange_order_reference) AS last_order_ref FROM exchange_product";
        $lastOrderRefResult = $conn->query($lastOrderRefQuery);
        $lastOrderRefRow = $lastOrderRefResult->fetch_assoc();
        $lastOrderRef = $lastOrderRefRow['last_order_ref'];

        if ($lastOrderRef) {
            $lastNumber = intval(substr($lastOrderRef, 8)); // Extract number after 'SCEXCINV'
            $newNumber = $lastNumber + 1;
            $paddedNumber = str_pad($newNumber, 2, '0', STR_PAD_LEFT);
            $newOrderRef = "SCEXCINV" . $paddedNumber;
        } else {
            $newOrderRef = "SCEXCINV01";
        }

        return $newOrderRef;
    }
    
    function verify_invoice($conn) {
        $prefix = "SCEXI";
        $numericPartLength = 5;
        do {
            $randomNumber = mt_rand(1, pow(10, $numericPartLength) - 1);
            $paddedNumber = str_pad($randomNumber, $numericPartLength, '0', STR_PAD_LEFT);
            $newVerifyOrderRef = $prefix . $paddedNumber;
            $checkQuery = "SELECT COUNT(*) AS count FROM exchange_product WHERE verify_invoice = '$newVerifyOrderRef'";
            $checkResult = $conn->query($checkQuery);
            $checkRow = $checkResult->fetch_assoc();
        } while ($checkRow['count'] > 0);
        return $newVerifyOrderRef;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_Exchange'])) {
        // Retrieve exchange product details from the form
        $brand = $_POST['exchange_brand'] ?? '';
        $category = $_POST['exchange_category'] ?? '';
        $product_name = $_POST['exchange_product_name'] ?? '';
        $condition_name = $_POST['exchange_condition_name'] ?? '';
        $purchase_price = $_POST['exchange_purchase_price'] ?? '';
        $original_price = $_POST['original_price'] ?? '';
        $total_price_words = $_POST['total_price_words'] ?? '';
        $qty = "1";
        $exchange_imei_number = $_POST['exchange_imei_number'] ?? '';
        $customer_IdType = $_POST['customer_IdType'] ?? '';
        $aadharNumber = $_POST['aadharNumber'] ?? '';
        $voterNumber = $_POST['voterNumber'] ?? '';
        $card_image = $_FILES['exchange_verification_id']['name'] ?? '';
        $exchangeCode = generateNextExchangeCode($conn);
        $status = "1";
        $exchange_order_reference = generateOrderReference($conn);
        $verifyOrderRef = verify_invoice($conn);

        // Retrieve customer details from the form
        $customerName = $_POST['customer_name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';

        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');

        // Get the current Indian time
        $current_time = date('Y-m-d H:i:s');

        // Check if voter or Aadhaar is selected and validate accordingly
        if ($customer_IdType === 'voter' && empty($voterNumber)) {
            $_SESSION['status'] = "Voter ID cannot be empty for Voter ID type.";
            header('Location: exchange-item');
            exit();
        }

        if ($customer_IdType === 'aadhaar' && empty($aadharNumber)) {
            $_SESSION['status'] = "Aadhaar number cannot be empty for Aadhaar Card type.";
            header('Location: exchange-item');
            exit();
        }

        // Start a transaction
        $conn->begin_transaction();

        // Check if the customer exists...
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

        // Insert into 'exchange_product' table
        $insertExchangeQuery = "INSERT INTO `exchange_product`
        (`customer_id`, `verify_invoice` ,`exchange_code`, `exchange_order_reference`, `date`, `exchange_category`, `exchange_brand`, `exchange_condition_name`, `exchange_product_name`, `exchange_qty`, `exchange_imei_number`, `exchange_purchase_price`, `total_price_words` ,`customer_IdType`, `aadharNumber`, `voterNumber`, `card_image`, `created_at`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Bind parameters for insertion into 'exchange_product' table
        $insertExchangeStmt = $conn->prepare($insertExchangeQuery);
        $insertExchangeStmt->bind_param("issssssssisdssssss", $customerId, $verifyOrderRef , $exchangeCode, $exchange_order_reference ,date("Y-m-d"), $category, $brand, $condition_name, $product_name, $qty, $exchange_imei_number, $purchase_price, $total_price_words, $customer_IdType, $aadharNumber, $voterNumber, $card_image, $current_time);

        // Extensions Info Checking
        $allowed_image_extensions = array("png", "jpg", "jpeg");
        $file_extension = strtolower(pathinfo($_FILES['exchange_verification_id']['name'], PATHINFO_EXTENSION));
        $max_file_size = 5 * 1024 * 1024; // 5MB

        // Check if the file extension is allowed
        if (!in_array($file_extension, $allowed_image_extensions)) {
            $_SESSION['status'] = "Please insert only <b class='text-danger'>PNG, JPG, JPEG</b> extensions images.";
            header('Location: exchange-item');
            exit();
        }

        // Check if the file size exceeds the limit
        if ($_FILES['exchange_verification_id']['size'] > $max_file_size) {
            $_SESSION['status'] = "Image size exceeds <b class='text-danger'>5MB</b>.";
            header('Location: exchange-item');
            exit();
        }

        // Move uploaded image if it passes the validations
        $targetDirectory = 'IDCard_img/';
        $targetPath = $targetDirectory . basename($_FILES['exchange_verification_id']['name']);

        if (!move_uploaded_file($_FILES['exchange_verification_id']['tmp_name'], $targetPath)) {
            $_SESSION['status'] = "Error uploading image.";
            header('Location: exchange-item');
            exit();
        }

        // Execute both insert statements within the same transaction
        if (!$insertExchangeStmt->execute()) {
            $_SESSION['status'] = "Error: " . $conn->error;
            $conn->rollback();
            header('Location: exchange-item');
            exit(); 
        }

        $exchangeId = $conn->insert_id;

        $productCode = generateNextProductCode($conn);

        $insertProductQuery = "INSERT INTO `products` 
            (`product_code`, `category_title`, `brand_title`, `product_name`, `condition_name`, `original_price`, `selling_price`, `qty`, `status`, `created_at`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $insertProductStmt = $conn->prepare($insertProductQuery);
        $insertProductStmt->bind_param(
            "sssssssiss",
            $productCode, 
            $category,
            $brand,
            $product_name,
            $condition_name,
            $original_price,
            $purchase_price,
            $qty,
            $status,
            $current_time
        );

        if (!$insertProductStmt->execute()) {
            $_SESSION['status'] = "Error inserting data into products table: " . $conn->error;
            $conn->rollback();
            header('Location: exchange-item');
            exit();
        }

        // Insert exchange_imei_number into the 'imei_numbers' table with foreign key reference to the last inserted product_id
        $exchange_imei_number = $_POST['exchange_imei_number'] ?? '';
        // Retrieve the last inserted product ID
        $lastInsertedProductId = $conn->insert_id;

        // Check if the IMEI number already exists
        $checkIMEIQuery = "SELECT COUNT(*) AS count FROM `imei_numbers` WHERE `imei_number` = ?";
        $checkIMEIStmt = $conn->prepare($checkIMEIQuery);
        $checkIMEIStmt->bind_param("s", $exchange_imei_number);
        $checkIMEIStmt->execute();
        $checkIMEIResult = $checkIMEIStmt->get_result();
        $existingCount = $checkIMEIResult->fetch_assoc()['count'];

        if ($existingCount === 0) {
            // Insert IMEI number into 'imei_numbers' table with product_id foreign key
            $insertIMEIQuery = "INSERT INTO `imei_numbers` (`product_id`, `imei_number`, `created_at`) VALUES (?, ?, ?)";
            $insertIMEIStmt = $conn->prepare($insertIMEIQuery);
            $insertIMEIStmt->bind_param("sss", $lastInsertedProductId, $exchange_imei_number, $current_time);

            if (!$insertIMEIStmt->execute()) {
                $_SESSION['status'] = "Failed to save IMEI data: " . $insertIMEIStmt->error;
                header('Location: exchange-item');
                exit();
            }
        } else {
            $_SESSION['status'] = "IMEI number already <b class='text-danger'>Exists!!</b>.";
            header('Location: exchange-item');
            exit();
        }

        // Commit the transaction
        $conn->commit();

        // Close prepared statements and database connection
        $insertExchangeStmt->close();
        $insertProductStmt->close();
        $insertIMEIStmt->close(); 
        $conn->close();
        $encryptedExchangeId = base64_encode($exchangeId);
        $_SESSION['exchange_id'] = $encryptedExchangeId;
        $_SESSION['status'] = "Exchange Invoice created <b class='text-light'>Successfully</b>
        <a href='exchange-page?exchange_id=$encryptedExchangeId' target='_blank' class='badge badge-primary text-bold mr-1 ml-1 text-uppercase'>Click here</a> to print the invoice";
        header('Location: exchange-item');
        exit();
    }
?>