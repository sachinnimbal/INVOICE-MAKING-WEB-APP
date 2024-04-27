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
                        <h1>Edit Accessory Page</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index">Home</a></li>
                            <li class="breadcrumb-item active">Edit Accessory</li>
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
                            <h3 class="card-title">Edit Accessory</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                        <?php
                            include_once 'connection.php';

                            if (isset($_GET['accessory_id'])) {
                                $accessory_id = $_GET['accessory_id'];

                                // Fetch accessory details based on id
                                $sql = "SELECT * FROM `accessory` WHERE accessory_id='$accessory_id'";
                                $query_run = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($query_run) > 0) {
                                    $rows = mysqli_fetch_assoc($query_run);
                                    // Display the fetched accessory details in an editable form
                                    ?>
                            <form action="update_query" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="accessory_id" class="form-control my-1" value="<?php echo $rows['accessory_id']; ?>">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="category">Category Title</label>
                                            <select class="form-control text-capitalize" id="category" name="update_category" required>
                                                <?php
                                                include_once 'connection.php';
                                                // Fetch category titles from the 'category' table
                                                $sql = "SELECT category_title FROM `category`";
                                                $result = $conn->query($sql);

                                                if ($result && $result->num_rows > 0) {
                                                    // Output data of each row
                                                    while ($row = $result->fetch_assoc()) {
                                                        $selected = ($row["category_title"] === $rows['category_title']) ? 'selected' : '';
                                                        echo "<option value='" . $row["category_title"] . "' $selected>" . $row["category_title"] . "</option>";
                                                    }
                                                } else {
                                                    echo "<option>No category found</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="brand">Brand Title</label>
                                            <select class="form-control text-capitalize" id="brand" name="update_brand" required>
                                                <?php
                                                include_once 'connection.php';
                                                // Fetch brand titles from the 'brand' table
                                                $sql = "SELECT brand_title FROM `brand`";
                                                $result = $conn->query($sql);

                                                if ($result && $result->num_rows > 0) {
                                                    // Output data of each row
                                                    while ($row = $result->fetch_assoc()) {
                                                        $selected = ($row["brand_title"] === $rows['brand_title']) ? 'selected' : '';
                                                        echo "<option value='" . $row["brand_title"] . "' $selected>" . $row["brand_title"] . "</option>";
                                                    }
                                                } else {
                                                    echo "<option>No brand found</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="condition">Accessory Condition</label>
                                            <select class="form-control text-capitalize" id="condition" name="update_condition_name" required>
                                                <?php
                                                include_once 'connection.php';
                                                // Fetch condition names from the 'conditions' table
                                                $sql = "SELECT condition_name FROM `conditions`";
                                                $result = $conn->query($sql);

                                                if ($result && $result->num_rows > 0) {
                                                    // Output data of each row
                                                    while ($row = $result->fetch_assoc()) {
                                                        $selected = ($row["condition_name"] === $rows['condition_name']) ? 'selected' : '';
                                                        echo "<option value='" . $row["condition_name"] . "' $selected>" . $row["condition_name"] . "</option>";
                                                    }
                                                } else {
                                                    echo "<option>No condition found</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="accessory_name">Accessory Name</label>
                                            <input type="text" class="form-control" id="accessory_name" oninput="capitalizeNameInput(this)"
                                            value="<?php echo $rows['accessory_name']; ?>"  name="update_accessory_name" placeholder="Accessory Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="slug">Slug</label>
                                            <input type="text" class="form-control" id="slug" name="update_slug"
                                            value="<?php echo $rows['slug']; ?>"  placeholder="Slug" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="qty">Quantity</label>
                                            <input type="number" class="form-control" min="0" name="update_qty" placeholder="Quantity"
                                            value="<?php echo $rows['acc_qty']; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="original_price">Original Price</label>
                                            <input type="number" class="form-control" name="update_original_price" min="1" max="999999"
                                            value="<?php echo $rows['original_price']; ?>"   placeholder="Enter Accessory Original Price (Max 6 digits)" required oninput="convertPriceToWords(this.value, 'accessoryMRPWords')">
                                                <div id="accessoryMRPWords"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="selling_price">Selling Price</label>
                                            <input type="number" class="form-control" name="update_selling_price" min="1" max="999999"
                                            value="<?php echo $rows['selling_price']; ?>"   placeholder="Enter Accessory Selling Price (Max 6 digits)" required oninput="convertPriceToWords(this.value, 'accessorySPWords')">
                                                <div id="accessorySPWords"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="accessory_img">accessory Image</label>
                                        <div class="custom-file">
                                          <input type="file" name="update_accessory_img" class="custom-file-input" id="customFile" accept="image/*"  onchange="previewImage(event, 'imagePreview')">
                                          <label class="custom-file-label" for="customFile">Choose New Image</label>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary btn-block" name="update_Accessory">
                                            Update Accessory
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="validationCustom08" class="form-label">Previous Accessory Image</label>
                                        <div class="preview-image">
                                            <?php
                                                $imagePath = "Product_img/" . $rows['image'];
                                                $defaultImagePath = "./assets/images/accessories.png"; // Path to your default image

                                                // Check if the file exists and is readable or if $rows['image'] is null
                                                if (($rows['image'] !== null) && file_exists($imagePath) && is_readable($imagePath)) {
                                                    echo "<img class='img img-thumbnail' width='180' height='140' src='{$imagePath}' alt='Accessory Image'>";
                                                } else {
                                                    echo "<img class='img img-thumbnail' width='180' height='140' src='{$defaultImagePath}' alt='Default Image'>";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="validationCustom08" class="form-label">New accessory Image</label>
                                        <div class="preview-image">
                                            <img id="imagePreview" src="#" alt="Selected Image" style="display: none;" class="img img-thumbnail" width="180" height="140">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <?php
                            } else {
                                echo "No accessory found with this ID.";
                            }
                            } else {
                                echo '<div class="text-center">';
                                echo "Accessory ID not provided.";
                                echo '<br/><a href="accessory-list" class="btn btn-sm btn-danger">Accessory List</a>';
                                echo '</div>';                            
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#accessory_name').on('input', function () {
            let title = $(this).val().trim().toLowerCase();
            let slug = title.replace(/\s+/g, '-'); 
            $('#slug').val(slug);
        });
    });

    function capitalizeInput(input) {
        input.value = input.value.toLowerCase().replace(/\b(\w)/g, function (s) {
            return s.toUpperCase();
        });
    }
    function capitalizeNameInput(input) {
        input.value = input.value.toUpperCase();
    }
   
</script>
