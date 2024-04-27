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
                        <h1>Add Exchange Product Page</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index">Home</a></li>
                            <li class="breadcrumb-item active">Add Exchange Product</li>
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
                            <h3 class="card-title">Add Exchange Product</h3>
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
                            <form id="selectedCustomerForm" action="query" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate onsubmit="return validateProductList()">            
                                <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <div class="input-group mb-3">
                                        <input type="text" name="customer_name" placeholder="Full Name" class="form-control text-capitalize" required />
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
                                        <input type="text" id="inputPhone" name="phone" placeholder="Phone Number" class="form-control"
                                            required maxlength="10" oninput="validatePhone()" />
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
                                <div class="col-md-4 mb-3">
                                    <div class="input-group mb-3">
                                    <input type="date" id="invoiceDate" name="date" class="form-control" />
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
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                    <textarea class="form-control text-capitalize" name="address" placeholder="Billing Address"
                                        style="height: 40px;" required></textarea>
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
                                <div class="row">
                                    <h5 class="title text-bold text-info mr-3">Enter Product Details</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="category">Category Title</label>
                                            <select class="form-control text-capitalize" id="category" name="exchange_category" required>
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="brand">Brand Title</label>
                                            <select class="form-control text-capitalize" id="brand" name="exchange_brand" required>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_name">Product Name</label>
                                            <input type="text" class="form-control" id="product_name"
                                                name="exchange_product_name" placeholder="Product Name" max="30"
                                                oninput="capitalizeNameInput(this)" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid product name.
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="condition">Product Condition</label>
                                            <select class="form-control text-capitalize" id="condition" name="exchange_condition_name" required>
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exchange_imei_number">IMEI Number</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="exchange_imei_number" id="imei_numbers" placeholder="Enter IMEI Number" 
                                                  maxlength="15" oninput="validateIMEI()" required/>
                                                <div class="invalid-feedback">
                                                    Please provide valid product IMEI number.
                                                </div>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>                
                                            </div>    
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="purchase_price">Purchase Price</label>
                                            <input type="text" class="form-control" name="exchange_purchase_price"
                                                maxlength="6" placeholder="Enter Purchase Price (Max 6 digits)" 
                                                required oninput="handlePriceInput(this.value)">
                                            <div class="invalid-feedback">
                                                Please provide a valid product purchase price.
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="purchase_price">Original Price</label>
                                            <input type="text" class="form-control" name="original_price"
                                                maxlength="6" placeholder="Enter Original Price (Max 6 digits)" 
                                                required>
                                            <div class="invalid-feedback">
                                                Please provide a valid product original price.
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <span class="bi bi-currency-rupee"></span>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" id="inputTotalPriceInWords" name="total_price_words" placeholder="Total Price Words" required />
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please provide a valid amount in words.
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="category">Customer ID Type</label>
                                            <select class="form-control text-capitalize" id="idType" onchange="toggleInput()" name="customer_IdType" required>
                                                <option selected disabled value="">Select ID Type...</option>
                                                <option value="aadhaar">Aadhaar Card</option>
                                                <option value="voter">Voter ID</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a valid id type.
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="aadharInput" style="display: none;">
                                        <div class="form-group">
                                            <label for="aadharNumber">Aadhaar Number</label>
                                            <input type="text" class="form-control" name="aadharNumber" id="aadharNumber" 
                                             maxlength="12" placeholder="Enter Aadhaar Number">
                                            <div class="invalid-feedback" id="aadharInvalidFeedback">
                                                Please provide a valid Aadhaar number.
                                            </div>
                                            <div class="valid-feedback" id="aadharValidFeedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4" id="voterInput" style="display: none;">
                                        <div class="form-group">
                                            <label for="voterNumber">Voter Number</label>
                                            <input type="text" class="form-control text-uppercase" name="voterNumber" id="voterNumber" placeholder="Enter Voter Number" 
                                                maxlength="10">
                                            <div class="invalid-feedback" id="voterInvalidFeedback">
                                                Please provide a valid Voter number.
                                            </div>
                                            <div class="valid-feedback" id="voterValidFeedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exchange_verification_id">Customer Verification ID Image</label>
                                            <div class="custom-file">
                                                <input type="file" name="exchange_verification_id" class="custom-file-input"
                                                    id="customFile" accept="image/*" required
                                                    onchange="previewImage(event, 'imagePreview')">
                                                <label class="custom-file-label" for="customFile">Choose Scanned Image</label>
                                                <div class="invalid-feedback">
                                                    Please provide a valid scanned image.
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
                                        <button type="submit" class="btn btn-primary btn-block" name="save_Exchange">
                                            Create Invoice
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
                            <div class="card-body  p-0">
                                <table id="example2" class="table table-bordered table-head-fixed text-nowrap table-responsive-lg">
                                <!-- Table header -->
                                <thead>
                                    <tr>
                                    <th class="text-start">Select</th>
                                    <th class="text-start">Name</th>
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
                                    <td class="text-center align-middle">
                                        <?= $row['phone'] ?>
                                    </td>
                                    <td class="text-start align-middle text-capitalize">
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
        const phone = row.querySelectorAll('td')[2].textContent.trim();
        const address = row.querySelectorAll('td')[3].textContent.trim();

        // Update respective fields with customer details
        document.querySelector('input[name="customer_name"]').value = customerName;
        document.querySelector('input[name="phone"]').value = phone;
        document.querySelector('textarea[name="address"]').value = address;

        // Close the modal after selecting a customer
        $('#customerModal').modal('hide');
      });
    });
  });
