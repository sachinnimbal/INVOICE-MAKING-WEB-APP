<?php include './includes/header.php'; 
include 'connection.php';?>

<style>
  .upload {
    width: 165px;
    position: relative;
    margin: auto;
    text-align: center;
  }

  .upload img {
    border-radius: 50%;
    width: 155px;
    height: 155px;
  }

  .upload .rightRound {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 35px;
    height: 35px;
    line-height: 36px;
    border-radius: 50%;
    text-align: center;
    align-items: center;
    overflow: hidden;
    cursor: pointer;
  }

  .upload .leftRound {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 35px;
    height: 35px;
    line-height: 36px;
    text-align: center;
    align-items: center;
    border-radius: 50%;
    overflow: hidden;
    cursor: pointer;
  }

  .upload #icon {
    color: white;
    font-size: 20px;
  }

  .upload input {
    position: absolute;
    transform: scale(2);
    opacity: 0;
  }

  .upload input::-webkit-file-upload-button,
  .upload input[type=submit] {
    cursor: pointer;
  }
</style>

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
            <h1>Profile Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <?php include 'alert.php'; ?>

      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">

            <!-- Profile Image -->
            
            <div class="card card-primary card-outline">
              <div class="card-header text-right">
                <a href="profile?id=<?= $fetch['id']; ?>" class="btn btn-sm btn-info">
                  <i class="bi bi-pencil-square"></i>
                </a>              
              </div>
              <div class="card-body box-profile">
                <form class="needs-validation" novalidate action="update_query" method="POST" enctype="multipart/form-data">
                  <?php
                    $select = mysqli_query($conn, "SELECT * FROM Users WHERE id='$user_id'");
                    if (mysqli_num_rows($select) > 0) {
                      $fetch = mysqli_fetch_assoc($select);
                      $username = $fetch['username'];
                    }
                  ?>
                    <input type="hidden" value="<?php echo $fetch['profile']; ?>" class="form-control" name="old">
                    <input type="hidden" name="id" class="form-control" value="<?php echo $fetch['id']; ?>">
                    <div class="upload">
                      <img class="img img-thumbnail border-success" id="image" src="Profile_img/<?php echo $fetch['profile'] ?>">
                      <div class="rightRound bg-primary" id="upload" data-toggle="tooltip" data-placement="auto" title="Choose Profile">
                        <input type="file" name="fileImg" id="fileImg" accept=".jpg, .png, .jpeg">
                        <i class="fa fa-camera" id="icon"></i>
                      </div>
                      <div class="leftRound p-1 bg-danger" id="cancel" style="display: none;" data-toggle="tooltip" data-placement="auto" title="Cancel">
                        <i class="fa fa-times" id="icon"></i>
                      </div>
                      <div class="rightRound" id="confirm" style="display: none;" data-toggle="tooltip" data-placement="auto" title="Upload">
                          <input type="submit" name="update_PP" value="SUBMIT">
                          <i class="fa fa-check p-2 bg-primary" id="icon"></i>
                      </div>
                    </div>
                  </form>

                <h3 class="profile-username text-center"><?= $fetch['username']; ?></h3>
                  <p class="text-muted text-center text-capitalize">
                    <?= $fetch['role'] ?>
                  </p>
                <ul class="list-group list-group-bordered">
                  <li class="list-group-item">
                    <b>Name : </b><span class="text-capitalize"><?= $fetch['name']; ?></span>
                  </li>
                  <li class="list-group-item">
                    <b>Email : </b><span><?= $fetch['email']; ?></span>
                  </li>
                  <li class="list-group-item">
                    <b>Phone : </b><span><?= $fetch['mobile']; ?></span>
                  </li>
                  <li class="list-group-item text-justify">
                    <b>Created On : </b><span><?= date('Y-m-d', strtotime($fetch['created_at'])) ?></span>
                  </li>
                  <li class="list-group-item text-justify">
                    <b>Updated On : </b><span><?= date('Y-m-d', strtotime($fetch['updated_at'])) ?></span>
                  </li>
                </ul>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <div class="col-md-8">
            <div class="card card-primary card-outline">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#edit-profile" data-toggle="tab">Edit Profile</a></li>
                  <li class="nav-item"><a class="nav-link" href="#change-password" data-toggle="tab">Change Password</a></li>
                  <li class="nav-item"><a class="nav-link" href="#shop-details" data-toggle="tab">Shop Details</a></li>
                  <!-- <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Additional Settings</a></li> -->
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="edit-profile">
                    <?php
                    include_once 'connection.php';
                      if (isset($_GET['id'])) {
                      $id = $_GET['id'];
                      $sql = "SELECT * FROM `Users` WHERE id='$id'";
                      $query_run = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($query_run) > 0) {
                      $row = mysqli_fetch_assoc($query_run);
                    ?>
                    <form id="selectedCustomerForm" action="update_query" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>            
                      <div class="form-row">
                        <div class="col-md-6">
                        <input type="hidden" name="id" placeholder="id" class="form-control text-capitalize" required value="<?= $row['id'] ?>">

                          <div class="form-group">
                          <label htmlFor="inputName">Username</label>
                            <input type="text" name="username" placeholder="username" class="form-control" readonly
                            value="<?= $row['username'] ?>"/>
                            <div class="invalid-feedback">
                                Please provide a username.
                            </div>
                            <div class="valid-feedback">
                              Looks good!
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label htmlFor="inputName">Full Name</label>
                              <input type="text" name="U_name" placeholder="Full Name" class="form-control text-capitalize" required 
                              value="<?= $row['name'] ?>"/>
                              <div class="valid-feedback">
                                  Looks good!
                              </div>
                              <div class="invalid-feedback">
                                  Please provide a valid name.
                              </div>    
                          </div>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label htmlFor="inputName">Email Address</label>

                            <input type="email" name="U_email" placeholder="Email Address" class="form-control" required
                            value="<?= $row['email'] ?>"/>
                            <div class="invalid-feedback">
                                Please provide a valid email.
                            </div>
                            <div class="valid-feedback">
                              Looks good!
                            </div> 
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                          <label htmlFor="inputName">Phone</label>
                            <input type="text" id="inputPhone" name="U_mobile" placeholder="Phone Number" class="form-control"
                              required value="<?= $row['mobile'] ?>"/>
                              <div class="invalid-feedback">
                                Please provide a valid phone number.
                            </div>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                          </div>
                        </div> 
                      </div>

                      <div class="form-row mt-2">
                        <div class="col-md-12">
                          <button type="submit" name="update_Profile" class="btn btn-primary">Update Profile</button>
                        </div>
                      </div>
                    </form>
                    <?php
                          }
                      } else {
                        echo '<div class="text-center">';
                        echo "Profile ID not provided.";
                        echo '<br/>Editing form will available only when you click on'; 
                        echo '<br/><i class="bi bi-pencil-square"></i> edit icon.';
                        echo '</div>'; 
                      }
                    ?>
                  </div>
                  <!-- /.tab-pane -->


                  <div class="tab-pane" id="change-password">
                    <form id="selectedCustomerForm" action="update_query" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation form-horizontal" novalidate>
                      <div class="form-group row">
                          <input type="hidden" name="id" class="form-control" value="<?php echo $fetch['id']; ?>">
                          <input type="hidden" name="old_Password" class="form-control" value="<?php echo $fetch['password'] ?>">
                          <label for="inputExperience" class="col-sm-4 col-form-label">Old Password</label>
                          <div class="col-sm-8">
                              <input type="password" name="update_pass" placeholder="Previous Password" class="form-control" required>
                              <div class="invalid-feedback">
                                  Please provide a valid old password.
                              </div>
                              <div class="valid-feedback">
                                  Looks good!
                              </div>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="inputExperience" class="col-sm-4 col-form-label">New Password</label>
                          <div class="col-sm-8">
                              <input type="password" name="new_password" placeholder="New Password" class="form-control" required>
                              <div class="invalid-feedback">
                                  Please provide a new password.
                              </div>
                              <div class="valid-feedback">
                                  Looks good!
                              </div>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="inputExperience" class="col-sm-4 col-form-label">New Password</label>
                          <div class="col-sm-8">
                              <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control" required>
                              <div class="invalid-feedback">
                                  Please provide a confirm password.
                              </div>
                              <div class="valid-feedback">
                                  Looks good!
                              </div>
                          </div>
                      </div>
                      <div class="form-group row">
                          <div class="offset-sm-4 col-sm-8">
                              <button type="submit" name="update_Password" class="btn btn-primary">Update Password</button>
                          </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="shop-details">
                    <?php
                      include_once "connection.php";
                      $sql = "SELECT * FROM `shop` ORDER BY shop_id ASC";
                      $res = mysqli_query($conn, $sql);

                      if ($res && mysqli_num_rows($res) > 0) {
                          $counter = 0;
                          while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                    <form id="selectedCustomerForm" action="update_query" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>            
                      <div class="form-row">
                        <div class="col-md-6">
                          <div class="form-group">
                          <input type="hidden" name="shop_id" placeholder="Shop Id" class="form-control text-capitalize" required value="<?= $row['shop_id'] ?>">
                            <label htmlFor="inputName">Shop Name</label>
                              <input type="text" name="shop_name" placeholder="Shop Name" class="form-control text-capitalize" required 
                              value="<?= $row['shop_name'] ?>"/>
                              <div class="valid-feedback">
                                  Looks good!
                              </div>
                              <div class="invalid-feedback">
                                  Please provide a valid shop name.
                              </div>    
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                          <label htmlFor="inputName">Shop Slogon</label>
                            <input type="text" name="shop_slogon" placeholder="Shop Slogon" class="form-control text-capitalize" required
                            value="<?= $row['shop_slogon'] ?>"/>
                            <div class="invalid-feedback">
                                Please provide a shop slogon.
                            </div>
                            <div class="valid-feedback">
                              Looks good!
                            </div>
                              
                          </div>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="col-md-6">
                          <div class="form-group">
                          <label htmlFor="inputName">Shop GSTIN</label>
                            <input type="shop_gstin" name="shop_gstin" placeholder="Shop GSTIN" class="form-control" required
                            value="<?= $row['shop_gstin'] ?>"/>
                            <div class="invalid-feedback">
                                Please provide a valid shop GSTIN.
                            </div>
                            <div class="valid-feedback">
                              Looks good!
                            </div>
                              
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                          <label htmlFor="inputName">Shop Email Address</label>

                            <input type="shop_email" name="shop_email" placeholder="Shop Email Address" class="form-control" required
                            value="<?= $row['shop_email'] ?>"/>
                            <div class="invalid-feedback">
                                Please provide a valid shop email.
                            </div>
                            <div class="valid-feedback">
                              Looks good!
                            </div>
                              
                          </div>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label htmlFor="inputName">Shop Phone 1</label>

                            <input type="text" id="inputPhone" name="shop_phone1" placeholder="Phone Number 1" class="form-control"
                              required value="<?= $row['shop_phone1'] ?>"/>
                              <div class="invalid-feedback">
                                Please provide a valid phone number.
                            </div>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                          <label htmlFor="inputName">Shop Phone 2</label>

                            <input type="text" id="inputPhone2" name="shop_phone2" placeholder="Phone Number 2" class="form-control"
                              required value="<?= $row['shop_phone2'] ?>"/>
                              <div class="invalid-feedback">
                                Please provide a valid phone number.
                            </div>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="col-md-8">
                          <div class="form-group">
                          <label htmlFor="inputName">Shop Address</label>
                            <textarea class="form-control text-capitalize" name="shop_address" placeholder="Billing Address"
                              required><?= $row['shop_address'] ?></textarea>
                              <div class="invalid-feedback">
                                Please provide a valid shop address.
                              </div>
                              <div class="valid-feedback">
                                  Looks good!
                              </div>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                          <label htmlFor="inputName">Shop Pincode</label>

                            <input type="shop_pincode" name="shop_pincode" placeholder="Shop PinCode" class="form-control" required
                            value="<?= $row['shop_pincode'] ?>"/>
                            <div class="invalid-feedback">
                                Please provide a valid shop pincode.
                            </div>
                            <div class="valid-feedback">
                              Looks good!
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-row">
                        <p class="text-capitalize text-muted text-bold">INVOICE NOTE</p>
                        <div class="col-md-12">
                          <div class="form-group">
                          <label htmlFor="inputName">Invoice Note 1</label>
                            <textarea class="form-control text-capitalize" name="note_1" placeholder="Invoice Note 1"
                              style="height:40px;" required><?= $row['note_1'] ?></textarea>
                              <div class="invalid-feedback">
                                Please provide a valid invoice note 1.
                              </div>
                              <div class="valid-feedback">
                                  Looks good!
                              </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                          <label htmlFor="inputName">Invoice Note 2</label>
                            <textarea class="form-control text-capitalize" name="note_2" placeholder="Invoice Note 2"
                              style="height:40px;" required><?= $row['note_2'] ?></textarea>
                              <div class="invalid-feedback">
                                Please provide a valid invoice note 2.
                              </div>
                              <div class="valid-feedback">
                                  Looks good!
                              </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                          <label htmlFor="inputName">Invoice Note 3</label>
                            <textarea class="form-control text-capitalize" name="note_3" placeholder="Invoice Note 3"
                              style="height:40px;" required><?= $row['note_3'] ?></textarea>
                              <div class="invalid-feedback">
                                Please provide a valid invoice note 3.
                              </div>
                              <div class="valid-feedback">
                                  Looks good!
                              </div>
                          </div>
                        </div>
                      </div>
                    
                      <div class="form-row">
                        <p class="text-capitalize text-muted text-bold">EXCHANGE INVOICE NOTE</p>
                        <div class="col-md-12">
                          <div class="form-group">
                          <label htmlFor="inputName">Exchange Invoice Note 1</label>
                            <textarea class="form-control text-capitalize" name="exchange_note1" placeholder="Exchange Invoice Note 1"
                              style="height:40px;" required><?= $row['exchange_note1'] ?></textarea>
                              <div class="invalid-feedback">
                                Please provide a valid exchange invoice note 1.
                              </div>
                              <div class="valid-feedback">
                                  Looks good!
                              </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                          <label htmlFor="inputName">Exchange Invoice Note 2</label>
                            <textarea class="form-control text-capitalize" name="exchange_note2" placeholder="Exchange Invoice Note 2"
                              style="height:40px;" required><?= $row['exchange_note2'] ?></textarea>
                              <div class="invalid-feedback">
                                Please provide a valid exchange invoice note 2.
                              </div>
                              <div class="valid-feedback">
                                  Looks good!
                              </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                          <label htmlFor="inputName">Exchange Invoice Note 3</label>
                            <textarea class="form-control text-capitalize" name="exchange_note3" placeholder="Exchange Invoice Note 3"
                              style="height:40px;" required><?= $row['exchange_note3'] ?></textarea>
                              <div class="invalid-feedback">
                                Please provide a valid exchange invoice note 3.
                              </div>
                              <div class="valid-feedback">
                                  Looks good!
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-row mt-2">
                        <div class="col-md-12">
                          <button type="submit" name="update_Shop" class="btn btn-primary">Update Shop Details</button>
                        </div>
                      </div>
                    </form>                    
                    <?php
                        }
                    } else {
                        echo "No data found";
                    }
                    ?>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">   
                    <p class="text-wrap lh-base">Please select a question you prefer and provide an answer. <b>This hint question and answer will assist you in resetting your password.</b></p>

                    <form id="selectedCustomerForm" action="update_query" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation form-horizontal" novalidate>
                      <div class="form-group row">
                        <input type="hidden" name="id" class="form-control" value="<?php echo $fetch['id']; ?>">
                        <label for="securityHint">Hint Question?</label>
                          <select name="securityHint" class="form-control" required>
                            <option selected disabled value="">Select Hint Question</option>
                            <option value="first_car">What was the make and model of your first car?</option>
                            <option value="elementary_school">In which city or town did you attend your first elementary school?</option>
                            <option value="street_at_10">What is the name of the street you lived on when you were 10 years old?</option>
                            <option value="first_international_trip">Which country did you visit for your first international trip?</option>
                            <option value="oldest_cousin">What is the first name of your oldest cousin?</option>
                            <option value="childhood_friend">What was the name of your childhood best friend?</option>
                            <option value="youngest_sibling_birth">What is the birth month and year of your youngest sibling?</option>
                            <option value="favorite_childhood_pet">What is the name of your favorite childhood pet?</option>
                            <option value="high_school_sports_team">Which sports team were you a member of during high school?</option>
                            <option value="mother_maiden_name">What is the middle name of your mother's father?</option>
                          </select>
                          <div class="invalid-feedback">
                            Please select a valid hint question.
                          </div>
                          <div class="valid-feedback">
                            Looks good!
                          </div>
                      </div>
                      <div class="form-group row">
                        <label for="securityHint">Hint Answer?</label>  
                        <div class="input-group">
                          <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" id="showPassword" aria-label="Checkbox for following text input">
                                </div>
                            </div>
                            <input type="text" name="hint_answer" placeholder="Hint Answer" class="form-control" id="passwordInput" required  autocomplete="off"/>
                            <div class="invalid-feedback">
                                Please provide a valid hint answer.
                            </div>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                      </div>
                      
                      <div class="form-group row">
                          <div class="offset-sm-4 col-sm-8">
                              <button type="submit" name="update_Security" class="btn btn-primary">Update Security</button>
                          </div>
                      </div>
                    </form>           
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include './includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<?php include './includes/footer_main.php'; ?>

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

<script>
  document.getElementById("fileImg").onchange = function() {
      document.getElementById("image").src = URL.createObjectURL(fileImg.files[0]); // Preview new image

      document.getElementById("cancel").style.display = "block";
      document.getElementById("confirm").style.display = "block";

      document.getElementById("upload").style.display = "none";
  }

  var userImage = document.getElementById('image').src;
  document.getElementById("cancel").onclick = function() {
      document.getElementById("image").src = userImage; //Back to Previous image

      document.getElementById("cancel").style.display = "none";
      document.getElementById("confirm").style.display = "none";

      document.getElementById("upload").style.display = "block";
  }
</script>