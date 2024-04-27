<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
  include '../admin/connection.php';
  
    // Query to fetch shop details
    $shop_query = "SELECT `shop_id`, `shop_name`, `shop_slogon`, `shop_gstin`, `shop_address`, `shop_pincode`, `shop_email`, `shop_phone1`, `shop_phone2`, 
    `exchange_note1`, `exchange_note2`, `exchange_note3`, `note_1` , `note_2`, `note_3` FROM `shop` LIMIT 1";
    $shop_result = mysqli_query($conn, $shop_query);
    $shop_row = mysqli_fetch_assoc($shop_result);

      if (isset($_GET['verify_invoice'])) {
          $verify_invoice = $_GET['verify_invoice'];
          // Use $exchange_id in your SQL query
          $exchange_query = "SELECT 
              ep.`exchange_id`, ep.`customer_id`, ep.`verify_invoice` , ep.`exchange_code`, ep.`exchange_order_reference`, 
              ep.`date`, ep.`exchange_category`, ep.`exchange_brand`, ep.`exchange_condition_name`, 
              ep.`exchange_product_name`, ep.`exchange_qty`, ep.`exchange_imei_number`, ep.`exchange_purchase_price`, ep.`total_price_words`,
              ep.`customer_IdType`, c.`full_name` AS 'customer_full_name', 
              c.`phone` AS 'customer_phone', 
              c.`address` AS 'customer_address'
              FROM 
                  `exchange_product` ep
              INNER JOIN 
                  `customers` c ON ep.`customer_id` = c.`customer_id`
              WHERE 
                  ep.`verify_invoice` = '$verify_invoice'";
    
          $result = mysqli_query($conn, $exchange_query);
    
            if ($result && mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_assoc($result);
            } else {
                // If no data is found, set a session message and redirect
                $_SESSION['status'] = "No data found for the provided Verify Invoice ID.";
                header("Location: index"); // Redirect to index.php or another appropriate page
                exit();
            }
        } else {
            // If verify_invoice is not set, also set a session message and redirect
            $_SESSION['status'] = "Verify Invoice ID is required.";
            header("Location: index");
            exit();
        }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Seconds Choice - Exchange Page</title>
  <link href="./assets/images/logo.png" rel="icon">
  <link href="./assets/images/favicon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="./assets/invoice.css">
  <link href="./assets/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <style>
        .responsive-table-container {
          overflow-x: auto;
        }
    
        .ribbon-wrapper {
          height: 70px;
          overflow: hidden;
          position: absolute;
          right: -2px;
          top: -2px;
          width: 70px;
          z-index: 10;
        }
        .ribbon-wrapper.ribbon-lg {
          height: 120px;
          width: 120px;
        }
        .ribbon-wrapper.ribbon-lg .ribbon {
          right: 0;
          top: 26px;
          width: 160px;
        }
        .ribbon-wrapper.ribbon-xl {
          height: 180px;
          width: 180px;
        }
        .ribbon-wrapper.ribbon-xl .ribbon {
          right: 4px;
          top: 47px;
          width: 240px;
        }
        .ribbon-wrapper .ribbon {
          box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
          font-size: 0.8rem;
          line-height: 100%;
          padding: 0.375rem 0;
          position: relative;
          right: -2px;
          text-align: center;
          text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.4);
          text-transform: uppercase;
          top: 10px;
          -webkit-transform: rotate(45deg);
          transform: rotate(45deg);
          width: 90px;
        }
        .ribbon-wrapper .ribbon::after,
        .ribbon-wrapper .ribbon::before {
          border-left: 3px solid transparent;
          border-right: 3px solid transparent;
          border-top: 3px solid #9e9e9e;
          bottom: -3px;
          content: "";
          position: absolute;
        }
        .ribbon-wrapper .ribbon::before {
          left: 0;
        }
        .ribbon-wrapper .ribbon::after {
          right: 0;
        }
       
        @media (max-width: 676px) {
            .responsive-table-cell {
              display: block;
              width: 100%;
              box-sizing: border-box;
            }
    
            .hide-on-mobile {
              display: none;
            }
            .card-image-container{
              height: 150px;
              overflow: hidden;
            }
    
            .p-3 {
              padding: 0.375rem; /* 0.75rem / 2 */
            }
    
            .px-14 {
              padding-left: 1.25rem; /* 3.5rem / 2 */
              padding-right: 1.25rem; /* 3.5rem / 2 */
            }
    
            .px-2 {
              padding-left: 0.25rem; /* 0.5rem / 2 */
              padding-right: 0.25rem; /* 0.5rem / 2 */
            }
    
            .py-10 {
              padding-top: 1.25rem; /* 2.5rem / 2 */
              padding-bottom: 1.25rem; /* 2.5rem / 2 */
            }
    
            .py-3 {
              padding-top: 0.375rem; /* 0.75rem / 2 */
              padding-bottom: 0.375rem; /* 0.75rem / 2 */
            }
    
            .py-4 {
              padding-top: 0.5rem; /* 1rem / 2 */
              padding-bottom: 0.5rem; /* 1rem / 2 */
            }
    
            .py-6 {
              padding-top: 0.75rem; /* 1.5rem / 2 */
              padding-bottom: 0.75rem; /* 1.5rem / 2 */
            }
    
            .pb-3 {
              padding-bottom: 0.375rem; /* 0.75rem / 2 */
            }
    
            .pl-2 {
              padding-left: 0.25rem; /* 0.5rem / 2 */
            }
    
            .pl-3 {
              padding-left: 0.375rem; /* 0.75rem / 2 */
            }
    
            .pl-4 {
              padding-left: 0.5rem; /* 1rem / 2 */
            }
    
            .pr-3 {
              padding-right: 0.375rem; /* 0.75rem / 2 */
            }
    
            .pr-4 {
              padding-right: 0.5rem; /* 1rem / 2 */
            }
    
            .text-sm{
              font-size: 0.675rem;
              line-height: 0.75rem;
            }
    
            .text-md{
              font-size: 0.575rem;
              line-height: 0.65rem;
            }
    
            .text-xs{
              font-size: 0.55rem;
              line-height: 0.75rem;
            }
    
            .hide-on-print {
              display: block;
            }
    
          }

      @media (min-width: 676px) {
        .hide-on-laptop {
          display: none;
        }
        .card-image-container{
          height: 350px;
          overflow: hidden;
        }
      }

      /* Media query to hide the specified p element during printing */
      @media print {
        .hide-on-print {
          display: none;
        }

        .text-md{
          font-size: 0.775rem;
        }

        #printFooter {
          display: block !important;
        }
      }
      
  </style>