</script>

<script>
    function capitalizeInput(input) {
        input.value = input.value.toLowerCase().replace(/\b(\w)/g, function (s) {
            return s.toUpperCase();
        });
    }
    function capitalizeNameInput(input) {
        input.value = input.value.toUpperCase();
    }
    
    function scanBarcode() {
    // Assuming QuaggaJS is properly configured and initialized
    Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            target: document.querySelector('#imei_numbers') // Target the textarea
        },
        decoder: {
            readers: ["ean_reader"] // Adjust as per your barcode type
        }
    }, function(err) {
        if (err) {
            console.error("Error:", err);
            return;
        }
        console.log("Initialization finished. Starting Quagga...");
        Quagga.start();
        Quagga.onDetected(function(result) {
            const barcode = result.codeResult.code;
            // Append the scanned barcode to the textarea
            document.querySelector('#imei_numbers').value += barcode + ',';
        });
    });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Get today's date
    var today = new Date();

    // Format the date to set as the default value for the input field
    var yyyy = today.getFullYear();
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var dd = String(today.getDate()).padStart(2, '0');

    var formattedDate = yyyy + '-' + mm + '-' + dd;

    // Set the default value and min/max attributes for the input field
    document.getElementById('invoiceDate').value = formattedDate;
    document.getElementById('invoiceDate').setAttribute('min', formattedDate);
    document.getElementById('invoiceDate').setAttribute('max', formattedDate);
  });
</script>

<script>
    function validateIMEI() {
        const imeiField = document.getElementById('imei_numbers');
        const imeiValue = imeiField.value.trim();
        const imeiRegex = /^\d{15}$/;

        if (!imeiRegex.test(imeiValue)) {
            imeiField.classList.add('is-invalid');
            imeiField.classList.remove('is-valid');
        } else {
            imeiField.classList.add('is-valid');
            imeiField.classList.remove('is-invalid');
        }
    }
</script>

<script>
    // Function to validate Aadhaar number
    function validateAadhaar(aadhaarNumber) {
        const aadhaarRegex = /^[2-9]\d{11}$/;
        const onlyDigitsRegex = /^\d+$/;
        
        return aadhaarRegex.test(aadhaarNumber) && onlyDigitsRegex.test(aadhaarNumber);
    }

    // Function to validate Voter ID number
    function validateVoterId(voterId) {
        const voterIdRegex = /^[A-Za-z]{3}\d{7}$/;
        return voterIdRegex.test(voterId);
    }

    // Function to toggle input display and validation
    function toggleInput() {
        const idType = document.getElementById('idType').value;
        const aadharInput = document.getElementById('aadharInput');
        const voterInput = document.getElementById('voterInput');
        const aadharInputField = document.getElementById('aadharNumber');
        const voterInputField = document.getElementById('voterNumber');

        aadharInput.style.display = idType === 'aadhaar' ? 'block' : 'none';
        voterInput.style.display = idType === 'voter' ? 'block' : 'none';

        if (idType === 'aadhaar') {
            aadharInputField.addEventListener('input', function () {
                const aadharValue = aadharInputField.value.trim();
                const isValidAadhar = validateAadhaar(aadharValue);

                if (aadharValue === '' || (aadharValue !== '' && isValidAadhar)) {
                    aadharInputField.classList.remove('is-invalid');
                    aadharInputField.classList.add('is-valid');
                    document.getElementById('aadharInvalidFeedback').style.display = 'none';
                    document.getElementById('aadharValidFeedback').style.display = 'block';
                } else {
                    aadharInputField.classList.remove('is-valid');
                    aadharInputField.classList.add('is-invalid');
                    document.getElementById('aadharInvalidFeedback').style.display = 'block';
                    document.getElementById('aadharValidFeedback').style.display = 'none';
                }
            });
        } else if (idType === 'voter') {
            voterInputField.addEventListener('input', function () {
                const voterValue = voterInputField.value.trim();
                const isValidVoter = validateVoterId(voterValue);

                if (voterValue === '' || (voterValue !== '' && isValidVoter)) {
                    voterInputField.classList.remove('is-invalid');
                    voterInputField.classList.add('is-valid');
                    document.getElementById('voterInvalidFeedback').style.display = 'none';
                    document.getElementById('voterValidFeedback').style.display = 'block';
                } else {
                    voterInputField.classList.remove('is-valid');
                    voterInputField.classList.add('is-invalid');
                    document.getElementById('voterInvalidFeedback').style.display = 'block';
                    document.getElementById('voterValidFeedback').style.display = 'none';
                }
            });
        }
    }

</script>

<script>
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

    // Function to handle input and display the price in words
    function handlePriceInput(inputValue) {
    const purchasePrice = parseFloat(inputValue);
    if (!isNaN(purchasePrice)) {
        const priceWords = convertPriceToWords(purchasePrice);
        document.getElementById('inputTotalPriceInWords').value = priceWords;
    } else {
        document.getElementById('inputTotalPriceInWords').value = '';
    }
    }

</script>