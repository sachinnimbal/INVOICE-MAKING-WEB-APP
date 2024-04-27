<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  include_once 'connection.php';

    // Query to fetch shop details
    $shop_query = "SELECT `shop_id`, `shop_name`, `shop_slogon`, `shop_gstin`, `shop_address`, `shop_pincode`, `shop_email`, `shop_phone1`, `shop_phone2`, 
    `exchange_note1`, `exchange_note2`, `exchange_note3`, `note_1` , `note_2`, `note_3` FROM `shop` LIMIT 1";
    $shop_result = mysqli_query($conn, $shop_query);
    $shop_row = mysqli_fetch_assoc($shop_result);
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>404 Error - Seconds Choice</title>
    <link href="./assets/images/logo.png" rel="icon">
    <link href="./assets/images/favicon.png" rel="apple-touch-icon">
	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:900" rel="stylesheet">
    <style>

        * {
        -webkit-box-sizing: border-box;
                box-sizing: border-box;
        }

        body {
        padding: 0;
        margin: 0;
        }

        #notfound {
        position: relative;
        height: 100vh;
        }

        #notfound .notfound {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
        }

        .notfound {
        max-width: 520px;
        width: 100%;
        line-height: 1.4;
        text-align: center;
        }

        .notfound .notfound-404 {
        position: relative;
        height: 240px;
        }

        .notfound .notfound-404 h1 {
        font-family: 'Montserrat', sans-serif;
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
        font-size: 252px;
        font-weight: 900;
        margin: 0px;
        color: #262626;
        text-transform: uppercase;
        letter-spacing: -40px;
        margin-left: -20px;
        }

        .notfound .notfound-404 h1>span {
        text-shadow: -8px 0px 0px #fff;
        }

        .notfound .notfound-404 h3 {
        font-family: 'Cabin', sans-serif;
        position: relative;
        font-size: 16px;
        font-weight: 700;
        text-transform: uppercase;
        color: #262626;
        margin: 0px;
        letter-spacing: 3px;
        padding-left: 6px;
        }

        .notfound h2 {
        font-family: 'Cabin', sans-serif;
        font-size: 20px;
        font-weight: 400;
        text-transform: uppercase;
        color: #000;
        margin-top: 0px;
        margin-bottom: 25px;
        }

        @media only screen and (max-width: 767px) {
        .notfound .notfound-404 {
            height: 200px;
        }
        .notfound .notfound-404 h1 {
            font-size: 200px;
        }
        }

        @media only screen and (max-width: 480px) {
        .notfound .notfound-404 {
            height: 162px;
        }
        .notfound .notfound-404 h1 {
            font-size: 162px;
            height: 150px;
            line-height: 162px;
        }
        .notfound h2 {
            font-size: 16px;
        }
        }


    </style>

    <link href="./assets/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/dist/css/adminlte.min.css">

</head>

<body>

	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h3>Oops! Page not found</h3>
				<h1><span>4</span><span>0</span><span>4</span></h1>
			</div>
			<h2>SORRY BUT THE PAGE YOU ARE LOOKING FOR DOES NOT EXIST, HAVE BEEN REMOVED. NAME CHANGED OR IS TEMPORARILY UNAVAILABLE.</h2>
            <a class="btn btn-primary" href="https://www.instagram.com/secondschoice2023"><i class="bi bi-instagram mr-3"></i>Contact Us For Enquiry</a>
		</div>
	</div>

    <footer class="fixed-bottom text-center bg-light">
        <div class="credits p-3">Copyright &copy;<strong><span class="ml-1 mr-1" id="currentYear">
            </span><span class="text-dark">Seconds <span class="text-danger">Choice</span></span></strong>
            <span class="text-muted"><br>All Rights Reserved</span>
            <span class="text-muted px-2">|</span>
            <?php echo $shop_row['shop_email']; ?>
            <span class="text-muted">|</span>
            +91<?php echo $shop_row['shop_phone1']; ?>
            <span class="text-muted">|</span>
            +91<?php echo $shop_row['shop_phone2']; ?>
        </div>
      </footer>

    <script>
        document.getElementById("currentYear").textContent = new Date().getFullYear();
    </script>

</body>

</html>
