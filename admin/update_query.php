<!-- ||||||||||||||||||||||||||||||| Update into Category Table Data ||||||||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    if (isset($_POST['update_Category'])) {
        $category_id = $_POST['category_id'];
        $category_title = mysqli_real_escape_string($conn, $_POST['update_category_title']);
            
        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');

        // Get the current Indian time
        $current_time = date('Y-m-d H:i:s');

        $sql = "UPDATE category SET 
                category_title = '$category_title',
                updated_at = '$current_time'
                WHERE category_id = '$category_id'";

        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            $_SESSION['status'] = "Category Data Updated <b class='text-light'>Successfully</b>";
            header("Location: category");
            exit();
        } else {
            $_SESSION['status'] = "Category Details Update <b class='text-danger'>Failed!!</b>";
            header("Location: category");
            $_SESSION['status'] = "Error updating record: " . mysqli_error($conn);
        }
    }
?>

<!-- ||||||||||||||||||||||||||||||| Update into Condition Table Data ||||||||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    if (isset($_POST['update_Condition'])) {
        $condition_id = $_POST['condition_id'];
        $condition_name = mysqli_real_escape_string($conn, $_POST['update_condition_name']);

        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');

        // Get the current Indian time
        $current_time = date('Y-m-d H:i:s');

        $sql = "UPDATE conditions SET 
                condition_name = '$condition_name',
                updated_at = '$current_time'
                WHERE condition_id = '$condition_id'";

        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            $_SESSION['status'] = "Condition Data Updated <b class='text-light'>Successfully</b>";
            header("Location: condition");
            exit();
        } else {
            $_SESSION['status'] = "Condition Details Update <b class='text-danger'>Failed!!</b>";
            header("Location: condition");
            $_SESSION['status'] = "Error updating record: " . mysqli_error($conn);
        }
    }
?>

<!-- ||||||||||||||||||||||||||||||| Update into Brand Table Data ||||||||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    if (isset($_POST['update_Brand'])) {
        $brand_id = $_POST['brand_id'];
        $brand_title = mysqli_real_escape_string($conn, $_POST['update_brand_title']);

        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');

        // Get the current Indian time
        $current_time = date('Y-m-d H:i:s');

        // Handle file upload for brand logo
        if ($_FILES['update_brand_logo']['name'] != '') {
            // Fetch previous brand logo file name
            $sql_fetch_image = "SELECT brand_img FROM `brand` WHERE brand_id = '$brand_id'";
            $result_fetch_image = mysqli_query($conn, $sql_fetch_image);
            if ($result_fetch_image && mysqli_num_rows($result_fetch_image) > 0) {
                $row = mysqli_fetch_assoc($result_fetch_image);
                $previous_image = $row['brand_img'];

                // Delete previous image from storage
                if (file_exists("Brand_logo/" . $previous_image)) {
                    unlink("Brand_logo/" . $previous_image);
                }
            }

            // File upload for updated brand logo
            $brand_logo = $_FILES['update_brand_logo']['name'];
            $brand_logo_temp = $_FILES['update_brand_logo']['tmp_name'];
            $brand_logo_destination = "Brand_logo/" . $brand_logo;

            move_uploaded_file($brand_logo_temp, $brand_logo_destination);

            // Update brand details along with the new logo file name
            $sql = "UPDATE `brand` SET 
                    brand_title = '$brand_title',
                    brand_img = '$brand_logo',
                    updated_at = '$current_time'
                    WHERE brand_id = '$brand_id'";
        } else {
            // Update brand details without changing the logo
            $sql = "UPDATE `brand` SET 
                    brand_title = '$brand_title',
                    updated_at = '$current_time'
                    WHERE brand_id = '$brand_id'";
        }

        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            $_SESSION['status'] = "Brand Data Updated <b class='text-light'>Successfully</b>";
            header("Location: brand");
            exit();
        } else {
            $_SESSION['status'] = "Brand Details Update <b class='text-danger'>Failed!!</b>";
            header("Location: brand");
            $_SESSION['status'] = "Error updating record: " . mysqli_error($conn);
        }
    }
?>

