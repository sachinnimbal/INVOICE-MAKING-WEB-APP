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
            <h1>Edit Invoice Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index">Home</a></li>
              <li class="breadcrumb-item active">Invoice</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <?php include 'alert.php'; ?>
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Invoice</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">

              <div class="row">
                <h5 class="title text-bold text-info mr-3">Enter Customer Details</h5>
                <p class="text-bold text-muted mr-3">OR</p>
                <p class="btn-sm btn-primary text-bold" role="button" data-toggle="modal" data-target="#customerModal">PICK SAVED CUSTOMER FROM HERE</p>
              </div>
              <?php
                if (isset($_GET['invoice_id'])) {
                    $invoice_id = $_GET['invoice_id'];

                    // Query to fetch shop details
                    $shop_query = "SELECT `shop_id`, `shop_name`, `shop_slogon`, `shop_gstin`, `shop_address`, `shop_pincode`, `shop_email`, `shop_phone1`, `shop_phone2` FROM `shop` LIMIT 1";
                    $shop_result = mysqli_query($conn, $shop_query);
                    $shop_row = mysqli_fetch_assoc($shop_result);

                    $invoice_query = "SELECT 
                                        c.customer_id, c.full_name, c.email, c.phone, c.address, c.created_at AS customer_created_at, c.updated_at AS customer_updated_at,
                                        i.invoice_id, i.customer_id AS invoice_customer_id, i.order_reference, i.invoice_date, i.cgst, i.sgst, i.total_price, i.total_price_words, i.created_at AS invoice_created_at, i.updated_at AS invoice_updated_at
                                    FROM 
                                        customers c
                                    INNER JOIN 
                                        invoices i ON c.customer_id = i.customer_id
                                    WHERE
                                        i.invoice_id = $invoice_id
                                    ORDER BY
                                        i.invoice_id ASC"; // Ordering by 'invoice_id' column in ascending order                        

                    $result = mysqli_query($conn, $invoice_query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                ?>
              <form id="selectedCustomerForm" action="process_invoice" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate onsubmit="return validateProductList()">            
                <div class="form-row">
                <input type="hidden" name="customer_id" placeholder="Customer Id" class="form-control text-capitalize" required value="<?= $row['customer_id']; ?>"/>
                  <div class="col-md-4 mb-3">
                    <div class="input-group mb-3">
                        <input type="text" name="u_customer_name" placeholder="Full Name" class="form-control text-capitalize" required value="<?= ucwords($row['full_name']); ?>"/>
                        <div class="valid-tooltip">
                            Looks good!
                        </div>
                        <div class="invalid-tooltip">
                            Please provide a valid full name.
                        </div>
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="bi bi-person"></span>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="input-group mb-3">
                      <input type="email" name="u_email" placeholder="Email Address" class="form-control" required value="<?= $row['email']; ?>"/>
                      <div class="invalid-tooltip">
                          Please provide a valid email.
                      </div>
                      <div class="valid-tooltip">
                         Looks good!
                      </div>
                      <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="bi bi-envelope"></span>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="input-group mb-3">
                      <input type="date" id="invoiceDate" name="u_date" class="form-control" value="<?= $row['invoice_date']; ?>"/>
                      <div class="invalid-tooltip">
                          Please provide a valid date.
                      </div>
                      <div class="valid-tooltip">
                          Looks good!
                      </div>
                      <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="bi bi-calendar-check"></span>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-4 mb-3">
                    <div class="input-group mb-3">
                      <input type="text" id="inputPhone" name="u_phone" placeholder="Phone Number" class="form-control"
                        required  value="<?= $row['phone'] ?>"/>
                        <div class="invalid-tooltip">
                          Please provide a valid phone number.
                      </div>
                      <div class="valid-tooltip">
                          Looks good!
                      </div>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="bi bi-phone"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="input-group mb-3">
                      <textarea class="form-control text-capitalize" name="u_address" placeholder="Billing Address"
                        style="height: 40px;" required><?= $row['address'] ?></textarea>
                        <div class="invalid-tooltip">
                          Please provide a valid billing address.
                        </div>
                        <div class="valid-tooltip">
                            Looks good!
                        </div>
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="bi bi-geo-alt"></span>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="form-group table-responsive-lg">
                  <div class="row">
                    <h5 class="title text-bold text-info mr-3">Product Details</h5>
                    <p class="text-bold text-muted mr-3"><i class="bi bi-arrow-right-circle-fill"></i></p>
                    <p class="btn-sm btn-primary text-bold" role="button" data-toggle="modal" data-target="#productModal">ADD ITEMS FROM HERE</p>
                    <span  class="text-bold text-success ml-3"><i class="text-bold bi bi-info-circle-fill mr-md-1"></i>Please do not increase the quantity of the product item.</span>
                  </div>
                  <table id="productTable" class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="text-center">Code</th>
                        <th class="text-center">Brand</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Product Name</th>
                        <th class="text-center">IMEI No.</th>
                        <th class="text-center myTooltip" data-toggle="tooltip" 
                          data-placement="top" 
                          title="Original Price"><i class="bi bi-currency-rupee"></i>MRP</th>
                        <th class="text-center myTooltip"
                          data-placement="top" data-toggle="tooltip" 
                          title="Selling Price"><i class="bi bi-currency-rupee"></i>SP</th>
                        <th class="text-center">QTY</th>
                        <th class="text-center"><i class="bi bi-currency-rupee"></i>Total</th>
                        <th class="text-center"><i class="bi bi-trash"></i></th>
                      </tr>
                    </thead>
                    <tbody id="selectedItemsBody">
                      <!-- Existing or dynamically added rows will be here -->
                    </tbody>
                  </table>
                </div>
                <div class="form-row mt-4">
                  <div class="col-md-4 mb-3">
                    <div class="input-group mb-3">
                      <input type="number" step="0.01" min="0" class="form-control" id="inputCGST" name="u_cgst" placeholder="CGST" value="<?= $row['cgst'] ?>" readonly/>
                        <div class="invalid-tooltip">
                          Please provide a valid cgst.
                        </div>
                        <div class="valid-tooltip">
                            Looks good!
                        </div>
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="bi bi-currency-rupee"></span>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="input-group mb-3">
                      <input type="number" step="0.01" min="0" class="form-control" id="inputSGST" name="u_sgst" placeholder="SGST" value="<?= $row['sgst'] ?>" readonly/>
                      <div class="invalid-tooltip">
                          Please provide a valid sgst.
                        </div>
                        <div class="valid-tooltip">
                            Looks good!
                        </div>
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="bi bi-currency-rupee"></span>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="input-group mb-3">
                    <input type="number" step="0.01" min="0" class="form-control" id="inputTotalPrice" name="u_total_price" placeholder="Total Price" value="<?= $row['total_price'] ?>" readonly />
                      <div class="invalid-tooltip">
                          Please provide a valid total price.
                        </div>
                        <div class="valid-tooltip">
                            Looks good!
                        </div>
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="bi bi-currency-rupee"></span>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <span class="bi bi-currency-rupee"></span>
                          </div>
                        </div>
                        <input type="text" class="form-control" id="inputTotalPriceInWords" name="u_total_price_words" placeholder="Total Price Words" value="<?= $row['total_price_words'] ?>" readonly />
                        <div class="valid-tooltip">
                            Looks good!
                        </div>
                        <div class="invalid-tooltip">
                          Please provide a valid amount in words.
                        </div> 
                    </div>
                  </div>
                </div>
                <div class="form-row mt-1">
                  <div class="col-md-12">
                    <button type="submit" name="update_Invoice" class="btn btn-primary">Update Invoice</button>
                  </div>
                </div>
              </form>
              <?php
              }
              }
              ?>

              
              <!-- PICK CUSTOMER Modal -->
              <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title text-bold" id="customerModalLabel">Customer Selection</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="card-body table-responsive p-0" style="height: 500px;">
                        <table id="example2" class="table table-bordered table-head-fixed text-nowrap">
                          <!-- Table header -->
                          <thead>
                            <tr>
                              <th class="text-start">Select</th>
                              <th class="text-start">Name</th>
                              <th class="text-start">Email</th>
                              <th class="text-start">Phone</th>
                              <th class="text-start">Address</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            include_once "connection.php";
                            $sql = "SELECT * FROM `customers` ORDER BY customer_id ASC";
                            $res = mysqli_query($conn, $sql);

                            if ($res && mysqli_num_rows($res) > 0) {
                              $counter = 0;
                              while ($row = mysqli_fetch_assoc($res)) {
                            ?>
                            <tr>
                              <td class="text-center align-middle">
                                <button type="button" class="btn btn-sm btn-info selectCustomer"
                                  data-customer-id="<?= $row['customer_id']; ?>">Select</button>
                              </td>
                              <td class="text-capitalize text-start align-middle">
                                <?= $row['full_name'] ?>
                              </td>
                              <td class="text-start align-middle">
                                <?= $row['email'] !== null ? $row['email'] : 'Optional' ?>
                              </td>
                              <td class="text-center align-middle">
                                <?= $row['phone'] ?>
                              </td>
                              <td class="text-start align-middle">
                                <?= $row['address'] ?>
                              </td>
                            </tr>
                            <?php
                              }
                            } else {
                              echo "<tr><td colspan='5' class='text-center align-middle'>No customers found</td></tr>";
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- PICK PRODUCT Modal -->
              <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title text-bold badge" id="productModalLabel">Product Selection</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="card-body table-responsive p-0" style="height: 500px;">
                        <table id="example1" class="table table-bordered table-head-fixed text-nowrap">
                            <!-- Table header -->
                            <thead>
                                <tr>
                                    <th class="text-start">Select</th>
                                    <th class="text-start">Code</th>
                                    <th class="text-start">Brand</th>
                                    <th class="text-start">Category</th>
                                    <th class="text-start">Name</th>
                                    <th class="text-start">IMEI No.</th>
                                    <th class="text-start myTooltip" data-toggle="tooltip" data-placement="top" title="Original Price"><i class="bi bi-currency-rupee"></i>MRP</th>
                                    <th class="text-start myTooltip" data-placement="top" data-toggle="tooltip" title="Selling Price"><i class="bi bi-currency-rupee"></i>SP</th>
                                    <th class="text-start myTooltip" data-placement="top" data-toggle="tooltip" title="Quantity">Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                      <?php
                                        include_once "connection.php";

                                        // Fetch products
                                        $productSql = "SELECT * FROM `products` ORDER BY id ASC";
                                        $productRes = mysqli_query($conn, $productSql);

                                        if ($productRes && mysqli_num_rows($productRes) > 0) {
                                            while ($row = mysqli_fetch_assoc($productRes)) {
                                        $productId = $row['id'];
                                        $imeiSql = "SELECT `imei_number` FROM `imei_numbers` WHERE `product_id` = $productId"; // Replace 'imei_numbers' and 'product_id' with your actual table and column names
                                        $imeiRes = mysqli_query($conn, $imeiSql);
                                        $qtyAvailable = $row['qty'];

                                      ?>
                                        <tr>
                                            <!-- Display product details -->
                                            <td class="text-center align-middle">
                                            <button type="button" class="btn btn-sm btn-info selectProducts" data-product-id="<?= $row['id']; ?>" <?= (mysqli_num_rows($imeiRes) > 0 && $qtyAvailable > 0) ? '' : 'disabled' ?>>Select</button>
                                            </td>
                                            <td class="text-start align-middle"><?= $row['product_code'] ?></td>
                                            <td class="text-capitalize text-start align-middle"><?= $row['brand_title'] ?></td>
                                            <td class="text-capitalize text-start align-middle"><?= $row['category_title'] ?></td>
                                            <td class="text-capitalize text-start align-middle"><?= $row['product_name'] ?></td>
                                            <td class="text-capitalize text-start align-middle">
                                            <?php
                                              $productId = $row['id'];
                                              $imeiSql = "SELECT `imei_number` FROM `imei_numbers` WHERE `product_id` = $productId"; // Replace 'imei_numbers' and 'product_id' with your actual table and column names
                                              $imeiRes = mysqli_query($conn, $imeiSql);

                                              if ($imeiRes && mysqli_num_rows($imeiRes) > 0) {
                                                  echo '<select class="form-control text-uppercase">';
                                                  while ($imeiRow = mysqli_fetch_assoc($imeiRes)) {
                                                      echo "<option value='{$imeiRow['imei_number']}'>{$imeiRow['imei_number']}</option>";
                                                  }
                                                  echo '</select>';
                                              } else {
                                                  // No IMEI available, display "Out of Stock" message and disable select
                                                  echo '<select class="form-control text-uppercase" disabled><option value="">Out of Stock</option></select>';
                                              }
                                            ?>
                                            </td>
                                            <td class="text-center align-middle"><?= $row['original_price'] ?></td>
                                            <td class="text-center align-middle"><?= $row['selling_price'] ?></td>
                                            <td class="text-center align-middle"><?= $row['qty'] ?></td>
                                        </tr>
                                        <?php
                                    }
                                }

                                // Fetch accessories
                                $accessorySql = "SELECT * FROM `accessory` ORDER BY accessory_id ASC";
                                $accessoryRes = mysqli_query($conn, $accessorySql);

                                if ($accessoryRes && mysqli_num_rows($accessoryRes) > 0) {
                                    while ($row = mysqli_fetch_assoc($accessoryRes)) {
                                        ?>
                                        <tr>
                                            <!-- Display accessory details -->
                                            <td class="text-center align-middle">
                                                <button type="button" class="btn btn-sm btn-info selectProducts" data-product-id="<?= $row['accessory_id']; ?>">Select</button>
                                            </td>
                                            <td class="text-start align-middle"><?= $row['accessory_code'] ?></td>
                                            <td class="text-capitalize text-start align-middle"><?= $row['brand_title'] ?></td>
                                            <td class="text-capitalize text-start align-middle"><?= $row['category_title'] ?></td>
                                            <td class="text-capitalize text-start align-middle"><?= $row['accessory_name'] ?></td>
                                            <td class="text-capitalize text-start align-middle">
                                                <select class='form-control text-uppercase'><option value=''>No IMEI for Accessory</option></select>
                                            </td>
                                            <td class="text-center align-middle"><?= $row['original_price'] ?></td>
                                            <td class="text-center align-middle"><?= $row['selling_price'] ?></td>
                                            <td class="text-center align-middle"><?= $row['acc_qty'] ?></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center align-middle'>No accessories found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
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
  document.addEventListener("DOMContentLoaded", function () {
    const selectCustomerButtons = document.querySelectorAll('.selectCustomer');
    selectCustomerButtons.forEach(function (button) {
      button.addEventListener('click', function () {
        const row = button.closest('tr');
        const customerName = row.querySelectorAll('td')[1].textContent.trim();
        const email = row.querySelectorAll('td')[2].textContent.trim();
        const phone = row.querySelectorAll('td')[3].textContent.trim();
        const address = row.querySelectorAll('td')[4].textContent.trim();

        // Update respective fields with customer details
        document.querySelector('input[name="u_customer_name"]').value = customerName;
        document.querySelector('input[name="u_email"]').value = email;
        document.querySelector('input[name="u_phone"]').value = phone;
        document.querySelector('textarea[name="u_address"]').value = address;

        // Close the modal after selecting a customer
        $('#customerModal').modal('hide');
      });
    });
  });
</script>



<script>
  document.addEventListener("DOMContentLoaded", function () {
    const selectButtons = document.querySelectorAll('.selectProducts');

    selectButtons.forEach(function (button) {
      button.addEventListener('click', function () {
        const row = button.closest('tr');
        const code = row.querySelectorAll('td')[1].textContent.trim();
        const brand = row.querySelectorAll('td')[2].textContent.trim();
        const category = row.querySelectorAll('td')[3].textContent.trim();
        const productName = row.querySelectorAll('td')[4].textContent.trim();
        const imeiSelect = row.querySelector('select'); 
        const selectedIMEI = imeiSelect.value; 
        const mrp = parseFloat(row.querySelectorAll('td')[6].textContent);
        const sp = parseFloat(row.querySelectorAll('td')[7].textContent);
        const qtyAvailable = parseFloat(row.querySelectorAll('td')[8].textContent);

        if (qtyAvailable > 0) {
          const tableBody = document.querySelector('#selectedItemsBody');
          const newRow = tableBody.insertRow();

          newRow.innerHTML = `
            <td><input type="text" class="text-center form-control align-middle" name="product_code[]" value="${code}" readonly></td>
            <td><input type="text" class="text-center form-control align-middle" value="${brand}" name="brand[]" readonly></td>
            <td><input type="text" class="text-center form-control align-middle" value="${category}" name="category[]" readonly></td>
            <td><input type="text" class="text-start form-control align-middle" name="product_name[]" value="${productName}" readonly></td>
            <td><input type="text" class="text-center form-control align-middle imei" name="imei[]" value="${selectedIMEI}" readonly></td>
            <td><input type="number" class="text-center form-control align-middle mrp" name="mrp[]" value="${mrp}" readonly></td>
            <td><input type="number" class="text-center form-control align-middle sp" value="${sp}" name="sp[]" readonly></td>
            <td><input type="number" class="text-center form-control align-middle quantity" name="quantity[]" value="1" min="1" max="${qtyAvailable}"></td>
            <td><input type="number" class="text-center form-control align-middle total" name="total[]" value="${sp}" readonly></td>
            <td><button type="button" class="text-center btn btn-danger align-middle btn-sm deleteRow"><i class="bi bi-trash"></i></button></td>
          `;

          const quantityInputs = document.querySelectorAll('.quantity');
          quantityInputs.forEach(function (input) {
            input.addEventListener('input', calculateTotal);
          });

          const deleteButtons = document.querySelectorAll('.deleteRow');
          deleteButtons.forEach(function (delButton) {
            delButton.addEventListener('click', function () {
              delButton.closest('tr').remove();
              calculateTotal();
            });
          });

          calculateTotal();
          $('#productModal').modal('hide');
        } else {
          // Provide some tooltip/alert when the quantity is not available
          alert('This product is out of stock.');
        }
      });
    });

    function calculateTotal() {
      let total = 0;
      const rows = document.querySelectorAll('#productTable tbody tr');
      rows.forEach(function (row) {
        // Calculate total per item
        const sp = parseFloat(row.querySelector('.sp').value);
        const qty = parseFloat(row.querySelector('.quantity').value);
        const totalCell = row.querySelector('.total');
        const totalPrice = sp * qty;
        totalCell.value = totalPrice.toFixed(2);
        total += totalPrice;
      });

      // Calculate CGST and SGST based on the total price
      const cgstRate = 9; 
      const sgstRate = 9; 

      const cgst = (total * cgstRate) / 100;
      const sgst = (total * sgstRate) / 100;

      // Update the CGST and SGST input fields with the calculated values
      document.getElementById('inputCGST').value = cgst.toFixed(2);
      document.getElementById('inputSGST').value = sgst.toFixed(2);

      // Calculate total price including CGST and SGST
      const totalPriceIncludingGST = total ;

      // Update the total price input field
      const totalPriceInput = document.getElementById('inputTotalPrice');
      totalPriceInput.value = totalPriceIncludingGST.toFixed(2);

      const numericValue = parseFloat(totalPriceInput.value);
      const words = convertPriceToWords(numericValue);

      document.getElementById('inputTotalPriceInWords').value = words;

    }

    const gstInputs = document.querySelectorAll('#inputCGST, #inputSGST');
    gstInputs.forEach(function (input) {
      input.addEventListener('input', calculateTotal);
    });

        // Logic to convert numeric value to words
    function convertToWords(num) {
      const ones = [
        '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
        'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
      ];
      const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

      if (num === 0) return 'Zero';

      let words = '';

      if (num >= 100000) {
        words += ones[Math.floor(num / 100000)] + ' Lakh ';
        num %= 100000;
      }

      if (num >= 1000) {
        words += convertToWords(Math.floor(num / 1000)) + ' Thousand ';
        num %= 1000;
      }

      if (num >= 100) {
        words += ones[Math.floor(num / 100)] + ' Hundred ';
        num %= 100;
      }

      if (num >= 20) {
        words += tens[Math.floor(num / 10)] + ' ';
        num %= 10;
      }

      if (num > 0) {
        words += ones[num] + ' ';
      }

      return words.trim();
    }

    // Function to convert price to words
    function convertPriceToWords(price) {
      const words = convertToWords(Math.floor(price));
      return words + ' Rupees Only';
    } 

    // Event listener to update Total Price in Words on input change
    document.getElementById('inputTotalPrice').addEventListener('input', function() {
      const numericValue = parseFloat(this.value);
      const words = convertPriceToWords(numericValue);
      document.getElementById('inputTotalPriceInWords').value = words;
    });
   
  });

  function validateProductList() {
    // Get the table body element
    let tableBody = document.getElementById('selectedItemsBody');

    // Check if the table body has any rows
    if (tableBody.children.length === 0) {
      alert('Please select at least one item from the product list.');
      return false; // Prevent form submission
    }
    return true; // Allow form submission if items are selected
  }
</script>