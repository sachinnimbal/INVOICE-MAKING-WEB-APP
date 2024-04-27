<?php include './includes/header.php'; 
  include 'connection.php';
  $sql_products = "SELECT * FROM `products`";
  $sql_category = "SELECT * FROM `category`";
  $sql_brand = "SELECT * FROM `brand`";
  $sql_invoice = "SELECT * FROM `invoices`";
  $sql_customers = "SELECT * FROM `customers`";
  $sql_conditions = "SELECT * FROM `conditions`";
  $sql_accessory = "SELECT * FROM `accessory`";
  $sql_exchange = "SELECT * FROM `exchange_product`";
  $sql_users = "SELECT * FROM `Users`";

  $products = mysqli_query($conn, $sql_products);
  $category = mysqli_query($conn, $sql_category);
  $brand = mysqli_query($conn, $sql_brand);
  $invoice = mysqli_query($conn, $sql_invoice);
  $customers = mysqli_query($conn, $sql_customers);
  $conditions = mysqli_query($conn, $sql_conditions);
  $accessory = mysqli_query($conn, $sql_accessory);
  $exchange = mysqli_query($conn, $sql_exchange);
  $Users = mysqli_query($conn, $sql_users);
?>

<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
    <?php include './includes/navbar.php'; 
      if (!isset($_SESSION['has_displayed_status'])) {
        $_SESSION['status'] = "Welcome Back <b class='text-light text-capitalize'>$name</b>";
        $_SESSION['has_displayed_status'] = true;
      }  
    ?>
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
            <h1>Home Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Home</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <?php include 'alert.php'; ?>

      <div class="row">   
         <div class="col-md-8">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Quick Info</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body bg-light">
              <div class="row">

              <?php 
                include './includes/quick-links.php';
              ?>

              </div>
            </div>
          </div>
        </div>
         <div class="col-md-4">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Quick Links</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body bg-light">
            <div class="row">
            <div class="col-12">
              <button type="submit" id="addExchangeItemBtn" class="btn btn-primary btn-block mt-2 mb-2">
                Exchange Item<i class="bi bi-repeat ml-2"></i>
              </button>
              <button type="submit" id="createInvoiceBtn" class="btn btn-primary btn-block mt-2 mb-2">
                Create Invoice<i class="bi bi-receipt ml-2"></i>
              </button>
              <button type="submit" id="addProductsBtn" class="btn btn-primary btn-block mt-2 mb-2">
                Add Product<i class="bi bi-phone ml-2"></i>
              </button>
              <button type="submit" id="addAccessoryBtn" class="btn btn-primary btn-block mt-2 mb-2">
                Add Accessory<i class="bi bi-headset ml-2"></i>
              </button>
            </div>
          </div>
          <!-- =============Add Customers============ -->
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Quick Add Customers</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <form action="query" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="bi bi-person"></span>
                      </div>
                    </div>
                  <input type="text" name="full_name" placeholder="Full Name" class="form-control text-capitalize" required />
                    <div  class="invalid-feedback">
                      Please provide a valid full name.
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span class="bi bi-phone"></span>
                    </div>
                  </div>
                    <input type="text" id="inputPhone" name="phone" placeholder="Phone Number" class="form-control"
                      required maxlength="10" oninput="validatePhone()" />
                    <div  class="invalid-feedback">
                      Please provide a valid phone number.
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span class="bi bi-geo-alt"></span>
                    </div>
                  </div>
                  <textarea class="form-control text-capitalize" name="address"
                    placeholder="Billing Address" style="height: 40px;"
                    required></textarea>
                    <div class="invalid-feedback">
                      Please provide a valid billing address.
                    </div>
                    <div class="valid-feedback">
                      Looks good!
                    </div>
                </div>             
                <div class="row">
                  <div class="col-12">
                    <button type="submit" name="save_Customer" class="btn btn-primary btn-block">
                      Save Customer
                    </button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
            </div>
          </div>
        </div>
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
    // Get the elements by their IDs
    const productsBox = document.getElementById('productsBox');
    const invoicesBox = document.getElementById('invoicesBox');
    const brandsBox = document.getElementById('brandsBox');
    const categoriesBox = document.getElementById('categoriesBox');
    const customerBox = document.getElementById('customerBox');
    const createInvoiceBtn = document.getElementById('createInvoiceBtn');
    const conditionBox = document.getElementById('conditionBox');
    const accessoryBox = document.getElementById('accessoryBox');
    const exchangeBox = document.getElementById('exchangeBox');
    const usersBox = document.getElementById('usersBox');
    const addProductsBtn = document.getElementById('addProductsBtn');
    const addAccessoryBtn = document.getElementById('addAccessoryBtn');
    const addExchangeItemBtn = document.getElementById('addExchangeItemBtn');
    
    // Add click event listeners to redirect to respective pages
    productsBox.addEventListener('click', function() {
        window.location.href = 'product-list';
    });

    invoicesBox.addEventListener('click', function() {
        window.location.href = 'invoice-history';
    });

    brandsBox.addEventListener('click', function() {
        window.location.href = 'brand';
    });

    categoriesBox.addEventListener('click', function() {
        window.location.href = 'category';
    });

    customerBox.addEventListener('click', function() {
        window.location.href = 'customer';
    });

    createInvoiceBtn.addEventListener('click', function() {
        window.location.href = 'create-invoice';
    });

    conditionBox.addEventListener('click', function() {
        window.location.href = 'condition';
    });

    accessoryBox.addEventListener('click', function() {
      window.location.href = 'accessory-list';
    });

    exchangeBox.addEventListener('click', function() {
      window.location.href = 'exchange-history';
    });

    addProductsBtn.addEventListener('click', function() {
      window.location.href = 'add-products';
    });

    addExchangeItemBtn.addEventListener('click', function() {
      window.location.href = 'exchange-item';
    });

    addAccessoryBtn.addEventListener('click', function() {
      window.location.href = 'add-accessories';
    });

    usersBox.addEventListener('click', function() {
      window.location.href = 'user-list';
    });


</script>