<!-- ||||||||||||||||||||||||||||||| Update into Customer Table Data ||||||||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    if (isset($_POST['update_Customer'])) {
        $customer_id = $_POST['customer_id'];
        $customer_name = mysqli_real_escape_string($conn, $_POST['update_customer_name']);
        $phone = mysqli_real_escape_string($conn, $_POST['update_phone']);
        $address = mysqli_real_escape_string($conn, $_POST['update_address']);

        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');

        // Get the current Indian time
        $current_time = date('Y-m-d H:i:s');

        $sql = "UPDATE `customers` SET 
                full_name = '$customer_name',
                phone = '$phone',
                address = '$address',
                updated_at = '$current_time'
                WHERE customer_id = '$customer_id'";

        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            $_SESSION['status'] = "Customer Data Updated <b class='text-light'>Successfully</b>";
            header("Location: customer");
            exit();
        } else {
            $_SESSION['status'] = "Customer Details Update <b class='text-danger'>Failed!!</b>";
            header("Location: customer");
            $_SESSION['status'] = "Error updating record: " . mysqli_error($conn);
        }
    }
?>

<!-- ||||||||||||||||||||||||||||||| Update into Shop Table Data ||||||||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();
    
    if (isset($_POST['update_Shop'])) {
        $shop_id = $_POST['shop_id'];
        $shop_name = mysqli_real_escape_string($conn, $_POST['shop_name']);
        $shop_slogon = mysqli_real_escape_string($conn, $_POST['shop_slogon']);
        $shop_gstin = mysqli_real_escape_string($conn, $_POST['shop_gstin']);
        $shop_address = mysqli_real_escape_string($conn, $_POST['shop_address']);
        $shop_pincode = mysqli_real_escape_string($conn, $_POST['shop_pincode']);
        $shop_email = mysqli_real_escape_string($conn, $_POST['shop_email']);
        $shop_phone1 = mysqli_real_escape_string($conn, $_POST['shop_phone1']);
        $shop_phone2 = mysqli_real_escape_string($conn, $_POST['shop_phone2']);
        $note_1 = mysqli_real_escape_string($conn, $_POST['note_1']);
        $note_2 = mysqli_real_escape_string($conn, $_POST['note_2']);
        $note_3 = mysqli_real_escape_string($conn, $_POST['note_3']);
        $exchange_note1 = mysqli_real_escape_string($conn, $_POST['exchange_note1']);
        $exchange_note2 = mysqli_real_escape_string($conn, $_POST['exchange_note2']);
        $exchange_note3 = mysqli_real_escape_string($conn, $_POST['exchange_note3']);
        
        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');

        // Get the current Indian time
        $current_time = date('Y-m-d H:i:s');

        // Validation
        $errors = [];
    
        // Indian mobile number validation (phone1 and phone2 should not be the same)
        if (!preg_match('/^\d{10}$/', $shop_phone1) || !preg_match('/^\d{10}$/', $shop_phone2)) {
            $errors[] = "Please enter valid 10-digit Indian mobile numbers for phone1 and phone2.";
        } elseif ($shop_phone1 === $shop_phone2) {
            $errors[] = "Phone numbers (phone1 and phone2) cannot be the same.";
        }
    
        // Indian pincode format validation (585-224 like this format with 7 length only)
        if (!preg_match('/^\d{3}-\d{3}$/', $shop_pincode)) {
            $errors[] = "Please enter the pincode in the format 'XXX-XXX' (e.g., 585-224) with 7 characters.";
        }
    
        // Email validation
        if (!filter_var($shop_email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email address.";
        }
    
        // GSTIN validation
        if (!preg_match('/^\d{2}[A-Z]{5}\d{4}[A-Z]{1}\d{1}[A-Z]{1}\d{1}$/', $shop_gstin)) {
            $errors[] = "Please enter a valid Indian GSTIN (e.g., 29AABMS0175C3Z6).";
        }
    
    
        if (empty($errors)) {
            // Proceed with updating the database
            $sql = "UPDATE `shop`
                    SET 
                        `shop_name` = '$shop_name',
                        `shop_slogon` = '$shop_slogon',
                        `shop_gstin` = '$shop_gstin',
                        `shop_address` = '$shop_address',
                        `shop_pincode` = '$shop_pincode',
                        `shop_email` = '$shop_email',
                        `shop_phone1` = '$shop_phone1',
                        `shop_phone2` = '$shop_phone2',
                        `note_1`='$note_1', 
                        `note_2`='$note_2', 
                        `note_3`='$note_3',
                        `exchange_note1`='$exchange_note1', 
                        `exchange_note2`='$exchange_note2',
                        `exchange_note3`='$exchange_note3'
                    WHERE `shop_id` = '$shop_id'";
    
            $query_run = mysqli_query($conn, $sql);
    
            if ($query_run) {
                $_SESSION['status'] = "Shop Data Updated <b class='text-light'>Successfully</b>";
                header("Location: profile");
                exit();
            } else {
                $_SESSION['status'] = "Failed to update Shop Details: " . mysqli_error($conn);
                header("Location: profile");
                exit();
            }
        } else {
            // If there are validation errors, redirect back to the form with error messages
            $_SESSION['status'] = implode("<br>", $errors);
            header("Location: profile");
            exit();
        }
    }
?>
    
<!-- ||||||||||||||||||||||||||||||| Update into Product Table Data ||||||||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    if (isset($_POST['update_Product'])) {
        $id = $_POST['id'];
        $update_category = mysqli_real_escape_string($conn, $_POST['update_category']);
        $update_brand = mysqli_real_escape_string($conn, $_POST['update_brand']);
        $update_product_name  = mysqli_real_escape_string($conn, $_POST['update_product_name']);
        $update_condition_name  = mysqli_real_escape_string($conn, $_POST['update_condition_name']);
        $update_original_price = mysqli_real_escape_string($conn, $_POST['update_original_price']);
        $update_selling_price = mysqli_real_escape_string($conn, $_POST['update_selling_price']);
        $update_qty  = mysqli_real_escape_string($conn, $_POST['update_qty']);
        $update_imei_numbers = mysqli_real_escape_string($conn, $_POST['imei_numbers']);

        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');

        // Get the current Indian time
        $current_time = date('Y-m-d H:i:s');

        if (!empty($update_imei_numbers)) {
            $imeiArray = explode(',', $update_imei_numbers);
            $uniqueIMEIs = array_unique(array_map('trim', $imeiArray)); // Remove duplicates and trim spaces
        
            foreach ($uniqueIMEIs as $imei) {
                $imei = preg_replace("/[^0-9]/", "", $imei); // Remove non-numeric characters
                $imei = trim($imei);
        
                if (strlen($imei) !== 15) {
                    continue;
                }
                // Check if the IMEI number already exists for this product
                $duplicate = $conn->prepare("SELECT * FROM `imei_numbers` WHERE product_id = ? AND imei_number = ?");
                $duplicate->bind_param("ss", $id, $imei);
                $duplicate->execute();
                $result = $duplicate->get_result();
        
                if ($result->num_rows > 0) {
                    // The IMEI number already exists, no need to update to the same value
                    continue; // Move to the next iteration
                } else {
                    // Proceed with inserting the new IMEI number
                    $insertStmt = $conn->prepare("INSERT INTO `imei_numbers` (`product_id`, `imei_number`) VALUES (?, ?)");
                    $insertStmt->bind_param("ss", $id, $imei);
                    if (!$insertStmt->execute()) {
                        // Handle the insertion error
                        $_SESSION['status'] = "Failed to insert IMEI data: " . $insertStmt->error;
                        header('Location: product-list');
                        exit();
                    }
                }
            }
        }
        
        
        // Handle file upload for product image
        if ($_FILES['update_product_img']['name'] != '') {
            // Fetch previous product image file name
            $sql_fetch_image = "SELECT image FROM `products` WHERE id = '$id'";
            $result_fetch_image = mysqli_query($conn, $sql_fetch_image);
            if ($result_fetch_image && mysqli_num_rows($result_fetch_image) > 0) {
                $row = mysqli_fetch_assoc($result_fetch_image);
                $previous_image = $row['image'];

                // Delete previous image from storage
                if (file_exists("Product_img/" . $previous_image)) {
                    unlink("Product_img/" . $previous_image);
                }
            }


            // File upload for updated product image 
            $update_product_img = $_FILES['update_product_img']['name'];
            $update_product_img_temp = $_FILES['update_product_img']['tmp_name'];
            $update_product_img_destination = "Product_img/" . $update_product_img;

            move_uploaded_file($update_product_img_temp, $update_product_img_destination);

            // Update brand details along with the new image file name
            $sql = "UPDATE `products` SET 
                    category_title = '$update_category',
                    brand_title = '$update_brand',
                    product_name = '$update_product_name',
                    condition_name = '$update_condition_name',
                    original_price = '$update_original_price',
                    selling_price = '$update_selling_price',
                    image = '$update_product_img',
                    qty = '$update_qty',
                    updated_at = '$current_time'
                    WHERE id = '$id'";
        } else {
            // Update brand details without changing the logo
            $sql = "UPDATE `products` SET 
                    category_title = '$update_category',
                    brand_title = '$update_brand',
                    product_name = '$update_product_name',
                    condition_name = '$update_condition_name',
                    original_price = '$update_original_price',
                    selling_price = '$update_selling_price',
                    qty = '$update_qty',
                    updated_at = '$current_time'
                    WHERE id = '$id'";
        }

        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            $_SESSION['status'] = "Product Data Updated <b class='text-light'>Successfully</b>";
            header("Location: product-list");
            exit();
        } else {
            $_SESSION['status'] = "Product Details Update <b class='text-danger'>Failed!!</b>";
            $_SESSION['error_message'] = "Error updating record: " . mysqli_error($conn);
            header("Location: product-list");
            exit();
        }
    }
