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
            <h1>Category Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index">Home</a></li>
              <li class="breadcrumb-item active">Category</li>
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
              <h3 class="card-title">Category List</h3>
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
                    <th class="text-center">#</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">Category Title</th>
                    <th class="text-center">Created On</th>
                    <th class="text-center">Updated On</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                      include_once "connection.php";
                      $sql = "SELECT * FROM `category` ORDER BY category_id ASC";
                      $res = mysqli_query($conn, $sql);

                      if ($res && mysqli_num_rows($res) > 0) {
                          $counter = 0;
                          while ($row = mysqli_fetch_assoc($res)) {
                              ?>
                  <tr>
                    <td class="text-center align-middle"><?= ++$counter ?></td>
                    <td class="text-center align-middle">
                      <a href="category?category_id=<?= $row['category_id']; ?>" class="btn btn-sm btn-primary myTooltip" data-toggle="tooltip" 
                          data-placement="bottom" 
                          title="Edit"><i class="bi bi-pencil-square"></i></a>
                      <button type="button" class="btn btn-sm btn-danger deleteCategory myTooltip"
                        data-placement="bottom" data-toggle="tooltip" 
                        title="Remove" data-category-id="<?= $row['category_id']; ?>">
                        <i class="bi bi-trash-fill"></i>
                      </button>
                    </td>
                    <td class="text-center align-middle"><?= $row['category_title'] ?></td>
                    <td class="text-center align-middle"><?= $row['created_at'] ?></td>
                    <td class="text-center align-middle"><?= $row['updated_at'] !== null ? $row['updated_at'] : 'NA' ?></td>
                  </tr>
                <?php
                  }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No category found</td></tr>";
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
          <!-- =============Add Brand============ -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Category</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <p class="text-wrap lh-base">Please enter the product category. This will help in adding the product to
              different categories such as <b>Mobiles, Laptops, Tablets or click <i class="bi bi-info-circle-fill text-success btn btn-sm" 
              type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></i> to know more about which category is valid</b>.</p>
              <div class="collapse" id="collapseExample">
                <div class="card card-body m-1 p-1">
                <div class="card-title text-info text-bold">Allowed Categories Pick Correctly</div>
                <hr class="m-0 p-0 text-muted">
                  <p class="text-justify">
                    Accessory, accessories, Adapter, Battery Pack, Cable, Cables, Cell Phones, charger, Charger, Charging Adapter, Charging Cable, Earphones, E-Reader, HeadPhone, Headphones, Headset, iPad, Laptop, Laptops, Mobile Phone, Mobile Phones, Notebook PC, Notebooks, Phablets, Phone Stand, Power Bank, Smart Band, Smart Watch, Smart Watches, Smartphone, Smart Wearable, Smart Wristband, Tablet, Tablets, Ultrabooks, USB Cable, Wireless Charger
                  </p>
                </div>
              </div>
              <form action="insert_query" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>
                <div class="input-group mb-3">
                  <input type="text" placeholder="Mobile Phone" id="validationTooltip01" name="category_title" class="form-control text-capitalize" required/>
                  <div class="invalid-tooltip">
                    Please provide a valid category title.
                  </div>
                  <div class="valid-tooltip">
                    Looks good!
                  </div>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="bi bi-layers"></span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <button type="submit" name="save_Category" class="btn btn-primary btn-block" onclick="validateCategory()">
                      Save Category
                    </button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card  -->
          <!-- =============Edit Category============ -->
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Edit Category</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <?php
                include_once 'connection.php';
                if (isset($_GET['category_id'])) {
                  $category_id = $_GET['category_id'];
                    $sql = "SELECT * FROM `category` WHERE category_id='$category_id'";
                      $query_run = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($query_run) > 0) {
                      $rows = mysqli_fetch_assoc($query_run);
              ?>
              <form action="update_query" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>
                <input type="hidden" name="category_id" class="form-control my-1" value="<?php echo $rows['category_id']; ?>">
                <div class="input-group mb-3">
                  <input type="text" name="update_category_title" id="validationTooltip01" value="<?php echo $rows['category_title']; ?>" placeholder="Apple" class="form-control text-capitalize" required/>
                    <div class="invalid-tooltip">
                      Please provide a valid category title.
                    </div>
                    <div class="valid-tooltip">
                      Looks good!
                    </div>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="bi bi-layers"></span>
                      </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-12 mt-2">
                    <button type="submit" name="update_Category" class="btn btn-primary btn-block">
                      Update Category
                    </button>
                  </div>
                </div>
              </form>
              <?php
              } else {
                echo "No category found with this ID.";
                }
              } else {
                echo '<div class="text-center">';
                echo "Category ID not provided.";
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
        const deleteButtons = document.querySelectorAll('.deleteCategory');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-category-id');
                const confirmation = confirm('Are you sure you want to delete this category?');

                if (confirmation) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'delete_query';

                    const inputCategoryId = document.createElement('input');
                    inputCategoryId.type = 'hidden';
                    inputCategoryId.name = 'category_id';
                    inputCategoryId.value = categoryId;

                    form.appendChild(inputCategoryId);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>

<script>
  function validateCategory() {
    // List of valid categories
    const validCategories = [
      "Accessories", "HeadPhones", "headphones", "cable", "charger", "Accessory", "Headphone", "Cables", "Charger",
      "accessories", "Headphones", "Cable", "Charger", "Headset", "Charging Cable", "Adapter", "Power Bank",
      "Wireless Charger", "Earphones", "USB Cable", "Headset", "Charging Adapter", "Phone Stand", "Battery Pack",
      "Mobile Phones", "Laptops", "Tablets", "Smart Watch", "Smart Watches", "Mobile Phone", "Laptop", "Tablet",
      "Tablets", "Cell Phones", "Notebooks", "Phablets", "Ultrabooks", "iPad", "Smartphone", "Notebook PC",
      "E-Reader", "Smart Wristband", "Smart Wearable", "Smart Band"
    ];

    const userInput = document.getElementById("validationTooltip01").value.trim();
    const isValidCategory = validCategories.includes(userInput);

    if (!isValidCategory) {
      // Show error message or prevent form submission
      alert("Error: Invalid category title. Please enter a valid category.");
      event.preventDefault(); // Prevent form submission
    }
  }
</script>