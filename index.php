<?php
session_start();


if (isset($_SESSION['id'])) {
    header("Location: ./admin/index"); 
    exit();
}

$conn = mysqli_connect('localhost', 'secondsc_SecondsChoice_db', 'Skn1631$$', 'secondsc_SecondsChoice_db') or die('connection failed');

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

    $select = mysqli_query($conn, "SELECT * FROM Users where username='$username' AND password='$pass'");
    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        $user_id = $row['id']; 

        // Set the timezone to Indian Standard Time (IST)
        date_default_timezone_set('Asia/Kolkata');

        // Get the current time in IST in MySQL datetime format
        $login_time = date('Y-m-d H:i:s');

        // Get user agent
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        // Extract browser name without using get_browser()
        $browser_name = get_browser_name($user_agent);

        // Example logic to determine laptop name (you may need to customize this based on your needs)
        $laptop_name = 'Unknown';

        if (strpos($user_agent, 'Windows NT 10.0') !== false) {
            $laptop_name = 'Windows 10';
        } elseif (strpos($user_agent, 'Macintosh') !== false) {
            $laptop_name = 'Mac';
        } elseif (strpos($user_agent, 'Linux') !== false) {
            $laptop_name = 'Linux';
        } elseif (strpos($user_agent, 'Android') !== false) {
            $laptop_name = 'Android';
        }

        // Get user IP address
        $ip_address = $_SERVER['REMOTE_ADDR'];

        // Check if this is the user's first login by querying login_activity
        $check_first_login = mysqli_query($conn, "SELECT * FROM login_activity WHERE user_id='$user_id'");
        if (mysqli_num_rows($check_first_login) == 0) {
            // If it's the first login, insert into login_activity
            $insert_login_activity = mysqli_query($conn, "INSERT INTO login_activity (user_id, login_time, ip_address, user_agent, browser_name, laptop_name) VALUES ('$user_id', '$login_time', '$ip_address', '$user_agent', '$browser_name', '$laptop_name')");
        } else {
            // If not the first login, update the login time and user agent in login_activity
            $update_login_activity = mysqli_query($conn, "UPDATE login_activity SET login_time='$login_time', ip_address='$ip_address', user_agent='$user_agent', browser_name='$browser_name', laptop_name='$laptop_name' WHERE user_id='$user_id'");
        }


        $username = $row['username'];
        $name = $row['name'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['status'] = "Welcome Back <b class='text-light text-capitalize'>$name</b>";
        header('refresh:1; ./admin/index');
    } else {
        $_SESSION['status'] = "Incorrect <b class='text-danger'>Username or Password!!</b>";
    }
}

// Function to extract browser name without using get_browser()
function get_browser_name($user_agent) {
    if (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Trident') !== false) {
        return 'Internet Explorer';
    } elseif (strpos($user_agent, 'Firefox') !== false) {
        return 'Firefox';
    } elseif (strpos($user_agent, 'Chrome') !== false) {
        return 'Chrome';
    } elseif (strpos($user_agent, 'Safari') !== false) {
        return 'Safari';
    } elseif (strpos($user_agent, 'Opera') !== false || strpos($user_agent, 'OPR') !== false) {
        return 'Opera';
    } else {
        return 'Unknown';
    }
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
  <link href="./admin/assets/images/logo.png" rel="icon">
  <link href="./admin/assets/images/favicon.png" rel="apple-touch-icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./admin/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./admin/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./admin/assets/dist/css/adminlte.min.css">
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
    <div class="card-header">
      <img src="./admin/assets/images/mainlogo.png" alt="" class="img img-fluid">
    </div>
    <div class="card-body">
      <p class="login-box-msg">Login to Your Account</p>
      <form action="" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="username" name="username" required>
          <div class="invalid-tooltip">
            Please provide a valid username.
          </div>
          <div class="valid-tooltip">
            Looks good!
          </div>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" required>
          <div class="invalid-tooltip">
            Please provide a valid password.
          </div>
          <div class="valid-tooltip">
            Looks good!
          </div>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- <p class="mb-1">
        <a href="forgot-password">I forgot my password</a>
      </p> -->
    </div>


    <!-- /.card-body -->
  </div>
  <div class="card text-center p-2">
    <div class="credits">
      Copyright &copy;<strong><span class="ml-1 mr-1" id="currentYear"></span><span class="text-dark">Seconds <span class="text-danger">Choice</span></span></strong>
      <span class="text-muted">All Rights Reserved</span>
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

    document.getElementById("currentYear").textContent = new Date().getFullYear();

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
<script src="./admin/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./admin/assets/dist/js/adminlte.min.js"></script>
</body>
</html>
