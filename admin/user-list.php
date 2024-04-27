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
            <h1>User List Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index">Home</a></li>
              <li class="breadcrumb-item active">User List</li>
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
              <h3 class="card-title">Users List</h3>
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
                    <th class="text-start">#</th>
                    <th class="text-start">Username</th>
                    <th class="text-start">Name</th>
                    <th class="text-start">Phone</th>
                    <th class="text-start">Email Address</th>
                    <th class="text-start">Role</th>
                    <th class="text-start">Status</th>
                    <th class="text-center">Created On</th>
                    <th class="text-center">Updated On</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                      include_once "connection.php";
                      $sql = "SELECT * FROM `Users` ORDER BY id ASC";
                      $res = mysqli_query($conn, $sql);

                      if ($res && mysqli_num_rows($res) > 0) {
                          $counter = 0;
                          while ($row = mysqli_fetch_assoc($res)) {
                              ?>
                  <tr>
                    <td class="text-center align-middle">
                      <?= ++$counter ?>
                    </td>
                    <td class="text-lowercase text-center align-middle">
                        <?php
                            if ($row['profile'] == '') {
                                echo '<img class="img img-thumbnail" width="80" height="50" src="img/favicon.png" alt="No Image">';
                            } else {
                                echo '<img class="img rounded-circle border-light" width="80" height="80" src="Profile_img/' . $row['profile'] . '" alt="' . $row['profile'] . '">';
                            }
                        ?>
                        <p class="text-black m-0 p-0">
                            <?= $row['username'] ?>
                        </p>
                    </td>
                    <td class="text-capitalize text-start align-middle">
                      <?= $row['name'] ?>
                    </td>
                    <td class="text-center align-middle">
                      <?= $row['mobile'] ?>
                    </td>
                    <td class="text-start align-middle text-lowercase">
                      <?= $row['email'] ?>
                    </td>
                    <td class="text-center align-middle text-capitalize">
                      <?= $row['role'] ?>
                    </td>
                    <td class="text-center align-middle text-capitalize">
                        <?php 
                            if ($row['status'] == 1) {
                                echo '<span class="btn badge badge-pill badge-success text-success myTooltip" 
                                    data-toggle="tooltip" 
                                    data-placement="bottom" 
                                    title="Active">a</span>';
                            } else {
                                echo '<span class="btn badge badge-pill badge-danger text-danger myTooltip" 
                                    data-toggle="tooltip" 
                                    data-placement="bottom" 
                                    title="Inactive">i</span>';
                            }
                        ?>
                    </td>
                    <td class="text-center align-middle"><?= $row['created_at'] ?></td>
                    <td class="text-center align-middle">
                        <?= $row['updated_at'] !== null ? $row['updated_at'] : 'NA' ?>
                    </td>
                  </tr>
                <?php
                  }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No users found</td></tr>";
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