?>

<!-- ||||||||||||||||||||||||||||||| Update into Accessory Table Data ||||||||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    if (isset($_POST['update_Accessory'])) {
        $accessory_id = $_POST['accessory_id'];
        $update_category = mysqli_real_escape_string($conn, $_POST['update_category']);
        $update_brand = mysqli_real_escape_string($conn, $_POST['update_brand']);
        $update_accessory_name  = mysqli_real_escape_string($conn, $_POST['update_accessory_name']);
        $update_slug  = mysqli_real_escape_string($conn, $_POST['update_slug']);
        $update_condition_name  = mysqli_real_escape_string($conn, $_POST['update_condition_name']);
        $update_original_price = mysqli_real_escape_string($conn, $_POST['update_original_price']);
        $update_selling_price = mysqli_real_escape_string($conn, $_POST['update_selling_price']);
        $update_qty  = mysqli_real_escape_string($conn, $_POST['update_qty']);

        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');

        // Get the current Indian time
        $current_time = date('Y-m-d H:i:s');

        // Handle file upload for accessory image
        if ($_FILES['update_accessory_img']['name'] != '') {
            // Fetch previous accessory image file name
            $sql_fetch_image = "SELECT image FROM `accessory` WHERE accessory_id = '$accessory_id'";
            $result_fetch_image = mysqli_query($conn, $sql_fetch_image);
            if ($result_fetch_image && mysqli_num_rows($result_fetch_image) > 0) {
                $row = mysqli_fetch_assoc($result_fetch_image);
                $previous_image = $row['image'];

                // Delete previous image from storage
                if (file_exists("Product_img/" . $previous_image)) {
                    unlink("Product_img/" . $previous_image);
                }
            }

            // File upload for updated accessory image 
            $update_accessory_img = $_FILES['update_accessory_img']['name'];
            $update_accessory_img_temp = $_FILES['update_accessory_img']['tmp_name'];
            $update_accessory_img_destination = "Product_img/" . $update_accessory_img;

            move_uploaded_file($update_accessory_img_temp, $update_accessory_img_destination);

            // Update brand details along with the new image file name
            $sql = "UPDATE `accessory` SET 
                    category_title = '$update_category',
                    brand_title = '$update_brand',
                    accessory_name = '$update_accessory_name',
                    slug = '$update_slug',
                    condition_name = '$update_condition_name',
                    original_price = '$update_original_price',
                    selling_price = '$update_selling_price',
                    image = '$update_accessory_img',
                    acc_qty = '$update_qty',
                    updated_at = '$current_time'
                    WHERE accessory_id = '$accessory_id'";
        } else {
            // Update brand details without changing the logo
            $sql = "UPDATE `accessory` SET 
                    category_title = '$update_category',
                    brand_title = '$update_brand',
                    accessory_name = '$update_accessory_name',
                    slug = '$update_slug',
                    condition_name = '$update_condition_name',
                    original_price = '$update_original_price',
                    selling_price = '$update_selling_price',
                    acc_qty = '$update_qty',
                    updated_at = '$current_time'
                    WHERE accessory_id = '$accessory_id'";
        }

        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            $_SESSION['status'] = "Accessory Data Updated <b class='text-light'>Successfully</b>";
            header("Location: product-list");
            exit();
        } else {
            $_SESSION['status'] = "Accessory Details Update <b class='text-danger'>Failed!!</b>";
            $_SESSION['error_message'] = "Error updating record: " . mysqli_error($conn);
            header("Location: product-list");
            exit();
        }
    }
