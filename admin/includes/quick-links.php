<!-- PRODUCTS -->
<div class="col-12 col-sm-6 col-md-4 btn" id="productsBox">
  <div class="info-box card-primary card-outline">
    <span class="info-box-icon bg-info elevation-1"><i class="bi bi-phone"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Total Products</span>
      <span class="info-box-number text-right">
        <?php
                            if ($products) {
                                $row = mysqli_num_rows($products);
                                if ($row > 0) {
                                    echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>" . $row . "</div>";
                                } else {
                                  echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>0</div>";
                                }
                                mysqli_free_result($products);
                            }
                          ?>
      </span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- PRODUCTS -->

<!-- INVOICE -->
<div class="col-12 col-sm-6 col-md-4 btn" id="invoicesBox">
  <div class="info-box mb-3 card-primary card-outline">
    <span class="info-box-icon bg-info elevation-1"><i class="bi bi-receipt-cutoff"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Total Invoices</span>
      <span class="info-box-number  text-right">
        <?php
                            if ($invoice) {
                                $in = mysqli_num_rows($invoice);
                                if ($in > 0) {
                                    echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>" . $in . "</div>";
                                } else {
                                    echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>0</div>";
                                }
                                mysqli_free_result($invoice);
                            }
                          ?>
      </span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- INVOICE -->

<!-- BRANDS -->
<div class="col-12 col-sm-6 col-md-4 btn" id="brandsBox">
  <div class="info-box mb-3 card-primary card-outline">
    <span class="info-box-icon bg-info elevation-1"><i class="bi bi-tag"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Total Brands</span>
      <span class="info-box-number  text-right">
        <?php
                            if ($brand) {
                                $br = mysqli_num_rows($brand);
                                if ($br > 0) {
                                    echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>" . $br . "</div>";
                                } else {
                                  echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>0</div>";
                                }
                                mysqli_free_result($brand);
                            }
                          ?>
      </span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- BRANDS -->

<!-- fix for small devices only -->
<div class="clearfix hidden-md-up"></div>

<!-- CATEGORY -->
<div class="col-12 col-sm-6 col-md-4 btn" id="categoriesBox">
  <div class="info-box mb-3 card-primary card-outline">
    <span class="info-box-icon bg-info elevation-1"><i class="bi bi-layers"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Total Categories</span>
      <span class="info-box-number text-right">
        <?php
                            if ($category) {
                              $cat = mysqli_num_rows($category);
                              if ($cat > 0) {
                                  echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>" . $cat . "</div>";
                              } else {
                                echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>0</div>";
                              }
                              mysqli_free_result($category);
                            }
                          ?>
      </span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- CATEGORY -->

<!-- CUSTOMER -->
<div class="col-12 col-sm-6 col-md-4 btn" id="customerBox">
  <div class="info-box mb-3 card-primary card-outline">
    <span class="info-box-icon bg-info elevation-1"><i class="bi bi-people"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Total Customers</span>
      <span class="info-box-number text-right">
        <?php
                            if ($customers) {
                              $cus = mysqli_num_rows($customers);
                              if ($cus > 0) {
                                  echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>" . $cus . "</div>";
                              } else {
                                echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>0</div>";
                              }
                              mysqli_free_result($customers);
                            }
                          ?>
      </span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- CUSTOMERS -->

<!-- CONDITION -->
<div class="col-12 col-sm-6 col-md-4 btn" id="conditionBox">
  <div class="info-box mb-3 card-primary card-outline">
    <span class="info-box-icon bg-info elevation-1"><i class="bi bi-clipboard2-pulse"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Total Conditions</span>
      <span class="info-box-number text-right">
        <?php
                            if ($conditions) {
                              $cond = mysqli_num_rows($conditions);
                              if ($cond > 0) {
                                  echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>" . $cond . "</div>";
                              } else {
                                echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>0</div>";
                              }
                              mysqli_free_result($conditions);
                            }
                          ?>
      </span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- CONDITION -->

<!-- fix for small devices only -->
<div class="clearfix hidden-md-up"></div>

<!-- ACCESSORY -->
<div class="col-12 col-sm-6 col-md-4 btn" id="accessoryBox">
  <div class="info-box mb-3 card-primary card-outline">
    <span class="info-box-icon bg-info elevation-1"><i class="bi bi-headset"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Total Accessories</span>
      <span class="info-box-number text-right">
        <?php
                            if ($accessory) {
                              $acc = mysqli_num_rows($accessory);
                              if ($acc > 0) {
                                  echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>" . $acc . "</div>";
                              } else {
                                echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>0</div>";
                              }
                              mysqli_free_result($accessory);
                            }
                          ?>
      </span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- ACCESSORY -->

<!-- EXCHANGE -->
<div class="col-12 col-sm-6 col-md-4 btn" id="exchangeBox">
  <div class="info-box mb-3 card-primary card-outline">
    <span class="info-box-icon bg-info elevation-1"><i class="bi bi-repeat"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Total Exchange</span>
      <span class="info-box-number text-right">
        <?php
                            if ($exchange) {
                              $exch = mysqli_num_rows($exchange);
                              if ($exch > 0) {
                                  echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>" . $exch . "</div>";
                              } else {
                                echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>0</div>";
                              }
                              mysqli_free_result($exchange);
                            }
                          ?>
      </span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- EXCHANGE -->

<!-- Users -->
<div class="col-12 col-sm-6 col-md-4 btn" id="usersBox">
  <div class="info-box mb-3 card-primary card-outline">
    <span class="info-box-icon bg-info elevation-1"><i class="bi bi-person-lock"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Total Users</span>
      <span class="info-box-number text-right">
        <?php
                            if ($Users) {
                              $user = mysqli_num_rows($Users);
                              if ($user > 0) {
                                  echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>" . $user . "</div>";
                              } else {
                                echo "<div class='h1 mb-0 font-weight-bold text-gray-800'>0</div>";
                              }
                              mysqli_free_result($Users);
                            }
                          ?>
      </span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- Users -->