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
            <h1>Accessory List Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index">Home</a></li>
              <li class="breadcrumb-item active">Accessory List</li>
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
              <h3 class="card-title">Accessory List</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool btn-sm btn-dark"  id="otherActionBtn">
                  Add New Accessory
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body table-responsive">
              <?php
              include_once 'connection.php';

              $sql = "SELECT * FROM `accessory`";
              $result = $conn->query($sql);

              if ($result && $result->num_rows > 0) {
                  ?>
                  <table id="example1" class="table table-head-fixed table-bordered text-nowrap table-responsive-lg">
                        <thead>
                          <tr>
                              <th class="text-start myTooltip" data-toggle="tooltip" 
                                data-placement="bottom" 
                                title="Accessory Code"><i class="bi bi-eye mr-3"></i>Code</th>
                              <th class="text-start">Action</th>
                              <th class="text-start">Category</th>
                              <th class="text-start">Name</th>
                              <th class="text-start myTooltip" data-toggle="tooltip" 
                                data-placement="bottom" 
                                title="Original Price"><i class="bi bi-currency-rupee"></i>MRP</th>
                              <th class="text-start myTooltip"
                                data-placement="bottom" data-toggle="tooltip" 
                                title="Selling Price"><i class="bi bi-currency-rupee"></i>SP</th>
                              <th class="text-start myTooltip" data-placement="bottom" data-toggle="tooltip" 
                                title="Quantity">Qty</th>
                              <th class="text-start">Status</th>
                              <th class="text-start">Condition</th>
                              <th class="text-start">Date</th>
                          </tr>
                        </thead>
                      <tbody>
                          <?php
                          while ($row = $result->fetch_assoc()) {
                              ?>
                                <tr>
                                  <td class="text-center align-middle m-1 p-1">
                                    <a class="myTooltip" href="view-accessory?accessory_id=<?= $row['accessory_id'] ?>" data-toggle="tooltip" 
                                        data-placement="bottom" 
                                        title="View"> 
                                  <?php
                                    if ($row['image'] == '') {
                                        echo '<img class="img img-thumbnail" width="80" height="60" src="./assets/images/favicon.png" alt="No Image">';
                                    } else {
                                        echo '<img class="img img-thumbnail" width="80" height="50" src="Product_img/' . $row['image'] . '" alt="Accessory Image">';
                                    }
                                    ?>
                                    <p class="text-black m-0 p-0"><?= $row['accessory_code'] ?></p></a>
                                  </td>
                                  <td class="text-center align-middle">
                                    <a href="accessory-edit?accessory_id=<?= $row['accessory_id']; ?>" class="btn btn-sm btn-primary myTooltip" 
                                        data-toggle="tooltip" 
                                        data-placement="bottom" 
                                        title="Edit"><i class="bi bi-pencil-square"></i></a>
                                    <button type="button" class="btn btn-sm btn-danger deleteAccessory myTooltip" data-toggle="tooltip" 
                                        data-placement="bottom" 
                                        title="Remove" data-id="<?= $row['accessory_id']; ?>">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                  </td>
                                  
                                  <td class="text-capitalize text-center align-middle">
                                    <p class="m-0 p-0 text-success text-bold"><i class="bi bi-tag-fill mr-2"></i><?= $row['brand_title'] ?></p>
                                    <p class="m-0 p-0"><?= $row['category_title'] ?></p>
                                  </td>
                                  <td class="text-capitalize text-start align-middle">
                                      <?= $row['accessory_name'] ?>
                                  </td>
                                  <td class="text-center align-middle">
                                    <span class="text-muted text-bold"><i class="bi bi-currency-rupee"></i><?= $row['original_price'] ?></span>
                                  </td>
                                  <td class="text-center align-middle">
                                    <span class="text-success text-bold" ><i class="bi bi-currency-rupee"></i><?= $row['selling_price'] ?></span>
                                  </td>
                                  <td class="text-center align-middle">
                                      <?= $row['acc_qty'] ?>
                                  </td>
                                  <td class="text-center align-middle">
                                    <?php 
                                        if ($row['status'] == 1) {
                                            echo '<span class="btn badge badge-pill badge-success text-success myTooltip" 
                                                data-toggle="tooltip" 
                                                data-placement="bottom" 
                                                title="Active">a</span>';
                                        } else {
                                            echo '<span class="btn badge badge-pill badge-danger text-danger myTooltip" 
                                                data-toggle="tooltip" 
                                                data-placement="bottom" 
                                                title="Inactive">i</span>';
                                        }
                                    ?>
                                  </td>
                                  <td class="text-center align-middle">
                                    <span class="text-capitalize"><?= $row['condition_name']; ?></span>
                                  </td>
                                  <td class="text-center align-middle">
                                    <span class="myTooltip  m-0 p-0" data-toggle="tooltip" 
                                        data-placement="bottom"  style="cursor: pointer;"
                                        title="Created On"><?= date('Y-m-d', strtotime($row['created_at'])) ?></span><br>
                                    <span class="myTooltip" data-toggle="tooltip" 
                                        data-placement="bottom" 
                                        title="Updated On"  style="cursor: pointer;"><?= $row['updated_at'] !== null ? date('Y-m-d', strtotime($row['updated_at'])) : 'NA' ?></span>
                                  </td>

                              </tr>
                              <?php
                          }
                          ?>
                      </tbody>
                  </table>
                  <?php
              } else {
                  echo "No accessory found";
              }
              ?>
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
  document.getElementById('otherActionBtn').addEventListener('click', function() {
    // Redirect to another PHP page
    window.location.href = 'add-accessories';
  });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.deleteAccessory');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const accessoryId = this.getAttribute('data-id'); 
                const confirmation = confirm('Are you sure you want to delete this Accessory?');

                if (confirmation) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'delete_query'; 

                    const inputAccessoryId = document.createElement('input');
                    inputAccessoryId.type = 'hidden';
                    inputAccessoryId.name = 'accessory_id';
                    inputAccessoryId.value = accessoryId;

                    form.appendChild(inputAccessoryId);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>