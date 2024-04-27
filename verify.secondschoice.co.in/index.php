<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../admin/connection.php';
session_start();

// Query to fetch shop details
$shop_query = "SELECT `shop_id`, `shop_name`, `shop_slogon`, `shop_gstin`, `shop_address`, `shop_pincode`, `shop_email`, `shop_phone1`, `shop_phone2`, 
`exchange_note1`, `exchange_note2`, `exchange_note3`, `note_1` , `note_2`, `note_3` FROM `shop` LIMIT 1";
$shop_result = mysqli_query($conn, $shop_query);
$shop_row = mysqli_fetch_assoc($shop_result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Seconds Choice - Invoice Page</title>
  <!-- Favicons -->
  <link href="./assets/images/logo.png" rel="icon">
  <link href="./assets/images/favicon.png" rel="apple-touch-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="./assets/plugins/fontawesome-free/css/all.min.css">
  <link href="./assets/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <!-- DataTables -->
  <link rel="stylesheet" href="./assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="./assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./assets/dist/css/adminlte.min.css">

  <style>
    .icon {
      display: inline-block;
      width: 20px;
      height: 20px;
      vertical-align: middle;
    }
    .body{
        background-color: #333;
        color: #fff;        
    }
  </style>
</head>

<body class="body hold-transition">
    
    <div class="container">
              <?php 
                    if (isset($_SESSION['status'])) { ?>
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Hello !</strong> <?= $_SESSION['status'] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    <?php
                        unset($_SESSION['status']);
                    } 
              ?>
        <section class="content-header">
            <div class="col-sm-12">
                <h1 class="text-center">Verify Your Invoice</h1>
            </div>
        </section>
        <div class="row mb-2">  
            <div class="col-lg-8 mx-auto">  
                <h2 class="font-weight-light font-italic"></h2>  
                <div class="rounded shadow">  
                    <form id="searchForm" method="GET" enctype="multipart/form-data">  
                        <div class="input-group">  
                            <input type="search" name="verify_invoice" id="verify_invoice" placeholder="Please Enter Your Invoice Verify ID...." aria-describedby="button-addon5" class="form-control" required>  
                            <div class="input-group-append">  
                                <button id="button-addon5" type="submit" class="btn btn-primary"> <i class="fa fa-search"> </i> </button>  
                            </div>  
                        </div>  
                    </form>
              </div>  
            </div>  
        </div> 
         <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Need Help ..?</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
                <img src="./assets/images/invoicePage.jpg" alt="Help?" class="img img-fluid">
            </div>
             /.card-body 
          </div>
        
    </div>

    <footer class="fixed-bottom text-center bg-dark p-2">
        <strong>
            <?php echo ucwords($shop_row['shop_name']); ?>
        </strong>
        <span class="text-slate-300 px-2">|</span>
        <?php echo $shop_row['shop_email']; ?>
        <span class="text-slate-300 px-2">|</span>
        +91<?php echo $shop_row['shop_phone1']; ?>
        <span class="text-slate-300 px-2">|</span>
        +91<?php echo $shop_row['shop_phone2']; ?>
        <span class="text-slate-300 px-2">|</span>
        <a class="bi bi-instagram hide-on-Desktop" href="https://www.instagram.com/secondschoice2023"></a>
        <div class="credits">
            Copyright &copy;<strong><span class="ml-1 mr-1" id="currentYear"></span><span class="text-black">Seconds <span class="text-success">Choice</span></span></strong>
            <span class="text-light">All Rights Reserved</span>
        </div>
    </footer>
    
    <script>
        document.getElementById("currentYear").textContent = new Date().getFullYear();
    </script>
    <!-- jQuery -->
    <script src="./assets/plugins/jquery/jquery.min.js"></script>
    <script src="./assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    
    <!-- Bootstrap 4 -->
    <script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="./assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="./assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="./assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="./assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="./assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="./assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="./assets/plugins/jszip/jszip.min.js"></script>
    <script src="./assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="./assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="./assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="./assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="./assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./assets/dist/js/adminlte.min.js"></script>
    <script>
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            // Prevent the form from submitting initially
            event.preventDefault();

            // Get the entered verify_invoice value
            const verifyInvoice = document.getElementById('verify_invoice').value.trim();

            // Check if the verify_invoice starts with "SCINV"
            if (verifyInvoice.toUpperCase().startsWith("SCINV")) {
                // If it does, set the form action to "invoice-page.php"
                this.action = "invoice-page";
            } else {
                // If it doesn't, set the form action to "exchange-page.php"
                this.action = "exchange-page";
            }

            // Now submit the form with the updated action
            this.submit();
        });
    </script>
</body>

</html>