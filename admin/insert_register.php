<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    include_once 'connection.php';

    if(isset($_POST['button_Register'])) {

        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
        $pass = mysqli_real_escape_string($conn, md5($_POST['new_password']));
        $c_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));
        $profile = $_FILES['profile']['name'];
        $profile_size = $_FILES['profile']['size'];
        $profile_tmp_name = $_FILES['profile']['tmp_name'];

        $path = 'Profile_img/'.$profile;

        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');

        // Get the current Indian time
        $current_time = date('Y-m-d H:i:s');

        // Extensions Info Checking
        $allowed_image_extension = array("png","jpg","jpeg");
        $file_extension = pathinfo($_FILES['profile']['name'],PATHINFO_EXTENSION);

            // Duplicate Info Checking
            $duplicate=mysqli_query($conn, "SELECT * FROM Users where username='$username'");
            $duplicate1=mysqli_query($conn, "SELECT * FROM Users where email='$email'");
            $duplicate2=mysqli_query($conn, "SELECT * FROM Users where mobile='$mobile'");

            if (mysqli_num_rows($duplicate)>0){
                $_SESSION['status'] = "Username Name Already <b class='text-danger'>Exists!!</b> $username";
                header('Location: register');
            }
            else if (mysqli_num_rows($duplicate1)>0){
                $_SESSION['status'] = "Email Address Already <b class='text-danger'>Exists!!</b> $email";
                header('Location: register');
            }
            else if (mysqli_num_rows($duplicate2)>0){
                $_SESSION['status'] = "Mobile Number Already <b class='text-danger'>Exists!!</b> $mobile";
                header('Location: register');
            }else{ 
            if($pass != $c_pass){
                $_SESSION['status'] = "Confirm Password not <b class='text-danger'>Matched!!</b>";
                header('Location: register');
            }else 
            if (! in_array($file_extension, $allowed_image_extension)){
                $_SESSION['status'] = "Please Insert Only <b class='text-danger'>PNG, JPG, JPEG</b> Extensions Images.";
                header('Location: register');
            }else if($profile_size > 2000000){
                $_SESSION['status'] = "Image Size Exceeds <b class='text-danger'>2MB</b>.";
                header('Location: register');
            }else{
                $insert = mysqli_query($conn, "INSERT INTO `Users`(name,username,email,mobile,password,profile, created_at) VALUES
                ('$name','$username','$email','$mobile','$pass','$profile', '$current_time')");

                if($insert){
                    move_uploaded_file($profile_tmp_name, $path);
                    $_SESSION['status'] = "New User Registered <b class='text-light'>Successfully</b>";
                    header('Location: register');
                    
                }else{
                    $_SESSION['status'] = "Registration <b class='text-danger'>Failed</b>";
                    header('Location: register');
                }
            }
        }
    }
?>