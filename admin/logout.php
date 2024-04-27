<?php
session_start();

if (isset($_SESSION['id'])) {
    // Set the timezone to Indian Standard Time (IST)
    date_default_timezone_set('Asia/Kolkata');

    // Get the current time in IST
    $logout_time = date('Y-m-d H:i:s');

    // Get the user ID
    $user_id = $_SESSION['id'];

    // Update the logout time in the login_activity table
    include_once 'connection.php';
    $update_logout_time = mysqli_query($conn, "UPDATE `login_activity` SET logout_time = '$logout_time' WHERE user_id = '$user_id'");

    // Unset all of the session variables
    $_SESSION = array();
    
    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("location: https://secondschoice.co.in/"); 
    exit();
} else {
    header("location: https://secondschoice.co.in/"); 
    exit();
}
?>
