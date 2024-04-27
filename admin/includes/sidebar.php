<style>
    .sidebar::-webkit-scrollbar {
        width: 0;
    }
    .sidebar {
        height: 700px;
        overflow-y: auto;
        color: #000;
        scrollbar-width: none;
    }
</style>
<aside class="main-sidebar sidebar-dark-danger position-fixed">
    <!-- Brand Logo -->
    <a href="./index" class="brand-link">
      <img src="./assets/images/logo.png" alt="SecondsChoice Logo" class="brand-image img-circle" style="opacity: .8">
      <span class="brand-text h4 font-weight-bolder text-light"> Seconds <span class="text-success">Choice</span></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php
            if ($fetch['profile'] == '') {
              echo '<img class="img-profile rounded-circle" src="./assets/images/logo.png">';
            } else {
              echo '<img class="img-profile rounded-circle border-light" src="Profile_img/' . $fetch['profile'] . '">';
            }
          ?>
        </div>
        <div class="info">
          <a href="profile" class="d-block text-capitalize">
            <?php echo $fetch['name']; ?>
          </a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="index" class="nav-link">
              <i class="nav-icon bi bi-house-heart mr-2"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-header">INVOICING</li>
          <li class="nav-item">
            <a href="exchange-item" class="nav-link">
              <i class="bi bi-repeat mr-2"></i>
              <p>
              Exchange Item
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="create-invoice" class="nav-link">
              <i class="bi bi-receipt-cutoff mr-2"></i>
              <p>
              Create Invoice
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="invoice-history" class="nav-link">
              <i class="bi bi-clock-history mr-2"></i>
              <p>
              Invoice History
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="exchange-history" class="nav-link">
              <i class="bi bi-hourglass-split mr-2"></i>
              <p>
              Exchange History
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="customer" class="nav-link">
              <i class="bi bi-people mr-2"></i>
              <p>
              Customer
              </p>
            </a>
          </li>
          <li class="nav-header">MANAGE PRODUCT</li>
          <li class="nav-item">
            <a href="add-products" class="nav-link">
              <i class="nav-icon bi bi-bag-plus mr-2"></i>
              <p>
              Add Products
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="add-accessories" class="nav-link">
              <i class="nav-icon bi bi-headset mr-2"></i>
              <p>
              Add Accessories
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="product-list" class="nav-link">
              <i class="nav-icon bi bi-card-list mr-2"></i>
              <p>
                Product List
              </p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="accessory-list" class="nav-link">
              <i class="nav-icon bi bi-card-list mr-2"></i>
              <p>
                Accessory List
              </p>
            </a>
          </li> -->
          <li class="nav-header">ADDITIONAL</li>

          <li class="nav-item">
            <a href="category" class="nav-link">
              <i class="nav-icon bi bi-layers mr-2"></i>
              <p>
              Category
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="brand" class="nav-link">
              <i class="nav-icon bi bi-tag mr-2"></i>
              <p>
              Brand
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="condition" class="nav-link">
              <i class="bi bi-clipboard2-pulse mr-2"></i>
              <p>
              Condition
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout" class="nav-link">
              <i class="nav-icon bi bi-power mr-2"></i>
              <p>
              Logout
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>