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
            <h1>Condition Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index">Home</a></li>
              <li class="breadcrumb-item active">Condition</li>
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
              <h3 class="card-title">Condition List</h3>
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
                    <th class="text-center">Condition Name</th>
                    <th class="text-center">Created On</th>
                    <th class="text-center">Updated On</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                      include_once "connection.php";
                      $sql = "SELECT * FROM `conditions` ORDER BY condition_id ASC";
                      $res = mysqli_query($conn, $sql);

                      if ($res && mysqli_num_rows($res) > 0) {
                          $counter = 0;
                          while ($row = mysqli_fetch_assoc($res)) {
                              ?>
                  <tr>
                    <td class="text-center align-middle"><?= ++$counter ?></td>
                    <td class="text-center align-middle">
                      <a href="condition?condition_id=<?= $row['condition_id']; ?>" class="btn btn-sm btn-primary myTooltip" data-toggle="tooltip" 
                          data-placement="bottom" 
                          title="Edit"><i class="bi bi-pencil-square"></i></a>
                      <button type="button" class="btn btn-sm btn-danger deleteCondition myTooltip"
                        data-placement="bottom" data-toggle="tooltip" 
                        title="Remove" data-Condition-id="<?= $row['condition_id']; ?>">
                        <i class="bi bi-trash-fill"></i>
                      </button>
                    </td>
                    <td class="text-center align-middle text-capitalize"><?= $row['condition_name'] ?></td>
                    <td class="text-center align-middle"><?= $row['created_at'] ?></td>
                    <td class="text-center align-middle"><?= $row['updated_at'] !== null ? $row['updated_at'] : 'NA' ?></td>
                  </tr>
                <?php
                  }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No conditions found</td></tr>";
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
              <h3 class="card-title">Add Condition</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <p class="text-wrap lh-base">Please enter the product Condition. This will help in adding the product to
              different conditions such as <b>New, Old, Refurbished, OpenBox</b> or <i>Any other</i>.</p>
              <form action="insert_query" method="POST" enctype="multipart/form-data" autocomplete="off" novalidate>
                <div class="form-group">
                  <label htmlFor="inputName">Condition Name</label>
                  <input type="text" placeholder="Refurbished" name="condition_name" class="form-control text-capitalize" required/>
                </div>
                <div class="row">
                  <div class="col-12">
                    <button type="submit" name="save_Condition" class="btn btn-primary btn-block">
                      Save Condition
                    </button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card  -->
          <!-- =============Edit Condition============ -->
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Edit Condition</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <?php
                include_once 'connection.php';
                if (isset($_GET['condition_id'])) {
                  $condition_id = $_GET['condition_id'];
                    $sql = "SELECT * FROM `conditions` WHERE condition_id='$condition_id'";
                      $query_run = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($query_run) > 0) {
                      $rows = mysqli_fetch_assoc($query_run);
              ?>
              <form action="update_query" method="POST" enctype="multipart/form-data" autocomplete="off">
              <input type="hidden" name="condition_id" class="form-control my-1" value="<?php echo $rows['condition_id']; ?>">
                <div class="form-group">
                  <label htmlFor="inputName">Condition Title</label>
                  <input type="text" name="update_condition_name" value="<?php echo $rows['condition_name']; ?>" placeholder="Refurbished" class="form-control" />
                </div>
                <div class="row">
                  <div class="col-12 mt-2">
                    <button type="submit" name="update_Condition" class="btn btn-primary btn-block">
                      Update Condition
                    </button>
                  </div>
                </div>
              </form>
              <?php
              } else {
                echo "No Condition found with this ID.";
                }
              } else {
                echo '<div class="text-center">';
                echo "Condition ID not provided.";
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
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.deleteCondition');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const ConditionId = this.getAttribute('data-Condition-id');
                const confirmation = confirm('Are you sure you want to delete this Condition?');

                if (confirmation) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'delete_query';

                    const inputConditionId = document.createElement('input');
                    inputConditionId.type = 'hidden';
                    inputConditionId.name = 'condition_id';
                    inputConditionId.value = ConditionId;

                    form.appendChild(inputConditionId);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>


