<?php
$title = "Admin Dashboard";
include "config/connection.php";
include("component/header.php");
include "component/sidebar.php";

// Fetch the counts from the database
// Count Customers
$customer_query = "SELECT COUNT(*) AS customer_count FROM tbl_customer";
$customer_result = mysqli_query($conn, $customer_query);
$customer_count = mysqli_fetch_assoc($customer_result)['customer_count'];

// Count Services
$product_query = "SELECT COUNT(*) AS product_count FROM tbl_services";
$product_result = mysqli_query($conn, $product_query);
$product_count = mysqli_fetch_assoc($product_result)['product_count'];

// Count Services
$employee_query = "SELECT COUNT(*) AS employee_count FROM tbl_employee";
$employee_result = mysqli_query($conn, $employee_query);
$employee_count = mysqli_fetch_assoc($employee_result)['employee_count'];



// Count Categories
$category_query = "SELECT COUNT(*) AS category_count FROM tbl_category";
$category_result = mysqli_query($conn, $category_query);
$category_count = mysqli_fetch_assoc($category_result)['category_count'];

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


  <!-- Main content -->
  <section class="content pt-3">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row d-flex justify-content-between">
        <!-- Customers -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "customer/" ?>" class="info-box-icon bg-info elevation-1">
              <i class="fas fa-users"></i>
            </a>
            <div class="info-box-content">
              <span class="info-box-text">Total Customers</span>
              <span class="info-box-number"><?= $customer_count ?></span>
            </div>
          </div>
        </div>



        <!-- Services -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "services/" ?>" class="info-box-icon bg-warning elevation-1">
              <i class="fas fa-concierge-bell"></i>
            </a>
            <div class="info-box-content">
              <span class="info-box-text">Available Services</span>
              <span class="info-box-number"><?= $product_count ?></span>
            </div>
          </div>
        </div>

        <!-- Categories -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "category/" ?>" class="info-box-icon bg-success elevation-1">
              <i class="fas fa-th-list"></i>
            </a>
            <div class="info-box-content">
              <span class="info-box-text">Available Categories</span>
              <span class="info-box-number"><?= $category_count ?></span>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "Reviews/" ?>" class="info-box-icon bg-info elevation-1">
              <i class="fas fa-comments"></i> <!-- Updated to represent customer feedback -->
            </a>
            <div class="info-box-content">
              <span class="info-box-text">Customer Feedbacks</span>
              <span class="info-box-number">10</span>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "Bookings/" ?>" class="info-box-icon bg-info elevation-1">
              <i class="fas fa-calendar-alt"></i> <!-- Updated -->
            </a>
            <div class="info-box-content">
              <span class="info-box-text">Total Bookings</span>
              <span class="info-box-number">10</span>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "Bookings/" ?>" class="info-box-icon bg-warning elevation-1">
              <i class="fas fa-clock"></i> <!-- Pending Bookings -->
            </a>
            <div class="info-box-content">
              <span class="info-box-text">Pending Bookings</span>
              <span class="info-box-number">10</span>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "Bookings/" ?>" class="info-box-icon bg-success elevation-1">
              <i class="fas fa-check-circle"></i> <!-- Completed Bookings -->
            </a>
            <div class="info-box-content">
              <span class="info-box-text">Completed Bookings</span>
              <span class="info-box-number">10</span>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "Bookings/" ?>" class="info-box-icon bg-danger elevation-1">
              <i class="fas fa-times-circle"></i> <!-- Cancelled Bookings -->
            </a>
            <div class="info-box-content">
              <span class="info-box-text">Cancelled Bookings</span>
              <span class="info-box-number">10</span>
            </div>
          </div>
        </div>
        <!-- Employees -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "employee/" ?>" class="info-box-icon bg-info elevation-1">
              <i class="fas fa-user-tie"></i>
            </a>
            <div class="info-box-content">
              <span class="info-box-text">Total Employees</span>
              <span class="info-box-number"><?= $employee_count ?></span>
            </div>
          </div>
        </div>
        <!-- Employees -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "employee/" ?>" class="info-box-icon bg-warning elevation-1">
              <i class="fas fa-user-cog"></i> <!-- Updated icon for Working Employees -->
            </a>
            <div class="info-box-content">
              <span class="info-box-text">On-Duty Employees</span> <!-- Updated title -->
              <span class="info-box-number"><?= $employee_count ?></span>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "employee/" ?>" class="info-box-icon bg-success elevation-1">
              <i class="fas fa-user-clock"></i> <!-- Updated icon for Free Employees -->
            </a>
            <div class="info-box-content">
              <span class="info-box-text">Available Employees</span> <!-- Updated title -->
              <span class="info-box-number"><?= $employee_count ?></span>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "review/" ?>" class="info-box-icon bg-info elevation-1">
              <i class="fas fa-star"></i> <!-- Total Reviews -->
            </a>
            <div class="info-box-content">
              <span class="info-box-text">Total Reviews</span>
              <span class="info-box-number">10</span>
            </div>
          </div>
        </div>


      </div>


      <!-- /.row -->

    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include "component/footer.php";
?>