?>

<!-- ||||||||||||||||||||||||||||||| Update Profile Data ||||||||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();
    if (isset($_POST['update_Profile'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $name = mysqli_real_escape_string($conn, $_POST['U_name']);
        $email = mysqli_real_escape_string($conn, $_POST['U_email']);
        $mobile = mysqli_real_escape_string($conn, $_POST['U_mobile']);

        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');

        // Get the current Indian time
        $current_time = date('Y-m-d H:i:s');

        $query = "UPDATE `Users` 
        SET name='$name', email='$email', mobile='$mobile', updated_at='$current_time' WHERE id='$id'";

        $query_run = mysqli_query($conn, $query);
        if ($query_run) {
            $_SESSION['status'] = "Profile Details Updated <b class='text-light'>Successfully</b>";
            header("Location: profile");
            exit();
        } else {
            $_SESSION['status'] = "Profile Details Update <b class='text-danger'>Failed</b>";
            header("Location: profile");
            exit();
        }
    }
?>

<!-- ||||||||||||||||||||||||||||||| Update Password ||||||||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    // Change Password code
    if (isset($_POST['update_Password'])) {
    $id = $_POST['id'];
    $old_pass = $_POST['old_Password'];
    $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
    $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_password']));
    $c_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));

    // Set the timezone to Indian Standard Time (IST)
    date_default_timezone_set('Asia/Kolkata');

    // Get the current Indian time
    $current_time = date('Y-m-d H:i:s');

    if (!empty($update_pass) || !empty($new_pass) || !empty($c_pass)) {
        if ($update_pass != $old_pass) {
            $_SESSION['status'] =  "Old Password Not <b class='text-danger'>Matched!!</b>";
            header("Location: profile");
            exit();
        } else if ($new_pass != $c_pass) {
            $_SESSION['status'] =  "Confirm Password Not <b class='text-danger'>Matched!!</b>";
            header("Location: profile");
            exit();
        } else {
            mysqli_query($conn, "UPDATE `Users` SET password='$c_pass', updated_at='$current_time'  WHERE id='$id'");
            $_SESSION['status'] =  "Password Updated <b class='text-light'>Successfully!!</b>";
            header("Location: profile");
            exit();
        }
    }
    }
