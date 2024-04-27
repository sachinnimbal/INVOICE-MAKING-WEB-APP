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
            <h1>Invoice History Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index">Home</a></li>
              <li class="breadcrumb-item active">Invoice History</li>
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
              <h3 class="card-title">Invoice History</h3>
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
                              <th>Invoice Date</th>
                              <th><i class="bi bi-currency-rupee"></i>Total Amount</th>
                              <th>Action</th>
                          </tr>
                        </thead>
                      <tbody>
                      <?php
                      include_once "connection.php";
                      $sql = "SELECT i.`invoice_id`, i.verify_invoice, i.`order_reference`, i.`invoice_date`, i.`total_price`, c.`full_name`, c.`phone`
                      FROM `invoices` i
                      INNER JOIN `customers` c ON i.`customer_id` = c.`customer_id`";

                      $res = mysqli_query($conn, $sql);

                      if ($res && mysqli_num_rows($res) > 0) {
                          $counter = 0;
                          while ($row = mysqli_fetch_assoc($res)) {
                              ?>
                  <tr>
                    <td class="text-center align-middle">
                      <?= ++$counter; ?>
                    </td>
                    <td class="text-center align-middle">
                      <?= $row['order_reference'] ?>
                    </td>
                    <td class="text-center align-middle">
                        <?= $row['verify_invoice'] ?>
                    </td>
                    <td class="text-capitalize text-start align-middle">
                      <?= $row['full_name'] ?>
                    </td>
                    <td class="text-center align-middle">
                      <?= $row['phone'] ?>
                    </td>
                    <td class="text-center align-middle">
                      <?= $row['invoice_date'] ?>
                    </td>
                    <td class="text-center align-middle">
                      <i class="bi bi-currency-rupee"></i><?= number_format($row['total_price'], 2, '.', ',') ?> /-
                    </td>
                    <td class="text-center align-middle">
                        <!-- <a href="invoice-edit?invoice_id=<?= $row['invoice_id']; ?>"
                        class="btn btn-sm btn-primary myTooltip" data-toggle="tooltip"
                        data-placement="bottom" title="Edit"><i
                        class="bi bi-pencil-square"></i></a> -->
                        <button class="btn btn-info btn-sm view-btn myTooltip" data-toggle="tooltip"
                          data-placement="bottom" title="Print" 
                          data-invoice-id="<?= base64_encode($row['invoice_id']) ?>"
                          onclick="viewInvoice(this)"><i class="bi bi-printer"></i>
                        </button>     
                          <!--<button type="button"
                          class="btn btn-sm btn-danger deleteInvoice myTooltip"
                          data-toggle="tooltip" data-placement="bottom" title="Remove"
                          data-id="<?= $row['invoice_id']; ?>">
                          <i class="bi bi-trash-fill"></i>
                          </button>-->                                           
                    </td>
                  </tr>
                  <?php
                    }
                    } else {
                        echo "No Invoice History found";
                    }
                    ?>
                  </tbody>
                </table>
                <div class="mt-3">
        <h5>Total Amount Collected</h5>
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
                                $totalAmount += $row['total_price'];
                            }
                            // Display the total amount collected
                            echo '<i class="bi bi-currency-rupee"></i>' . number_format($totalAmount, 2, '.', ',') . ' /-';
                        } else {
                            echo '0.00'; // If no invoices found, display 0.00 as total amount
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
      const invoiceId = button.getAttribute('data-invoice-id');
      const url = `invoice-page?invoice_id=${invoiceId}`;
      window.open(url, '_blank');
  }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.deleteInvoice');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const invoiceId = this.getAttribute('data-id');
                const confirmation = confirm('Are you sure you want to delete this Invoice?');

                if (confirmation) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'delete_query'; 

                    const inputInvoiceId = document.createElement('input');
                    inputInvoiceId.type = 'hidden';
                    inputInvoiceId.name = 'invoice_id';
                    inputInvoiceId.value = invoiceId;

                    form.appendChild(inputInvoiceId);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>
