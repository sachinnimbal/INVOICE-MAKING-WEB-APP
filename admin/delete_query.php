<!-- ||||||||||||||||||||||||| Delete Category Table Data ||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    if (isset($_POST['category_id'])) {
        $category_id = $_POST['category_id'];

        // Perform deletion based on the received category ID
        $sql = "DELETE FROM `category` WHERE category_id='$category_id'";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            $_SESSION['status'] = "Category Deleted <b class='text-light'>Successfully</b>";
            header("Location: category");
            exit();
        } else {
            $_SESSION['status'] = "Category Deletion <b class='text-danger'>Failed!!</b>";
            header("Location: category");
            $_SESSION['status'] = "Error deleting record: " . mysqli_error($conn);
        }
    }
?>

<!-- ||||||||||||||||||||||||| Delete Condition Table Data ||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    if (isset($_POST['condition_id'])) {
        $condition_id = $_POST['condition_id'];

        // Perform deletion based on the received condition ID
        $sql = "DELETE FROM `conditions` WHERE condition_id='$condition_id'";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            $_SESSION['status'] = "Condition Deleted <b class='text-light'>Successfully</b>";
            header("Location: condition");
            exit();
        } else {
            $_SESSION['status'] = "Condition Deletion <b class='text-danger'>Failed!!</b>";
            header("Location: condition");
            $_SESSION['status'] = "Error deleting record: " . mysqli_error($conn);
        }
    }
?>

<!-- ||||||||||||||||||||||||| Delete Brand Table Data ||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    if (isset($_POST['brand_id'])) {
        $brand_id = $_POST['brand_id'];

        // Fetch the image file name associated with the brand
        $sql_fetch_image = "SELECT brand_img FROM `brand` WHERE brand_id='$brand_id'";
        $result_fetch_image = mysqli_query($conn, $sql_fetch_image);

        if ($result_fetch_image && mysqli_num_rows($result_fetch_image) > 0) {
            $row = mysqli_fetch_assoc($result_fetch_image);
            $brand_image = $row['brand_img'];

            // Delete the brand image file from storage if it exists
            if ($brand_image && file_exists("Brand_logo/" . $brand_image)) {
                unlink("Brand_logo/" . $brand_image);
            }
        }

        // Delete the brand from the database
        $sql = "DELETE FROM `brand` WHERE brand_id='$brand_id'";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            $_SESSION['status'] = "Brand Deleted <b class='text-light'>Successfully</b>";
            header("Location: brand");
            exit();
        } else {
            $_SESSION['status'] = "Brand Deletion <b class='text-danger'>Failed!!</b>";
            header("Location: brand");
            $_SESSION['status'] = "Error deleting record: " . mysqli_error($conn);
        }
    }
?>

<!-- ||||||||||||||||||||||||| Delete Product Table Data ||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    // Check if a product ID is sent through POST request
    if (isset($_POST['id'])) {
        $productId = $_POST['id'];

        // Delete associated records in `imei_numbers` table
        $deleteIMEIQuery = "DELETE FROM `imei_numbers` WHERE product_id = ?";
        $deleteIMEIStatement = mysqli_prepare($conn, $deleteIMEIQuery);
        mysqli_stmt_bind_param($deleteIMEIStatement, "i", $productId);
        $deleteIMEIResult = mysqli_stmt_execute($deleteIMEIStatement);

        // Delete the product record from the database
        $deleteProductQuery = "DELETE FROM `products` WHERE id = ?";
        $deleteProductStatement = mysqli_prepare($conn, $deleteProductQuery);
        mysqli_stmt_bind_param($deleteProductStatement, "i", $productId);
        $deleteProductResult = mysqli_stmt_execute($deleteProductStatement);

        if ($deleteIMEIResult && $deleteProductResult) {
            // Fetch the product image name from the database
            $getImageQuery = "SELECT image FROM `products` WHERE id = ?";
            $getImageStatement = mysqli_prepare($conn, $getImageQuery);
            mysqli_stmt_bind_param($getImageStatement, "i", $productId);
            mysqli_stmt_execute($getImageStatement);
            $getImageResult = mysqli_stmt_get_result($getImageStatement);
            $imageData = mysqli_fetch_assoc($getImageResult);
            $imageName = $imageData['image'];

            // If the product record and associated records are deleted successfully
            if (!empty($imageName)) {
                $imagePath = "Product_img/$imageName";
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Delete the image file from the server
                }
            }

            $_SESSION['status'] = "Product Deleted <b class='text-light'>Successfully</b>";
            header("Location: product-list");
            exit();
        } else {
            $_SESSION['status'] = "Product Deletion <b class='text-danger'>Failed!!</b>";
            header("Location: product-list");
            echo "Error deleting record: " . mysqli_error($conn);
            exit();
        }
    }