?>

<!-- ||||||||||||||||||||||||||||||| Update Security ||||||||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    if (isset($_POST['update_Security'])) {
        $id = $_POST['id'];
        $securityHint = $_POST['securityHint'];
        $hintAnswer = mysqli_real_escape_string($conn, md5($_POST['hint_answer']));

        $sql = "UPDATE Users SET hint = :securityHint, answer = :hintAnswer WHERE id = :id";
        // Prepare the statement
        $stmt = $pdo->prepare($sql);
        // Bind parameters
        $stmt->bindParam(':securityHint', $securityHint);
        $stmt->bindParam(':hintAnswer', $hintAnswer);
        $stmt->bindParam(':id', $id);
        // Execute the update
        $query_run = $stmt->execute();
        
        // Check if the query was successful or not
        if ($query_run) {
            $_SESSION['status'] = "Hint Updated <b class='text-light'>Successfully</b>";
            header("Location: profile");
            exit();
        } else {
            $_SESSION['status'] = "Hint Update <b class='text-danger'>Failed!!</b>";
            $_SESSION['status'] .= "Error updating record: " . $stmt->errorInfo()[2]; // Updated line
            header("Location: profile");
            exit();
        }
    }
?>

<!-- ||||||||||||||||||||||||||||||| Profile Picture ||||||||||||||||||||||||||||||| -->
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'connection.php';
    session_start();

    // Profile Picture Update
    if (isset($_FILES["fileImg"]["name"])) {

    $id = $_POST['id'];
    
    // Set the timezone to Indian Standard Time (IST)
    date_default_timezone_set('Asia/Kolkata');

    // Get the current Indian time
    $current_time = date('Y-m-d H:i:s');

    $src = $_FILES['fileImg']['tmp_name'];
    $name = uniqid() . $_FILES["fileImg"]["name"];
    $size = $_FILES['fileImg']['size'];
    $old = $_POST['old'];

    // Extensions Info Checking
    $allowed_image_extension = array("png", "jpg", "jpeg");
    $file_extension = pathinfo($_FILES['fileImg']['name'], PATHINFO_EXTENSION);

    $target = "Profile_img/" . $name;
    if (($_FILES['fileImg']['size'] > 2000000)) {
        $_SESSION['status'] = "Image Size Exceeds <b class='text-danger'>2MB</b>.";
        header("Location: profile");
        exit();
    } else if (!in_array($file_extension, $allowed_image_extension)) {
        $_SESSION['status'] = "Please Insert Only <b class='text-danger'>PNG, JPG, JPEG</b> Extensions Images.";
        header("Location: profile");
        exit();
    } else {
        unlink("Profile_img/" . $old);
        move_uploaded_file($src, $target);

        $query = "UPDATE Users SET profile = '$name', updated_at='$current_time'  WHERE id='$id'";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $_SESSION['status'] = "Profile Picture Updated <b class='text-light'>Successfully!!</b>";
            header("Location: profile");
            exit();
        } else {
            $_SESSION['status'] = "Profile Picture Update <b class='text-danger'>Failed</b>";
            header("Location: profile");
            exit();
        }
    }
    }
?>