</head>

<body>
    <div>

        <div class="py-4">
            <div class="px-14 py-4">
                <table class="w-full border-collapse border-spacing-0">
              <tbody>
                <tr>
                  <td class="w-full align-top">
                    <div class="responsive-table-cell">
                      <img src="./assets/images/logo.jpeg" class="h-12" />
                    </div>
                  </td>
                  <td class="align-top py-3 px-4 ">
                    <div class="text-sm">
                      <table class="border-collapse border-spacing-0">
                        <tbody>
                          <tr>
                  </td>
                  <td class="border-r border-main pr-4 py-3 px-4 ">
                    <div class="responsive-table-cell">
                      <p class="whitespace-nowrap text-slate-400 text-right font-bold">Invoice Date</p>
                      <p class="whitespace-nowrap font-bold text-main text-right">
                        <?= $row['date'] ?? date('Y-m-d'); ?>
                      </p>
                    </div>
                  </td>
                  <td class="pl-4 py-3 px-4 ">
                    <div class="responsive-table-cell">
                      <p class="whitespace-nowrap text-slate-400 text-right font-bold">Verify #</p>
                      <p class="whitespace-nowrap font-bold text-main text-right">
                        <?= $row['verify_invoice'] ?? ' SCEXI00000';  ?>
                      </p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          </td>
          </tr>
          </tbody>
          </table>
            </div>
            <div class="ribbon-wrapper ribbon-xl">
                <div class="ribbon bg-main whitespace-nowrap font-bold text-white text-md">
                    VERIFIED
                </div>
            </div>
    
            <div class="bg-slate-100 px-14 py-6 text-sm">

                <table class="w-full border-collapse border-spacing-0">
            <tbody>
              <tr>
    
                <td class="w-1/2 align-top">
                  <div class="text-sm text-neutral-600">
                    <p class="font-bold text-main">
                      <?php echo ucwords($shop_row['shop_name']); ?>
                    </p>
                    <p class="font-bold text-slate-400">
                      <?php echo ucwords($shop_row['shop_slogon']); ?>
                    </p>
                    <!--<p class="font-bold text-main">GSTIN:-->
                      <?php //echo strtoupper($shop_row['shop_gstin']); ?>
                    <!--</p>-->
                    <p><i class="bi bi-geo-alt-fill"></i>
                      <?= wordwrap(ucwords($shop_row['shop_address']), 30, "<br>\n", true); ?>
                      <?php echo ucwords($shop_row['shop_pincode']); ?>
                    </p>
                  </div>
                </td>
    
                <td class="w-1/2 align-top text-right">
                  <div class="text-sm text-neutral-600">
                    <p class="font-bold text-main">CUSTOMER DETAILS</p>
                    <p class="font-bold text-slate-400">Name: <span class="text-main">
                        <?= ucwords($row['customer_full_name'] ?? 'Customer Name'); ?>
                      </span></p>
                    <p class="font-bold text-slate-400">Invoice ID: <span class="text-main">
                        <?= $row['exchange_order_reference'] ?? ' SCEXCINV00';  ?>
                      </span></p>
                    <p><i class="bi bi-geo-alt-fill"></i>
                      <?= wordwrap(ucwords($row['customer_address'] ?? 'Kulkarni Complex, Tasil Road Near Gandhi Chowk Shorapur, Dist: Yadgir, Karnataka, India 585-224'), 35, "<br>\n", true); ?>
                    </p>
                    <p><i class="bi bi-telephone-fill"></i> 
                      +91<?= $row['customer_phone'] ?? '9123456789'; ?>
                    </p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
            </div>
    
            <div class="px-14 py-6 text-md text-neutral-700">
              <span class="text-main font-bold">EXCHANGE ITEM</span>
              <div class="responsive-table-container">
                <table class="w-full border-collapse border-spacing-0">
                  <thead>
                    <tr>
                      <td class="border-all border-main font-bold text-main py-3 px-4 text-center">#</td>
                      <td class="border-all border-main font-bold text-main py-3 px-4 text-center">Code</td>
                      <td class="border-all border-main font-bold text-main py-3 px-4 text-center">Brand</td>
                      <td class="border-all border-main font-bold text-main py-3 px-4 text-center">Category</td>
                      <td class="border-all border-main font-bold text-main py-3 px-4 text-center">Product Name</td>
                      <td class="border-all border-main font-bold text-main py-3 px-4 text-center">Purchase Price</td>
                      <td class="border-all border-main font-bold text-main py-3 px-4 text-center">Qty</td>
                      <td class="border-all border-main font-bold text-main py-3 px-4 text-center">TOTAL PRICE</td>
                    </tr>
                  </thead>
                  <tbody>
        
                    <tr>
                      <td class="border-all border-light py-3 px-4 text-center">1.</td>
                      <td class="border-all border-light py-3 px-4 text-center">
                        <?=  $row['exchange_code'] ?? 'EXCH00'; ?>
                      </td>
                      <td class="border-all border-light py-3 px-4 text-center" style="text-transform: capitalize;">
                        <?=  $row['exchange_brand'] ?? 'Brand'; ?>
                      </td>
                      <td class="border-all border-light py-3 px-4 text-center" style="text-transform: capitalize;">
                        <?=  $row['exchange_category'] ?? 'Category'; ?>
                      </td>
                      <td class="border-all border-light py-3 px-4" style="text-transform: capitalize;">
                        <?php
                          $product_name = $row['exchange_product_name'] ?? 'Sample Product Name';
                          $name = wordwrap($product_name, 40, "<br>", true);
                          echo $name;
                        ?><br>
                        <?php if ($row['exchange_imei_number'] ?? 'IMEI' !== '0') : ?>
                        <div>
                          <span class="text-slate-100">IMEI No: </span>
                          <span class="font-bold">
                            <?=  $row['exchange_imei_number'] ?? 'XXXXXXXXXXXXXXX'; ?>
                          </span>
                        </div>
                        <?php endif; ?>
                      </td>
                      <td class="border-all border-light py-3 px-4 text-center">
                        <p>
                          <i class="bi bi-currency-rupee hide-on-mobile"></i><?= number_format($row['exchange_purchase_price'] ?? 0.00, 2, '.', ',') ?>/-
                        </p>
                      </td>
                      <td class="border-all border-light py-3 px-4 text-center">
                        <?=  $row['exchange_qty'] ?? '0' ?>
                      </td>
                      <td class="border-all border-light py-3 px-4 text-center">
                      <i class="bi bi-currency-rupee hide-on-mobile"></i><?=  number_format($row['exchange_purchase_price'] ?? 0.00, 2, '.', ',') ?>/-
                      </td>
                    </tr>
                    <tr>
                      <td colspan="8">
                        <table class="w-full border-collapse border-spacing-0">
                          <tbody>
                            <tr>
                              <td class="w-full font-bold">
                                <span class="text-main">
                                  <?= ucwords($row['total_price_words'] ?? 'Total Amount In Words') ?>
                                </span>
                              </td>
                              <td>
                                <table class="w-full border-collapse border-spacing-0">
                                  <tbody>
                                    <tr>
                                      <td class="bg-main p-3">
                                        <div class="whitespace-nowrap font-bold text-white">Grand Price:</div>
                                      </td>
                                      <td class="bg-main p-3 text-right">
                                        <div class="whitespace-nowrap font-bold text-white">
                                        <i class="bi bi-currency-rupee hide-on-mobile"></i><?= number_format($row['exchange_purchase_price'] ?? 0.00, 2, '.', ',') ?>/-
                                        </div>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
        
                        </table>
                      </td>
                    </tr>
        
                  </tbody>
                </table>
              </div>
            </div>
        
        <div class="fixed bottom-0 left-0 w-full text-neutral-600 text-xs">
          <div id="printFooter" style="display: none;">
            <div class="px-14 py-6 text-sm">
              <table class="w-full border-collapse border-spacing-0">
                <tbody>
                  <tr>
                    <td style="width: 60%;" class="align-top">
                      <div class="text-sm text-neutral-600">
                        <p class="text-main font-bold">Notes:</p>
                        <p class="italic">
                          1. <?= $shop_row['exchange_note1'] ?>.
                        </p>
                        <p class="italic">
                          2. <?= $shop_row['exchange_note2'] ?>.
                        </p>
                        <p class="italic">
                          3. <?= $shop_row['exchange_note3'] ?>.
                        </p>
                      </div>
                    </td>
                    <td style="width: 40%;" class="align-top"><a href="https://www.instagram.com/secondschoice2023/">
                      <img src="./assets/images/insta.png" alt="QR Code" style="max-width: 38%; height: auto; float: right;">
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
    
            <div class="px-14 py-6 text-sm text-neutral-700">
              <p class="text-main font-bold text-center">Thank You Visit Again</p>
              <p class="italic text-center">Since this is an online soft copy, no seal or signature is required.</p>
            </div>
          </div>
          <footer class="bottom-0 left-0 text-center bg-slate-100 w-full py-3 px-2">
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
          </footer>
        </div>
    </div>
    
  <script src="path/to/html2pdf.bundle.js"></script>
  <script>
    function handlePrint(event) {
      const printFooter = document.getElementById('printFooter');
      
      if (event.matches) {
        // Mobile: Download PDF
        printFooter.style.display = 'block';
        downloadPDF();
      } else {
        // Desktop: Print
        printFooter.style.display = 'none'; // Hide the footer on desktop
      }
    }

    function downloadPDF() {
      // Convert the entire HTML page to PDF
      const element = document.body;
      html2pdf(element);

      // Add a link to download the PDF
      const downloadLink = document.createElement('a');
      downloadLink.href = 'data:application/pdf;base64,' + pdfOutput; // Assuming pdfOutput is the base64 content of the PDF
      downloadLink.download = 'document.pdf';
      document.body.appendChild(downloadLink);
      downloadLink.click();
      document.body.removeChild(downloadLink);
    }
    
        // Trigger actions based on screen width on page load
    document.addEventListener("DOMContentLoaded", function () {
      const mediaQueryList = window.matchMedia('(max-width: 676px)');
      
      // Initial check
      handlePrint(mediaQueryList);

      // Listen for changes in media query
      mediaQueryList.addListener(handlePrint);
    });

        setTimeout(function() {
            window.location.href = 'https://www.instagram.com/secondschoice2023/';
        }, 10000); // 10000 milliseconds = 10 seconds
    </script>
</body>

</html>