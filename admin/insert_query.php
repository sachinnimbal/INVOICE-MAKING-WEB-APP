<!-- |||||||||||||||||||||||||| Insert into Category Table Data |||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    include_once 'connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_Category'])) {
        $category_title = $_POST['category_title'];

        // Check database connection
        if ($conn) {
            $duplicate = mysqli_query($conn, "SELECT * FROM `category` WHERE category_title='$category_title'");

            // Set the timezone to Indian Standard Time (IST)
            date_default_timezone_set('Asia/Kolkata');

            // Get the current Indian time
            $current_time = date('Y-m-d H:i:s');

            if (mysqli_num_rows($duplicate) > 0) {
                $_SESSION['status'] = "Category Already <b class='text-danger'>Exists!!</b> $category_title";
                header('Location: category');
                exit(); // Exit after setting the session status
            } else {
                // Updated query to include current timestamp for created_at
                $query = "INSERT INTO `category` (category_title, created_at) VALUES ('$category_title', '$current_time')";
                $query_run = mysqli_query($conn, $query);
                if ($query_run) {
                    $_SESSION['status'] = "Category Data Saved <b class='text-light'>Successfully</b>";
                    header('Location: category');
                    exit(); // Exit after successful insertion
                } else {
                    $_SESSION['status'] = "Failed To Save Category Data";
                    header('Location: category');
                    exit(); // Exit after failed insertion
                }
            }
        } else {
            $_SESSION['status'] = "Database Connection Failed";
            header('Location: category');
            exit(); // Exit if database connection fails
        }
    }
?>

<!-- |||||||||||||||||||||||||| Insert into Condition Table Data |||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    include_once 'connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_Condition'])) {
        $condition_name = $_POST['condition_name'];
        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');

        // Get the current Indian time
        $current_time = date('Y-m-d H:i:s');

        // Check database connection
        if ($conn) {
            $duplicate = mysqli_query($conn, "SELECT * FROM `conditions` WHERE condition_name='$condition_name'");


            if (mysqli_num_rows($duplicate) > 0) {
                $_SESSION['status'] = "Condition Already <b class='text-danger'>Exists!!</b> $condition_name";
            } else {
                // Updated query to include current timestamp for created_at
                $query = "INSERT INTO `conditions` (condition_name, created_at) VALUES ('$condition_name', '$current_time')";
                $query_run = mysqli_query($conn, $query);
                if ($query_run) {
                    $_SESSION['status'] = "Condition Data Saved <b class='text-light'>Successfully</b>";
                    header('Location: condition');
                } else {
                    $_SESSION['status'] = "Failed To Save Condition Data";
                    header('Location: condition');
                }
            }
        } else {
            $_SESSION['status'] = "Database Connection Failed";
            header('Location: condition');
        }

        exit();
    }
?>

