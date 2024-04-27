<?php
session_start();

// Function to set the cookie
function setRememberMeCookie($id) {
    $cookie_name = "remember_me";
    $cookie_value = $id;
    $cookie_expire = time() + (60 * 60 * 24 * 30); // Set cookie expiration time (30 days)
    setcookie($cookie_name, $cookie_value, $cookie_expire, "/");
}

if (isset($_SESSION['id'])) {
    header("Location: index"); 
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Admin Login - SecondsChoice</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="./assets/images/logo.png" rel="icon">
  <link href="./assets/images/favicon.png" rel="apple-touch-icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
      <?php 
            if (isset($_SESSION['status'])) { ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Hey!</strong> <?= $_SESSION['status'] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php
                unset($_SESSION['status']);
            } 
      ?>
  
  <!-- /.login-logo -->
  
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <strong><span class="text-dark h1">Seconds <span class="text-danger">Choice</span></span></strong>
    </div>
    <div class="card-body">

        <!-- Username input field -->
        <form action="" method="post" class="needs-validation" novalidate enctype="multipart/form-data" autocomplete="off">
            <div class="form-group row">
                <label for="usernameInput">Search Username</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-outline-secondary"><span class="fas fa-search"></span></button>
                    </div>
                    <input type="text" name="username" placeholder="Enter your username" class="form-control" id="usernameInput" required autocomplete="off"/>
                    <div class="invalid-feedback">
                        Please provide a valid username.
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
            </div>
        </form>

        <form action="" method="post" class="needs-validation" novalidate enctype="multipart/form-data" autocomplete="off" style="display: none;">
            <!-- Displaying full name, hint question, hint answer, and reset password fields conditionally -->
            <div id="resetFieldsContainer" style="display: none;">
                <div class="form-group row">
                    <label for="fullNameInput">Full Name</label>
                    <div class="input-group">
                        <input type="text" name="name" value="" class="form-control text-capitalize" id="fullNameInput" disabled autocomplete="off"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="securityHint">Hint Question?</label>
                    <select name="securityHint" class="form-control" id="securityHint" required>
                        <option selected disabled value="">Select Hint Question</option>
                        <!-- Options for hint questions -->
                        <option value="first_car">What was the make and model of your first car?</option>
                        <!-- Add other hint question options -->
                    </select>
                    <div class="invalid-feedback">
                        Please select a valid hint question.
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>

                <div class="form-group row">
                    <label for="hintAnswer">Hint Answer?</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="checkbox" id="showPassword" aria-label="Checkbox for following text input">
                            </div>
                        </div>
                        <input type="text" name="hint_answer" placeholder="Hint Answer" class="form-control" id="hintAnswer" required autocomplete="off"/>
                        <div class="invalid-feedback">
                            Please provide a valid hint answer.
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                </div>

                <div class="form-group row" id="submitButtonContainer">
                    <button type="submit" name="submit_hint" class="btn btn-primary">Submit</button>
                </div>

            </div>
        </form>

        <form id="resetPasswordFields" action="" method="post" class="needs-validation" novalidate enctype="multipart/form-data" autocomplete="off" style="display: none;">

            <div class="form-group row" id="newPasswordField">
                <label for="newPassword">New Password</label>
                <input type="password" name="new_password" placeholder="New Password" class="form-control" required autocomplete="off">
                <div class="invalid-feedback">
                    Please provide a new password.
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="form-group row" id="confirmPasswordField">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control" required autocomplete="off">
                <div class="invalid-feedback">
                    Please provide a confirm password.
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="form-group row" id="submitButtonContainer">
                <button type="submit" name="reset_Password" class="btn btn-primary">Reset Password</button>
            </div>
        </form>

    </div>
    <!-- /.card-body -->
  </div>
  
  <div class="card text-center p-2">
    <div class="credits">
      &copy; Copyright <strong><span class="text-dark">Seconds <span class="text-danger">Choice</span></span></strong>. All Rights Reserved
    </div>
  </div>
  
</div>

<script>
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation');

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });
</script>

<!-- /.login-box -->
<script>
    const modeSwitch = document.getElementById('switch1');
    const body = document.body;

    // Function to set the selected mode in local storage
    const setMode = (mode) => {
        localStorage.setItem('mode', mode);
    };

    // Function to apply the stored mode
    const applyMode = () => {
        const selectedMode = localStorage.getItem('mode');
        if (selectedMode === 'dark-mode') {
            body.classList.add('dark-mode');
            modeSwitch.checked = true;
        }
    };

    // Apply mode on page load
    applyMode();

    // Toggle mode on checkbox change
    modeSwitch.addEventListener('change', () => {
        if (body.classList.contains('dark-mode')) {
            body.classList.remove('dark-mode');
            setMode('light-mode');
        } else {
            body.classList.add('dark-mode');
            setMode('dark-mode');
        }
    });
</script>
<!-- jQuery -->
<script src="./assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./assets/dist/js/adminlte.min.js"></script>

<script>
  $(document).ready(function () {
    $('#showPassword').change(function () {
        var passwordInput = $('#passwordInput');
        if ($(this).is(':checked')) {
            passwordInput.attr('type', 'text');
        } else {
            passwordInput.attr('type', 'password');
        }
    });

    $('#passwordInput').on('input', function () {
        if (!$('#showPassword').is(':checked')) {
            $(this).attr('type', 'password');
        }
    });
  });
</script>


</body>
</html>