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
                        <h1>Register Page</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index">Home</a></li>
                            <li class="breadcrumb-item active">Register</li>
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
                            <h3 class="card-title">Register</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                        <form action="insert_register" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" autocomplete="off" novalidate>
                            <div class="col-md-6 mt-2">
                                <label for="validationCustom01" class="form-label">Username</label>
                                <input type="text" class="form-control" minlength="6" maxlength="12" pattern="^(?=.{6,12}$)[a-z0-9]+(?:[._-][a-z0-9]+)*$" id="validationCustom01" placeholder="Enter Username" name="username" autocomplete="off" required>
                                <div class="invalid-feedback">
                                    Please provide a valid Username.
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="validationCustom02" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="validationCustom02" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Enter Email Address" name="email" autocomplete="off" required>
                                <div class="invalid-feedback">
                                    Please provide a valid Email Address.
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="validationCustom03" class="form-label">Full Name</label>
                                <input type="text" class="form-control text-capitalize" minlength="6" maxlength="20" id="validationCustom03" placeholder="Enter Full Name" name="name" autocomplete="off" required>
                                <div class="invalid-feedback">
                                    Please provide a valid Full Name.
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="validationCustom04" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" maxlenth="10" minlength="10" pattern="[789][0-9]{9}" id="validationCustom04" placeholder="Enter Mobile Number" name="mobile" autocomplete="off" required>
                                <div class="invalid-feedback">
                                    Please provide a valid Mobile Number.
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="validationCustom05">Profile Picture</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" accept="image/jpg, image/jpeg, image/png" name="profile" autocomplete="off" required>
                                    <label class="custom-file-label" for="validatedCustomFile">Choose Profile...</label>
                                    <div class="invalid-feedback"> Please Choose a valid Profile Picture.</div>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="validationPassword">Password</label>
                                <input type="password" id="validationPassword" minlength="8" minlength="20" class="form-control" placeholder="Enter Password" name="new_password" autocomplete="off" required>
                                <small id="passwordHelpBlock" class="form-text text-muted text-hidden">
                                    Your password must be 8-20 characters long, must contain special characters "!@#$%&*_?", numbers, lower and upper letters only.
                                </small>
                                <div class="valid-feedback">
                                    Strong Password!
                                </div>
                                <div class="invalid-feedback">
                                    Atleast 8 characters,
                                    Number, special character
                                    Capital Letter and Small letters
                                </div>
                                <!--<input type="checkbox" onclick="myFunction()">&nbsp; Show Password-->
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="validationCustom06">Confirm Password</label>
                                <input type="password" id="validationCustom06" minlength="8" minlength="20" class="form-control" placeholder="Enter Confirm Password" name="confirm_password" autocomplete="off" required>
                                <div class="invalid-feedback">
                                    Please Enter a valid Confirm Password.
                                </div>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-12 text-center mt-3 ">
                                <button class="btn btn-primary mx-2 my-3" name="button_Register" type="submit">Registration</button>
                                <a type="button" class="btn btn-secondary" href="index">Go To Home</a>
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

<script>
    function myFunction() {
        var x = document.getElementById("validationPassword");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>