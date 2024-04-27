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
            <h1>Login Activity Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index">Home</a></li>
              <li class="breadcrumb-item active">Login Activity</li>
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
              <h3 class="card-title">Login Activity</h3>
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
                    <th class="text-center">Username</th>
                    <th class="text-center">Full Name</th>
                    <th class="text-center">Login Time</th>
                    <th class="text-center">Logout Time</th>
                    <th class="text-center">IP Address</th>
                    <th class="text-center">Browser</th>
                    <th class="text-center">Device</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                      include_once "connection.php";
                        $sql = "SELECT LA.*, U.* 
                            FROM login_activity AS LA 
                            INNER JOIN Users AS U ON LA.user_id = U.id
                            ORDER BY LA.login_time DESC";

                      $res = mysqli_query($conn, $sql);

                      if ($res && mysqli_num_rows($res) > 0) {
                          $counter = 0;
                          while ($row = mysqli_fetch_assoc($res)) {
                              ?>
                  <tr>
                    <td class="text-center align-middle">
                        <?= ++$counter ?>
                    </td>
                    <td class="text-center align-middle">
                        <?php
                            if ($row['profile'] == '') {
                                echo '<img class="img img-thumbnail" width="50" height="50" src="img/favicon.png" alt="No Image">';
                            } else {
                                echo '<img class="img rounded-circle border-light" width="50" height="50" src="Profile_img/' . $row['profile'] . '" alt="' . $row['profile'] . '">';
                            }
                        ?>
                        <p class="text-black m-0 p-0">
                            <?= $row['username'] ?>
                        </p>
                    </td>
                    <td class="text-center align-middle">
                        <?= $row['name'] ?>
                    </td>
                    <td class="text-center align-middle text-bold">
                        <?= $row['login_time'] ?>
                    </td>
                    <td class="text-center align-middle text-bold">
                        <?= ($row['logout_time'] === null) ? "Online" : $row['logout_time'] ?>
                    </td>
                    <td class="text-center align-middle">
                        <?= $row['ip_address'] ?>
                    </td>
                    <td class="text-center align-middle text-capitalize">
                        <?= $row['browser_name'] ?>
                    </td>
                    <td class="text-center align-middle text-capitalize">
                        <?= $row['laptop_name'] ?>
                    </td>
                  </tr>
                <?php
                  }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No users found</td></tr>";
                    }
                    ?>
                </tbody>

              </table>
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

