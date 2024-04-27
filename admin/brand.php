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
            <h1>Brand Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index">Home</a></li>
              <li class="breadcrumb-item active">Brand</li>
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
              <h3 class="card-title">Brand List</h3>
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
                            <th class="text-center">Logo</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Created On</th>
                            <th class="text-center">Updated On</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php
                        include_once "connection.php";
                        $sql = "SELECT * FROM `brand` ORDER BY brand_id ASC";
                        $res = mysqli_query($conn, $sql);

                        if ($res && mysqli_num_rows($res) > 0) {
                            $counter = 0;
                            while ($row = mysqli_fetch_assoc($res)) {
                                ?>
                                <tr>
                                    <td class="text-center align-middle"><?= ++$counter ?></td>
                                    <td class="text-center align-middle">
                                      <a href="brand?brand_id=<?= $row['brand_id']; ?>" class="btn btn-sm mt-1 btn-primary myTooltip" 
                                          data-toggle="tooltip" 
                                          data-placement="bottom" 
                                          title="Edit"><i class="bi bi-pencil-square"></i></a>
                                      <button type="button" class="btn btn-sm btn-danger deleteBrand mt-1 myTooltip" data-toggle="tooltip" 
                                          data-placement="bottom" 
                                          title="Remove" data-brand-id="<?= $row['brand_id']; ?>">
                                          <i class="bi bi-trash-fill"></i>
                                      </button>
                                    </td>
                                    <td class="text-center align-middle m-0 p-1">
                                        <?php
                                        if ($row['brand_img'] == '') {
                                            echo '<img class="img img-thumbnail" width="80" height="50" src="./assets/images/logo.png" alt="No Image">';
                                        } else {
                                            echo '<img class="img img-thumbnail" width="120" height="80" src="Brand_logo/' . $row['brand_img'] . '" alt="' . $row['brand_title'] . '">';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center align-middle text-capitalize"><?= $row['brand_title'] ?></td>
                                    <td class="text-center align-middle"><?= $row['created_at'] ?></td>
                                    <td class="text-center align-middle">
                                        <?= $row['updated_at'] !== null ? $row['updated_at'] : 'NA' ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No brands found</td></tr>";
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
              <h3 class="card-title">Add Brand</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <form action="insert_query" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>
                <div class="input-group mb-3">
                  <input type="text" name="brand_title" placeholder="Apple" class="form-control text-capitalize" required />
                    <div class="invalid-tooltip">
                      Please provide a valid brand title.
                    </div>
                    <div class="valid-tooltip">
                      Looks good!
                    </div>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="bi bi-tag"></span>
                      </div>
                    </div>
                </div>
                <div class="form-group">
                  <div class="custom-file">
                    <input type="file" name="brand_logo" class="custom-file-input" id="customFile" accept="image/*"  onchange="previewImage(event, 'imagePreview')" >
                    <label class="custom-file-label" for="customFile">Choose Logo</label>
                    <div class="invalid-tooltip">
                      Please provide a valid brand logo.
                    </div>
                    <div class="valid-tooltip">
                      Looks good!
                    </div>
                  </div>
                  <div class="preview-image m-2">
                    <img id="imagePreview" src="#" alt="Selected Image" style="display: none;" class="img img-thumbnail w-50">
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <button type="submit" name="save_brand" class="btn btn-primary btn-block">
                      Save Brand
                    </button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card  -->
          <!-- =============Edit Brand============ -->
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Edit Brand</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <?php
                include_once 'connection.php';
                if (isset($_GET['brand_id'])) {
                $brand_id = $_GET['brand_id'];
                $sql = "SELECT * FROM `brand` WHERE brand_id='$brand_id'";
                $query_run = mysqli_query($conn, $sql);
                if (mysqli_num_rows($query_run) > 0) {
                $rows = mysqli_fetch_assoc($query_run);
              ?>
              <form action="update_query" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>
                <input type="hidden" name="brand_id" class="form-control my-1" value="<?php echo $rows['brand_id']; ?>">
                <div class="input-group mb-3">
                  <input type="text" name="update_brand_title" value="<?php echo $rows['brand_title']; ?>" placeholder="Apple" class="form-control text-capitalize" />
                    <div class="invalid-tooltip">
                      Please provide a valid brand title.
                    </div>
                    <div class="valid-tooltip">
                      Looks good!
                    </div>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="bi bi-tag"></span>
                      </div>
                    </div>
                </div>
                <div class="form-group">
                <div class="custom-file">
                  <input type="file" name="update_brand_logo" class="custom-file-input" id="customFile" accept="image/*" onchange="previewImage(event, 'imagePreview1')">
                    <label class="custom-file-label" for="customFile">Choose Logo</label>
                    <div class="invalid-tooltip">
                      Please provide a valid brand logo.
                    </div>
                    <div class="valid-tooltip">
                      Looks good!
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="preview-image">
                      <label for="validationCustom08" class="form-label">Previous Brand Logo</label>
                        <?php
                          if ($rows['brand_img'] == '') {
                            echo '<img class="img img-thumbnail" width="180" height="160" src="./assets/images/logo.png" alt="No Image">';
                          } else {
                              echo '<img class="img img-thumbnail" width="180" height="140" src="Brand_logo/' . $rows['brand_img'] . '" alt="Accessory Image">';
                          }
                        ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="preview-image">
                      <label for="validationCustom08" class="form-label">New Brand Logo</label>
                      <img id="imagePreview1" src="#" width="180" height="140" alt="Selected Image" style="display: none;" class="img img-thumbnail">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 mt-2">
                    <button type="submit" name="update_Brand" class="btn btn-primary btn-block">
                      Update Brand
                    </button>
                  </div>
                </div>
              </form>
              <?php
              } else {
                echo "No brand found with this ID.";
                }
              } else {
                echo '<div class="text-center">';
                echo "Brand ID not provided.";
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
  document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.deleteBrand');

    deleteButtons.forEach(button => {
      button.addEventListener('click', function () {
        const brandId = this.getAttribute('data-brand-id');
        const confirmation = confirm('Are you sure you want to delete this brand?');

        if (confirmation) {
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = 'delete_query';

          const inputBrandId = document.createElement('input');
          inputBrandId.type = 'hidden';
          inputBrandId.name = 'brand_id';
          inputBrandId.value = brandId;

          form.appendChild(inputBrandId);
          document.body.appendChild(form);
          form.submit();
        }
      });
    });
  });
</script>

