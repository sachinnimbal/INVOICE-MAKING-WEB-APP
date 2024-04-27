<?php include './includes/header.php'; ?>

<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php include './includes/navbar.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include './includes/sidebar.php'; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Exchange History Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index">Home</a></li>
              <li class="breadcrumb-item active">Exchange History</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
            <?php include 'alert.php'; ?>

            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title">Exchange History</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                </div>
                </div>
                <div class="card-body">
                        <table id="example1" class="table table-head-fixed text-nowrap table-bordered table-responsive-lg">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ref #</th>
                                <th>Verify #</th>
                                <th>Customer Name</th>
                                <th>Phone</th>
                                <th>Exchange Date</th>
                                <th><i class="bi bi-currency-rupee"></i>Total Amount</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        <tbody>
                        <?php
                        include_once "connection.php";
                        $sql = "SELECT 
                            ep.`exchange_id`, ep.`customer_id`, ep.`exchange_code`, ep.`verify_invoice`, ep.`exchange_order_reference`, 
                            ep.`date`, ep.`exchange_category`, ep.`exchange_brand`, ep.`exchange_condition_name`, 
                            ep.`exchange_product_name`, ep.`exchange_qty`, ep.`exchange_imei_number`, ep.`exchange_purchase_price`, 
                            ep.`customer_IdType`, ep.`aadharNumber`, ep.`voterNumber`, ep.`card_image`, c.`full_name` AS 'customer_full_name', 
                            c.`phone` AS 'customer_phone', 
                            c.`address` AS 'customer_address'
                            FROM 
                                `exchange_product` ep
                            INNER JOIN 
                                `customers` c ON ep.`customer_id` = c.`customer_id`;
                            ";

                        $res = mysqli_query($conn, $sql);

                        if ($res && mysqli_num_rows($res) > 0) {
                            $counter = 0;
                            while ($row = mysqli_fetch_assoc($res)) {
                                ?>
                    <tr>
                        <td class="text-center align-middle">
                            <?= ++$counter ?>
                        </td>
                        <td class="text-center align-middle">
                        <?= $row['exchange_order_reference'] ?>
                        </td>
                        <td class="text-center align-middle">
                            <?= $row['verify_invoice'] ?>
                        </td>
                        <td class="text-capitalize text-start align-middle">
                        <?= $row['customer_full_name'] ?>
                        </td>
                        <td class="text-center align-middle">
                        <?= $row['customer_phone'] ?>
                        </td>
                        <td class="text-center align-middle">
                        <?= $row['date'] ?>
                        </td>
                        <td class="text-center align-middle">
                        <i class="bi bi-currency-rupee"></i><?= number_format($row['exchange_purchase_price'], 2, '.', ',') ?> /-
                        </td>
                        <td class="text-center align-middle">
                            <button class="btn btn-info btn-sm view-btn myTooltip" data-toggle="tooltip"
                                data-placement="bottom" title="Print" 
                                data-exchange-id="<?= base64_encode($row['exchange_id']) ?>" 
                                onclick="viewInvoice(this)"><i class="bi bi-printer"></i></button>
                            <!--<button class="btn btn-success btn-sm sendInvoice-btn myTooltip" data-toggle="tooltip"
                                data-placement="bottom" title="Send Invoice" 
                                data-exchange-id="<?= base64_encode($row['exchange_id']) ?>" 
                                data-link="https://example.com/your-link" 
                                data-phone="<?= $row['customer_phone'] ?>"
                                onclick="sendInvoice(this)"><i class="bi bi-whatsapp"></i></button>-->
                            <!--<button type="button"
                                class="btn btn-sm btn-danger deleteExchange myTooltip"
                                data-toggle="tooltip" data-placement="bottom" title="Remove"
                                data-id="<?= $row['exchange_id']; ?>">
                                <i class="bi bi-trash-fill"></i>
                            </button>-->                                             
                        </td>
                    </tr>
                    <?php
                        }
                        } else {
                            echo "No Exchange Item found";
                        }
                        ?>
                    </tbody>
                    </table>
                    <div class="mt-3">
            <h5>Total Amount Spent</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php
                            $totalAmount = 0; // Initialize total amount variable
                            $res = mysqli_query($conn, $sql);

                            if ($res && mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    // Calculate total amount by adding each invoice's total price
                                    $totalAmount += $row['exchange_purchase_price'];
                                }
                                // Display the total amount collected
                                echo '<i class="bi bi-currency-rupee"></i>' . number_format($totalAmount, 2, '.', ',') . ' /-';
                            } else {
                                echo '0.00'; 
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
            </div>
            <!-- /.card-body -->
            </div>
          <!-- /.card -->
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include './includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<?php include './includes/footer_main.php'; ?>

<script>
  function viewInvoice(button) {
      const exchangeId = button.getAttribute('data-exchange-id');
      const url = `exchange-page?exchange_id=${exchangeId}`;
      window.open(url, '_blank');
  }
 
</script>


<script>
    // function sendInvoice(button) {
    //     var exchangeId = button.getAttribute('data-exchange-id');
    //     var link = button.getAttribute('data-link');
    //     var phone = button.getAttribute('data-phone');

    //     // AJAX request to your server-side script
    //     $.ajax({
    //         url: 'sendInvoice.php', // Change the path to your server-side script
    //         method: 'POST',
    //         data: { exchangeId: exchangeId, link: link, phone: phone },
    //         success: function(response) {
    //             // Handle the response from the server (optional)
    //             console.log(response);
    //         },
    //         error: function(error) {
    //             // Handle errors (optional)
    //             console.error(error);
    //         }
    //     });
    // }
</script>
