<?php
$server_name = "localhost";
$db_username = "secondsc_SecondsChoice_db";
$pw = "Skn1631$$";
$db = "secondsc_SecondsChoice_db";

$conn = mysqli_connect($server_name, $db_username, $pw, $db);

if (!$conn) {
    // If connection fails, display an error message
    echo '
        <div class="container">
            <div class="row">
                <div class="col-md-8 mr-auto ml-auto text-center py-5 mt-5">
                    <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Database Connection Failed !</h5>
                    <p>Please Check Your Database Connection :(</p>
                </div>
            </div>
        </div>
    ';
    // Terminate script execution after displaying the error message
    die("Connection Failed: " . mysqli_connect_error());
}

try {
    $pdo = new PDO("mysql:host=$server_name;dbname=$db", $db_username, $pw);
    // Set PDO attributes if needed (optional)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Other configurations...
} catch (PDOException $e) {
    // Display an error message if PDO connection fails
    echo "PDO Connection failed: " . $e->getMessage();
    die(); // Terminate script execution
}

?>