<!-- |||||||||||||||||||||||||| Insert into Brand Table Data |||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    include_once 'connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_brand'])) {
        $brand_title = $_POST['brand_title'];
        $brand_logo = isset($_FILES['brand_logo']['name']) ? $_FILES['brand_logo']['name'] : null;
        $logo_size = isset($_FILES['brand_logo']['size']) ? $_FILES['brand_logo']['size'] : 0;
        $logo_tmp_name = isset($_FILES['brand_logo']['tmp_name']) ? $_FILES['brand_logo']['tmp_name'] : null;

        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');

        // Get the current Indian time
        $current_time = date('Y-m-d H:i:s');

        if ($conn) {
            if (!empty($_FILES['brand_logo']['name'])) {
                $image = $_FILES['brand_logo']['name'];

                $stmt = $conn->prepare("INSERT INTO `brand` 
                    (`brand_title`, `brand_img`, `created_at`)
                    VALUES (?, ?, NOW())");

                // Generate image path
                $path = 'Brand_logo/' . $image;

                // Bind parameters for brand insertion with image
                $stmt->bind_param("ss", $brand_title, $image);
                
                
                // Extensions Info Checking
                $allowed_image_extension = array("png", "jpg", "jpeg");
                $file_extension = pathinfo($image, PATHINFO_EXTENSION);

                if (!in_array($file_extension, $allowed_image_extension)) {
                    $_SESSION['status'] = "Please Insert Only <b class='text-danger'>PNG, JPG, JPEG</b> Extensions Images.";
                    header('Location: brand');
                    exit();
                } elseif ($_FILES['brand_logo']['size'] > 2000000) {
                    $_SESSION['status'] = "Image Size Exceeds <b class='text-danger'>2MB</b>.";
                    header('Location: brand');
                    exit();
                }

                // Move the uploaded file if it exists
                if (!empty($_FILES['brand_logo']['tmp_name'])) {
                    move_uploaded_file($_FILES['brand_logo']['tmp_name'], $path);
                }
            } else {
                // If no brand logo was uploaded, set brand_img column value as NULL
                $stmt = $conn->prepare("INSERT INTO `brand` 
                    (`brand_title`, `brand_img`, `created_at`)
                    VALUES (?, NULL, ?)");

                // Bind parameters for brand insertion without image
                $stmt->bind_param("ss", $brand_title, $current_time);
            }

            // Execute brand insertion query
            if ($stmt->execute()) {
                $_SESSION['status'] = "Brand Data Saved <b class='text-light'>Successfully</b>";
                header('Location: brand');
                exit();
            } else {
                $_SESSION['status'] = "<b class='text-danger'>Failed</b> To Save Brand Data";
                header('Location: brand');
                exit();
            }
        } else {
            $_SESSION['status'] = "Database Connection Failed";
            header('Location: brand');
            exit();
        }
    }

?>

<!-- |||||||||||||||||||||||||| Insert into Product Table Data |||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';

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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_Product'])) {
        // Assuming these values are received from the form
        $brand = $_POST['brand'] ?? '';
        $category = $_POST['category'] ?? '';
        $qty = $_POST['qty'] ?? '';
        $product_name = $_POST['product_name'] ?? '';
        $condition_name = $_POST['condition_name'] ?? '';
        $imeiNumbers = $_POST['imei_numbers'] ?? '';
        $original_price = $_POST['original_price'] ?? '';
        $selling_price = $_POST['selling_price'] ?? '';
        $image = $_FILES['product_img']['name'] ?? '';
        $status = "1";
    
        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');

        // Get the current Indian time
        $current_time = date('Y-m-d H:i:s');

        // Database connection check
        if ($conn) {
            if (!empty($_FILES['product_img']['name'])) {
                $image = $_FILES['product_img']['name'];
    
                $stmt = $conn->prepare("INSERT INTO `products` 
                (`product_code`, `category_title`, `brand_title`, `product_name`, `condition_name`, `original_price`, `selling_price`, `image`, `qty`, `status`, `created_at`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
                // Generate product code and image path
                $productCode = generateNextProductCode($conn);
                $path = 'Product_img/' . $image;
    
                // Bind parameters for product insertion with image
                $stmt->bind_param("sssssssssis", $productCode, $category, $brand, $product_name, $condition_name, $original_price, $selling_price, $image, $qty, $status, $current_time);
            } else {
                // If no image was uploaded, exclude the image column from the SQL query and its binding
                $stmt = $conn->prepare("INSERT INTO `products` 
                    (`product_code`, `category_title`, `brand_title`, `product_name`, `condition_name`, `original_price`, `selling_price`, `qty`, `status`, `created_at`)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
                // Generate product code
                $productCode = generateNextProductCode($conn);
    
                // Bind parameters for product insertion without image
                $stmt->bind_param("ssssssssis", $productCode, $category, $brand, $product_name, $condition_name, $original_price, $selling_price, $qty, $status, $current_time);
            }
    
            // Execute product insertion query
            if ($stmt->execute()) {
                $lastInsertedProductId = $stmt->insert_id;
    
                // Check if an image was provided and moved successfully or if no image was uploaded
                if ((!empty($_FILES['product_img']['name']) && !empty($_FILES['product_img']['tmp_name']) && move_uploaded_file($_FILES['product_img']['tmp_name'], $path)) || empty($_FILES['product_img']['name'])) {
                    // Handle IMEI numbers if provided
                    if (!empty($imeiNumbers)) {
                        $imeiArray = explode(',', $imeiNumbers);
                        $uniqueIMEIs = array_unique(array_map('trim', $imeiArray)); // Remove duplicates and trim spaces
    
                        foreach ($uniqueIMEIs as $imei) {
                            $imei = trim($imei);
    
                            // Check for duplicate IMEI numbers
                            $duplicate = $conn->prepare("SELECT * FROM `imei_numbers` WHERE imei_number = ?");
                            $duplicate->bind_param("s", $imei);
                            $duplicate->execute();
                            $result = $duplicate->get_result();
    
                            if ($result->num_rows > 0) {
                                $_SESSION['status'] = "IMEI Number Already <b class='text-danger'>Exists!!</b> $imei";
                                header('Location: add-products');
                                exit();
                            } else {
                                // Proceed with the insertion
                                $stmt = $conn->prepare("INSERT INTO `imei_numbers` (`product_id`, `imei_number`, `created_at`) VALUES (?, ?, ?)");
                                $stmt->bind_param("sss", $lastInsertedProductId, $imei, $current_time);
                                if (!$stmt->execute()) {
                                    $_SESSION['status'] = "Failed to save IMEI data: " . $stmt->error;
                                    header('Location: add-products');
                                    exit();
                                }
                            }
                        }
                    }
    
                    // Set success message
                    $_SESSION['status'] = "Product Data Saved <b class='text-light'>Successfully</b>";
                    header('Location: product-list');
                    exit();
                } else {
                    $_SESSION['status'] = "Error moving uploaded file";
                    header('Location: add-products');
                    exit();
                }
            } else {
                $_SESSION['status'] = "Failed To Save Product Data";
                header('Location: add-products');
                exit();
            }
        } else {
            $_SESSION['status'] = "Database Connection Failed";
            header('Location: add-products');
            exit();
        }
    }

?>
         
<!-- |||||||||||||||||||||||||| Insert into Accessory Table Data |||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    include_once 'connection.php';

    function generateNextaccessoryCode($conn) {
        $sql = "SELECT MAX(accessory_code) AS max_code FROM `accessory` WHERE accessory_code LIKE 'SCACC%'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $maxCode = $row['max_code'];
            if ($maxCode !== null) {
                $numericPart = intval(substr($maxCode, 5)) + 1;

                // Check if the numeric part exceeds 99 to switch to three digits
                if ($numericPart > 999) {
                    return 'SCACC' . sprintf('%04d', $numericPart);
                } else if ($numericPart > 99) {
                    return 'SCACC' . sprintf('%03d', $numericPart);
                } else {
                    return 'SCACC' . sprintf('%02d', $numericPart);
                }
            }
        }
        return 'SCACC01';
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_Accessories'])) {
        $brand = $_POST['brand'] ?? '';
        $category = $_POST['category'] ?? '';
        $qty = $_POST['qty'] ?? '';
        $accessory_name = $_POST['accessory_name'] ?? '';
        $slug = $_POST['slug'] ?? '';
        $condition_name = $_POST['condition_name'] ?? '';
        $original_price = $_POST['original_price'] ?? '';
        $selling_price = $_POST['selling_price'] ?? '';
        $image = $_FILES['accessory_img']['name'] ?? '';
        $status = "1";

        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');

        // Get the current Indian time
        $current_time = date('Y-m-d H:i:s');

        if ($conn) {
            // Check if an image was uploaded
            if (!empty($_FILES['accessory_img']['name'])) {
                $image = $_FILES['accessory_img']['name'];
    
                // Prepare the accessory insertion query with the image column included
                $stmt = $conn->prepare("INSERT INTO `accessory` 
                    (`accessory_code`, `category_title`, `brand_title`, `accessory_name`, `slug`, `condition_name`, `original_price`, `selling_price`, `image`, `acc_qty`, `status`, `created_at`)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
                // Generate accessory code and image path
                $accessoryCode = generateNextAccessoryCode($conn);
                $path = 'Product_img/' . $image;
    
                // Bind parameters for accessory insertion with image
                $stmt->bind_param("ssssssssssis", $accessoryCode, $category, $brand, $accessory_name, $slug, $condition_name, $original_price, $selling_price, $image, $qty, $status, $current_time);
            } else {
                // If no image was uploaded, exclude the image column from the SQL query and its binding
                $stmt = $conn->prepare("INSERT INTO `accessory` 
                    (`accessory_code`, `category_title`, `brand_title`, `accessory_name`, `slug`, `condition_name`, `original_price`, `selling_price`, `acc_qty`, `status`, `created_at`)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
                // Generate accessory code
                $accessoryCode = generateNextAccessoryCode($conn);
    
                // Bind parameters for accessory insertion without image
                $stmt->bind_param("sssssssssis", $accessoryCode, $category, $brand, $accessory_name, $slug, $condition_name, $original_price, $selling_price, $qty, $status, $current_time);
            }
    
            // Execute accessory insertion query
            if ($stmt->execute()) {
                $lastInsertedAccessoryId = $stmt->insert_id;
    
                // Check if an image was provided and moved successfully or if no image was uploaded
                if ((!empty($_FILES['accessory_img']['name']) && !empty($_FILES['accessory_img']['tmp_name']) && move_uploaded_file($_FILES['accessory_img']['tmp_name'], $path)) || empty($_FILES['accessory_img']['name'])) {
                    // Set success message
                    $_SESSION['status'] = "Accessory Data Saved <b class='text-light'>Successfully</b>";
                    header('Location: product-list');
                    exit();
                } else {
                    $_SESSION['status'] = "Error moving uploaded file";
                    header('Location: add-accessories');
                    exit();
                }
            } else {
                $_SESSION['status'] = "Failed To Save Accessory Data";
                header('Location: add-accessories');
                exit();
            }
        } else {
            $_SESSION['status'] = "Database Connection Failed";
            header('Location: add-accessories');
            exit();
        }
    }

?>