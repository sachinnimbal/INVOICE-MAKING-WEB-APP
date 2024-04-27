<?php include 'connection.php';?>
<?php
  session_start();
  $user_id = $_SESSION['id'];

  if (!isset($user_id)) {
    header('location:../index');
  }
?>
<?php
    $select = mysqli_query($conn, "SELECT * FROM Users WHERE id='$user_id'");
    if (mysqli_num_rows($select) > 0) {
        $fetch = mysqli_fetch_assoc($select);
        $name = $fetch['name'];

    } 
?>
<nav class="main-header navbar navbar-expand navbar-white sticky-top nav-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-black" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index" class="nav-link text-black"><i class="bi bi-house-heart-fill mr-2"></i>Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="create-invoice" class="nav-link text-black"><i class="bi bi-receipt mr-2"></i>Create Invoice</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="exchange-item" class="nav-link text-black"><i class="bi bi-repeat mr-2"></i>Exchange Item</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    
      <li class="nav-item mt-2">
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="switch1" name="example">
            <label class="custom-control-label" for="switch1" style="display: flex; align-items: center;">
                <span class="icon" id="modeIcon"></span>
            </label>
        </div>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i> 
        </a>
      </li> -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-black" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
        <?php echo $fetch['username']; ?>
        </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="login-activity">Login Activity</a>
            <a class="dropdown-item" href="register">Register</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout">Logout</a>
          </div>
      </li>
    </ul>
</nav>

<script>
    const modeSwitch = document.getElementById('switch1');
    const body = document.body;
    const modeIcon = document.getElementById('modeIcon');

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
            modeIcon.innerHTML = '<i class="fas fa-moon"></i>'; // Moon icon for dark mode
        } else {
            modeIcon.innerHTML = '<i class="fas fa-sun"></i>'; // Sun icon for light mode
        }
    };

    // Apply mode on page load
    applyMode();

    // Toggle mode on checkbox change
    modeSwitch.addEventListener('change', () => {
        if (body.classList.contains('dark-mode')) {
            body.classList.remove('dark-mode');
            setMode('light-mode');
            modeIcon.innerHTML = '<i class="fas fa-sun"></i>'; // Sun icon for light mode
        } else {
            body.classList.add('dark-mode');
            setMode('dark-mode');
            modeIcon.innerHTML = '<i class="fas fa-moon"></i>'; // Moon icon for dark mode
        }
    });
</script>