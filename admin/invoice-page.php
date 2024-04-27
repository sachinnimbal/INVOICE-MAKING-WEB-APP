<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'connection.php';
  session_start();
  $user_id = $_SESSION['id'];

  if (!isset($user_id)) {
    header('location:../index');
  }

// Query to fetch shop details
$shop_query = "SELECT `shop_id`, `shop_name`, `shop_slogon`, `shop_gstin`, `shop_address`, `shop_pincode`, `shop_email`, `shop_phone1`, `shop_phone2`, 
`exchange_note1`, `exchange_note2`, `exchange_note3`, `note_1` , `note_2`, `note_3` FROM `shop` LIMIT 1";
$shop_result = mysqli_query($conn, $shop_query);
$shop_row = mysqli_fetch_assoc($shop_result);

// Function to decrypt the invoice_id
function decryptInvoiceId($encrypted_invoice_id)
{
    return base64_decode($encrypted_invoice_id);
}

if (isset($_GET['invoice_id'])) {
    $encrypted_invoice_id = $_GET['invoice_id'];
    $invoice_id = decryptInvoiceId($encrypted_invoice_id);

    // Use prepared statement to avoid SQL injection
    $invoice_query = "SELECT c.customer_id, c.full_name, c.phone, c.address, c.created_at AS customer_created_at, c.updated_at AS customer_updated_at,
                          i.invoice_id, i.customer_id AS invoice_customer_id, i.verify_invoice ,i.order_reference, i.invoice_date, i.cgst, i.sgst, i.total_price, i.total_price_words, 
                          i.created_at AS invoice_created_at, i.updated_at AS invoice_updated_at
                          FROM 
                              customers c
                          INNER JOIN 
                              invoices i ON c.customer_id = i.customer_id
                          WHERE
                              i.invoice_id = ?
                          ORDER BY
                              i.invoice_id ASC";

    // Use prepared statement to avoid SQL injection
    $stmt = mysqli_prepare($conn, $invoice_query);
    mysqli_stmt_bind_param($stmt, "i", $invoice_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // If invoice_id is not found, you can handle it here (e.g., redirect to 404 page)
        header("HTTP/1.0 404 Not Found");
        include('404.php'); // You may have a custom 404 page
        exit();
    }
} else {
    // If invoice_id is not set, you can handle it here (e.g., redirect to 404 page)
    header("HTTP/1.0 404 Not Found");
    include('404.php'); // You may have a custom 404 page
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Seconds Choice - Invoice Page</title>
  <link href="./assets/images/logo.png" rel="icon">
  <link href="./assets/images/favicon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="./assets/invoice.css">
  <link href="./assets/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <style>
      .responsive-table-container {
        overflow-x: auto;
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
          padding-top: 1.10rem; /* 2.5rem / 2 */
          padding-bottom: 1.10rem; /* 2.5rem / 2 */
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
              <td class="border-r border-main pr-4 py-3 px-4">
                <div class="responsive-table-cell">
                  <p class="whitespace-nowrap text-slate-400 text-right font-bold">Invoice Date</p>
                  <p class="whitespace-nowrap font-bold text-main text-right">
                    <?= $row['date'] ?? date('Y-m-d'); ?>
                  </p>
                </div>
              </td>
              <td class="pl-4 py-3 px-4 ">
                <div class="responsive-table-cell">
                  <p class="whitespace-nowrap text-slate-400 text-right font-bold">Invoice #</p>
                  <p class="whitespace-nowrap font-bold text-main text-right">
                    <?= $row['order_reference'] ?? ' SCINV00';  ?>
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
                  <?= wordwrap(ucwords($shop_row['shop_address']), 50, "<br>\n", true); ?>
                  <?php echo ucwords($shop_row['shop_pincode']); ?>
                </p>
              </div>
            </td>

            <td class="w-1/2 align-top text-right">
              <div class="text-sm text-neutral-600">
                <p class="font-bold text-main">CUSTOMER DETAILS</p>
                <p class="font-bold text-slate-400">Verify ID: <span class="text-main">
                    <?= $row['verify_invoice'] ?? ' SCINV0000';  ?>
                  </span></p>
                <p class="font-bold text-slate-400">Name: <span class="text-main">
                    <?= ucwords($row['full_name'] ?? 'Customer Name'); ?>
                  </span></p>
                <p><i class="bi bi-geo-alt-fill"></i>
                  <?= wordwrap(ucwords($row['address'] ?? 'Kulkarni Complex, Tasil Road Near Gandhi Chowk Shorapur, Dist: Yadgir, Karnataka, India 585-224'), 50, "<br>\n", true); ?>
                </p>
                <p><i class="bi bi-telephone-fill"></i> 
                 +91<?= $row['phone'] ?? '9123456789'; ?>
                </p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="px-14 py-6 text-md text-neutral-700">
      <span class="text-main font-bold">PRODUCT ITEM</span>
      <div class="responsive-table-container">
        <table class="w-full border-collapse border-spacing-0">
          <thead>
            <tr>
              <td class="border-all border-main font-bold text-main py-3 px-4 text-center">#</td>
              <td class="border-all border-main font-bold text-main py-3 px-4 text-center">Code</td>
              <td class="border-all border-main font-bold text-main py-3 px-4 text-center">Brand</td>
              <td class="border-all border-main font-bold text-main py-3 px-4 text-center">Category</td>
              <td class="border-all border-main font-bold text-main py-3 px-4 text-center">Product Name</td>
              <td class="border-all border-main font-bold text-main py-3 px-4 text-center">Selling Price</td>
              <td class="border-all border-main font-bold text-main py-3 px-4 text-center">Qty</td>
              <td class="border-all border-main font-bold text-main py-3 px-4 text-center">TOTAL PRICE</td>
            </tr>
          </thead>
    <tbody>
        <?php

        if (isset($_GET['invoice_id'])) {
            $encrypted_invoice_id = $_GET['invoice_id'];
            $invoice_id = decryptInvoiceId($encrypted_invoice_id);

          if ($invoice_id === false) {
            // If base64 decoding fails, you can handle it here (e.g., redirect to 404 page)
            header("HTTP/1.0 404 Not Found");
            include('404'); // You may have a custom 404 page
            exit();
          }

            $query = "SELECT ii.item_id, ii.invoice_id AS item_invoice_id, ii.code, ii.brand, ii.category, ii.product_name, ii.imei, ii.original_price, ii.selling_price, ii.quantity, ii.total
                FROM invoice_items ii
                WHERE ii.invoice_id = $invoice_id
                ORDER BY ii.code ASC"; 

            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $counter = 1;
                while ($item = mysqli_fetch_assoc($result)) {
        ?>
                    <tr>
                        <td class="border-all border-light py-3 px-4 text-center"><?=  $counter++ ?>.</td>
                        <td class="border-all border-light py-3 px-4 text-center"><?=  $item['code'] ?? '' ?></td>
                        <td class="border-all border-light py-3 px-4 text-center" style="text-transform: capitalize;"><?=  $item['brand'] ?? 'Brand' ?></td>
                        <td class="border-all border-light py-3 px-4 text-center" style="text-transform: capitalize;"><?=  $item['category'] ?? 'Category' ?></td>
                        <td class="border-all border-light py-3 px-4" style="text-transform: capitalize;">
                            <?php
                            $product_name = $item['product_name']  ?? 'Product Name';
                            $name = wordwrap($product_name, 10, "<br>", true);
                            echo $name;
                            ?><br>
                            <?php if ($item['imei'] !== '0') : ?>
                                <div>
                                    <span class="text-slate-100">IMEI No: </span>
                                    <span class="font-bold"><?=  $item['imei'] ?></span>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="border-all border-light py-3 px-4 text-center">
                          <p>
                            <del class="text-slate-400"><i class="bi bi-currency-rupee hide-on-mobile"></i><?= number_format($item['original_price'], 2, '.', ',') ?>/-</del><br>
                            <i class="bi bi-currency-rupee hide-on-mobile"></i><?= number_format($item['selling_price']?? 0.00, 2, '.', ',') ?>/-
                          </p>
                        </td>
                        <td class="border-all border-light py-3 px-4 text-center"><?=  $item['quantity'] ?? 0 ?></td>
                        <td class="border-all border-light py-3 px-4 text-center"><i class="bi bi-currency-rupee hide-on-mobile"></i><?=  number_format($item['total']?? 0.00, 2, '.', ',') ?>/-</td>
                    </tr>
                    <?php
                    }
                } else {
                    ?>
          <tr>
            <td colspan="8">No items found for this invoice.</td>
          </tr>
          <?php
                }
            }
            ?>
            <tr>
              <td colspan="8">
                <table class="w-full border-collapse border-spacing-0">
                  <tbody>
                    <tr>
                      <td class="w-full"></td>
                      <td>
                        <table class="w-full border-collapse border-spacing-0">
                          <tbody>
                            <tr>
                                <td class="p-3">
                                    <div class="whitespace-nowrap text-slate-400">IGST (18%):</div>
                                </td>
                                <td class="p-3 text-right">
                                    <?php
                                    $cgst = $row['cgst']?? 0.00;
                                    $sgst = $row['sgst']?? 0.00;
                                    $igst = $cgst + $sgst;
                                    ?>
                                    <div class="whitespace-nowrap font-bold text-main"><i class="bi bi-currency-rupee hide-on-mobile"></i><?= number_format($igst, 2, '.', ',') ?>/-</div>
                                </td>
                            </tr>
                            <tr>
                              <td class="bg-main p-3">
                                <div class="whitespace-nowrap font-bold text-white">Grand Price:</div>
                              </td>
                              <td class="bg-main p-3 text-right">
                                <div class="whitespace-nowrap font-bold text-white"><i class="bi bi-currency-rupee hide-on-mobile"></i><?= number_format($row['total_price']?? 0.00, 2, '.', ',') ?>/-</div>
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
        <div class="font-bold text-right">
          <span class="text-main"><?= ucwords($row['total_price_words'] ?? 'Total Amount In Words') ?></span>
        </div>
      </div>
    </div>

    <div class="fixed bottom-0 left-0 w-full text-neutral-600 text-xs">
      <div id="printFooter" style="display: none;">
        <div class="px-14 py-6 text-sm">
          <table class="w-full border-collapse border-spacing-0">
            <tbody>
              <tr>
                <td style="width: 60%;" class="align-top  w-full">
                  <div class="text-sm text-neutral-600">
                    <p class="text-main font-bold">Notes:</p>
                    <p class="italic">
                      1. <?= $shop_row['note_1'] ?>.
                    </p>
                    <p class="italic">
                      2. <?= $shop_row['note_2'] ?>.
                    </p>
                    <p class="italic">
                      3. <?= $shop_row['note_3'] ?>.
                    </p>
                  </div>
                </td>
                <td style="width: 40%;" class="align-top">
                    <a href="https://www.instagram.com/secondschoice2023/">
                        <img src="./assets/images/insta.png" alt="QR Code" style="max-width: 38%; height: auto; float: right;">
                    </a>
                    <a href="https://www.verify.secondschoice.co.in/">
                        <img src="./assets/images/qrinvoice.png" alt="QR Code" style="max-width: 38%; height: auto; float: right;">
                    </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="px-14 py-6 text-sm text-neutral-700">
          <p class="text-main font-bold text-center">Thank You Visit Again</p>
          <p class="italic text-right">Seal & Signature</p>
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
        <p class="text-neutral-700">Please verify this invoice by visiting the following link or scanning the QR code above:
            <a href="https://verify.secondschoice.co.in/">https://verify.secondschoice.co.in/</a>
        </p>
      </footer>
    </div>

  </div>

  <!-- Include html2pdf library -->
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
        window.print();
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
  </script>
         
</body>

</html>