?>

<!-- ||||||||||||||||||||||||| Delete Customer Table Data ||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    if (isset($_POST['customer_id'])) {
        $customer_id = $_POST['customer_id'];

        // Perform deletion based on the received category ID
        $sql = "DELETE FROM `customers` WHERE customer_id='$customer_id'";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            $_SESSION['status'] = "Customer Deleted <b class='text-light'>Successfully</b>";
            header("Location: customer");
            exit();
        } else {
            $_SESSION['status'] = "Customer Deletion <b class='text-danger'>Failed!!</b>";
            header("Location: customer");
            $_SESSION['status'] = "Error deleting record: " . mysqli_error($conn);
        }
    }
?>

<!-- ||||||||||||||||||||||||| Delete Accessory Table Data ||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    // Check if a accessory ID is sent through POST request
    if (isset($_POST['accessory_id'])) {
        $accessoryId = $_POST['accessory_id'];

        // Delete the accessory record from the database
        $deleteAccessoryQuery = "DELETE FROM `accessory` WHERE accessory_id = ?";
        $deleteAccessoryStatement = mysqli_prepare($conn, $deleteAccessoryQuery);
        mysqli_stmt_bind_param($deleteAccessoryStatement, "i", $accessoryId);
        $deleteAccessoryResult = mysqli_stmt_execute($deleteAccessoryStatement);

        if ($deleteAccessoryResult) {
            // Fetch the product image name from the database
            $getImageQuery = "SELECT image FROM `accessory` WHERE accessory_id = ?";
            $getImageStatement = mysqli_prepare($conn, $getImageQuery);
            mysqli_stmt_bind_param($getImageStatement, "i", $accessoryId);
            mysqli_stmt_execute($getImageStatement);
            $getImageResult = mysqli_stmt_get_result($getImageStatement);
            $imageData = mysqli_fetch_assoc($getImageResult);
            $imageName = $imageData['image'];

            // If the product record and associated records are deleted successfully
            if (!empty($imageName)) {
                $imagePath = "Product_img/$imageName";
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Delete the image file from the server
                }
            }

            $_SESSION['status'] = "Accessory Deleted <b class='text-light'>Successfully</b>";
            header("Location: product-list");
            exit();
        } else {
            $_SESSION['status'] = "Accessory Deletion <b class='text-danger'>Failed!!</b>";
            header("Location: product-list");
            echo "Error deleting record: " . mysqli_error($conn);
            exit();
        }
    }
?>

<!-- ||||||||||||||||||||||||| Delete Invoice Table Data ||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    if (isset($_POST['invoice_id'])) {
        $invoice_id = $_POST['invoice_id'];

        // Perform deletion based on the received category ID
        $sql = "DELETE FROM `invoices` WHERE invoice_id='$invoice_id'";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            $_SESSION['status'] = "Invoice Deleted <b class='text-light'>Successfully</b>";
            header("Location: invoice-history");
            exit();
        } else {
            $_SESSION['status'] = "Invoice Deletion <b class='text-danger'>Failed!!</b>";
            header("Location: invoice-history");
            $_SESSION['status'] = "Error deleting record: " . mysqli_error($conn);
        }
    }
?>