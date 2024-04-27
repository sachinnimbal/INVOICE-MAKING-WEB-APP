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
            <h1>Customer Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index">Home</a></li>
              <li class="breadcrumb-item active">Customer</li>
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
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Customer List</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered text-nowrap table-responsive-lg">
                <thead>
                  <tr>
                    <th class="text-start">#</th>
                    <th class="text-start">Action</th>
                    <th class="text-start">Full Name</th>
                    <th class="text-start">Phone</th>
                    <th class="text-start">Address</th>
                    <th class="text-center">Created On</th>
                    <th class="text-center">Updated On</th>
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
                      <?= ++$counter ?>
                    </td>
                    <td class="text-center align-middle">
                      <a href="customer?customer_id=<?= $row['customer_id']; ?>" class="btn btn-sm btn-primary myTooltip" data-toggle="tooltip" 
                          data-placement="bottom" 
                          title="Edit"><i class="bi bi-pencil-square"></i></a>
                      <!-- <button type="button" class="btn btn-sm btn-danger deleteCustomer myTooltip"
                        data-placement="bottom" data-toggle="tooltip" 
                        title="Remove" data-customer-id="<?= $row['customer_id']; ?>">
                        <i class="bi bi-trash-fill"></i>
                      </button> -->
                    </td>
                    <td class="text-capitalize text-start align-middle">
                      <?= $row['full_name'] ?>
                    </td>
                    <td class="text-center align-middle">
                      <?= $row['phone'] ?>
                    </td>
                    <td class="text-start align-middle text-capitalize">
                      <?= $row['address'] ?>
                    </td>
                    <td class="text-center align-middle"><?= $row['created_at'] ?></td>
                    <td class="text-center align-middle">
                        <?= $row['updated_at'] !== null ? $row['updated_at'] : 'NA' ?>
                    </td>
                  </tr>
                <?php
                  }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No customer found</td></tr>";
                    }
                    ?>
                </tbody>

              </table>
            </div>
            <!-- /.card-body -->
            </div>
          <!-- /.card -->
        </div>
        <div class="col-md-4">
          <!-- ============= Edit Customer Data ============ -->
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Edit Customer</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <?php
                include_once 'connection.php';
                if (isset($_GET['customer_id'])) {
                $customer_id = $_GET['customer_id'];
                $sql = "SELECT * FROM `customers` WHERE customer_id='$customer_id'";
                $query_run = mysqli_query($conn, $sql);
                if (mysqli_num_rows($query_run) > 0) {
                $rows = mysqli_fetch_assoc($query_run);
              ?>
              <form action="update_query" method="POST" enctype="multipart/form-data" autocomplete="off"  class="needs-validation" novalidate>
                <input type="hidden" name="customer_id" class="form-control my-1" value="<?php echo $rows['customer_id']; ?>">
                <div class="form-group">
                  <label htmlFor="inputName">Full Name</label>
                  <input type="text" name="update_customer_name" placeholder="Full Name" class="form-control" value="<?php echo $rows['full_name']; ?>" required />
                  <div class="invalid-feedback">
                      Please provide a valid full name.
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="form-group">
                  <label htmlFor="inputName">Phone Number</label>
                  <input type="text" id="inputPhone" name="update_phone" placeholder="Phone Number" value="<?php echo $rows['phone']; ?>" class="form-control" required />
                  <div class="invalid-feedback">
                      Please provide a valid phone number.
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="form-group">
                  <label htmlFor="inputName">Billing Address</label>
                  <textarea class="form-control" name="update_address"
                    placeholder="Billing Address" oninput="capitalizeInput(this)"
                    required><?php echo $rows['address']; ?></textarea>
                    <div class="invalid-feedback">
                      Please provide a valid billing address.
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>              
                <div class="row">
                  <div class="col-12 mt-2">
                    <button type="submit" name="update_Customer" class="btn btn-primary btn-block">
                      Update Customer
                    </button>
                  </div>
                </div>
              </form>
              <?php
              } else {
                echo "No Customer found with this ID.";
                }
              } else {
                echo '<div class="text-center">';
                echo "Customer ID not provided.";
                echo '<br/>Editing form will available only when you click on <i class="bi bi-pencil-square"></i> edit icon.';
                echo '</div>';                            
              }
              ?>
            </div>
            <!-- /.card-body -->
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
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.deleteCustomer');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const customerId = this.getAttribute('data-customer-id');
                const confirmation = confirm('Are you sure you want to delete this customer?');

                if (confirmation) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'delete_query'; 

                    const inputCustomerId = document.createElement('input');
                    inputCustomerId.type = 'hidden';
                    inputCustomerId.name = 'customer_id';
                    inputCustomerId.value = customerId; // Fix variable name here

                    form.appendChild(inputCustomerId);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>