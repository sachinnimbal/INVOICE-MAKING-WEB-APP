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
                        <h1>Add Product Page</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index">Home</a></li>
                            <li class="breadcrumb-item active">Add Product</li>
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
                            <h3 class="card-title">Add Product</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="insert_query" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="category">Category Title</label>
                                            <select class="form-control text-capitalize" id="category" name="category" required>
                                                <option disabled value="">Choose Category...</option>
                                                <?php
                                                include_once 'connection.php';

                                                // List of allowed categories to display first
                                                $allowedCategories = array(
                                                    "Mobile Phones", "Laptops", "Tablets", "Smart Watch",
                                                    "Smart Watches", "Mobile Phone", "Laptop", "Tablet", "Tablets",
                                                    "Cell Phones", "Notebooks", "Phablets", "Ultrabooks",
                                                    "iPad", "Smartphone", "Notebook PC", "E-Reader",
                                                    "Smart Wristband", "Smart Wearable", "Smart Band"
                                                );

                                                // Fetch categories from the 'category' table
                                                $sql = "SELECT category_title FROM `category`";
                                                $result = $conn->query($sql);

                                                if ($result && $result->num_rows > 0) {
                                                    // Create arrays to store allowed and disabled categories
                                                    $allowedOptions = [];
                                                    $disabledOptions = [];

                                                    while ($row = $result->fetch_assoc()) {
                                                        $categoryTitle = $row["category_title"];

                                                        if (in_array($categoryTitle, $allowedCategories)) {
                                                            $allowedOptions[] = "<option value='" . $categoryTitle . "'>" . $categoryTitle . "</option>";
                                                        } else {
                                                            $disabledOptions[] = "<option value='" . $categoryTitle . "' disabled>" . $categoryTitle . "</option>";
                                                        }
                                                    }

                                                    // Output allowed categories first and then disabled categories
                                                    echo implode("", $allowedOptions);
                                                    echo implode("", $disabledOptions);
                                                } else {
                                                    echo "<option>No categories found</option>";
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide a valid category title.
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="brand">Brand Title</label>
                                            <select class="form-control text-capitalize" id="brand" name="brand" required>
                                                <option selected disabled value="">Choose Brand...</option>
                                                <?php
                                              include_once 'connection.php';
                                              // Fetch brand titles from the 'brand' table
                                              $sql = "SELECT brand_title FROM `brand`";
                                              $result = $conn->query($sql);

                                              if ($result && $result->num_rows > 0) {
                                                  // Output data of each row
                                                  while ($row = $result->fetch_assoc()) {
                                                      echo "<option value='" . $row["brand_title"] . "'>" . $row["brand_title"] . "</option>";
                                                  }
                                              } else {
                                                  echo "<option>No brands found</option>";
                                              }
                                              ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide a valid brand title.
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="condition">Product Condition</label>
                                            <select class="form-control text-capitalize" id="condition" name="condition_name" required>
                                                <option selected disabled value="">Choose Condition...</option>
                                                <?php
                                                    include_once 'connection.php';
                                                    // Fetch condition titles from the 'conditions' table
                                                    $sql = "SELECT condition_name FROM `conditions`";
                                                    $result = $conn->query($sql);

                                                    if ($result && $result->num_rows > 0) {
                                                        // Output data of each row
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<option value='" . $row["condition_name"] . "'>" . $row["condition_name"] . "</option>";
                                                        }
                                                    } else {
                                                        echo "<option>No condition_name found</option>";
                                                    }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide a valid product condition.
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="product_name">Product Name</label>
                                            <input type="text" class="form-control" id="product_name"
                                                name="product_name" placeholder="Product Name" max="30"
                                                oninput="capitalizeNameInput(this)" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid product name.
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="qty">Quantity</label>
                                            <input type="number" class="form-control" name="qty" id="qty" placeholder="Quantity" min="1" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid quantity.
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="imei_numbers">IMEI Numbers <span class="text-muted">(Separated by commas)</span></label>
                                            <div class="input-group">
                                                <textarea class="form-control" name="imei_numbers" id="imei_numbers" placeholder="Enter IMEI Numbers" oninput="validateIMEI()" required></textarea>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="scanBarcode()">
                                                        <i class="bi bi-qr-code-scan"></i>
                                                    </button>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide valid product IMEI numbers.
                                                </div>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="original_price">Original Price</label>
                                            <input type="number" class="form-control" name="original_price" min="1" max="999999"
                                                placeholder="Enter Product Original Price (Max 6 digits)" required oninput="convertPriceToWords(this.value, 'productMRPWords')">
                                            <div id="productMRPWords"></div>
                                            <div class="invalid-feedback">
                                                Please provide a valid product original price.
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="selling_price">Selling Price</label>
                                            <input type="number" class="form-control" name="selling_price" min="1" max="999999"
                                                placeholder="Enter Product Selling Price (Max 6 digits)" required oninput="convertPriceToWords(this.value, 'productSPWords')">
                                            <div id="productSPWords"></div>
                                            <div class="invalid-feedback">
                                                Please provide a valid product selling price.
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="product_img">Product Image <span class="text-muted">(Optional)</span></label>
                                            <div class="custom-file">
                                                <input type="file" name="product_img" class="custom-file-input"
                                                    id="customFile" accept="image/*"
                                                    onchange="previewImage(event, 'imagePreview')">
                                                <label class="custom-file-label" for="customFile">Choose Image</label>
                                                <div class="invalid-feedback">
                                                    Please provide a valid product image.
                                                </div>
                                                <div class="valid-feedback">
                                                    Optional!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary btn-block" name="save_Product">
                                            Save Product
                                        </button>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <div class="preview-image m-2">
                                            <img id="imagePreview" src="#" alt="Selected Image" style="display: none;"
                                                class="img img-thumbnail w-50">
                                        </div>
                                    </div>
                                </div>
                            </form>
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
    function capitalizeInput(input) {
        input.value = input.value.toLowerCase().replace(/\b(\w)/g, function (s) {
            return s.toUpperCase();
        });
    }
    function capitalizeNameInput(input) {
        input.value = input.value.toUpperCase();
    }
</script>

<script>
    function validateIMEI() {
        const textarea = document.getElementById('imei_numbers');
        const imeiNumbers = textarea.value.split(',').map(num => num.trim());

        const invalidIMEIFeedback = document.querySelector('.invalid-feedback');
        const validIMEIFeedback = document.querySelector('.valid-feedback');

        let isValid = true;

        for (let i = 0; i < imeiNumbers.length; i++) {
            const imei = imeiNumbers[i];
            if (!(/^\d{15}$/).test(imei)) {
                isValid = false;
                break;
            }
        }

        if (isValid) {
            textarea.classList.remove('is-invalid');
            textarea.classList.add('is-valid');
            invalidIMEIFeedback.style.display = 'none';
            validIMEIFeedback.style.display = 'block';
        } else {
            textarea.classList.remove('is-valid');
            textarea.classList.add('is-invalid');
            validIMEIFeedback.style.display = 'none';
            invalidIMEIFeedback.style.display = 'block';
        }
    }
</script>