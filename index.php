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

// Count Employees
$employee_query = "SELECT COUNT(*) AS employee_count FROM tbl_employee";
$employee_result = mysqli_query($conn, $employee_query);
$employee_count = mysqli_fetch_assoc($employee_result)['employee_count'];

// Count Categories
$category_query = "SELECT COUNT(*) AS category_count FROM tbl_category";
$category_result = mysqli_query($conn, $category_query);
$category_count = mysqli_fetch_assoc($category_result)['category_count'];

// Count Customer Feedbacks (Reviews)
$reviews_query = "SELECT COUNT(*) AS reviews_count FROM tbl_ratings";
$reviews_result = mysqli_query($conn, $reviews_query);
$reviews_count = mysqli_fetch_assoc($reviews_result)['reviews_count'];

// Count Total Bookings
$bookings_query = "SELECT COUNT(*) AS total_bookings FROM tbl_bookings";
$bookings_result = mysqli_query($conn, $bookings_query);
$total_bookings = mysqli_fetch_assoc($bookings_result)['total_bookings'];

// Count Pending Bookings
$pending_bookings_query = "SELECT COUNT(*) AS pending_bookings FROM tbl_bookings WHERE booking_status = '1'";
$pending_bookings_result = mysqli_query($conn, $pending_bookings_query);
$pending_bookings = mysqli_fetch_assoc($pending_bookings_result)['pending_bookings'];

// Count Completed Bookings
$completed_bookings_query = "SELECT COUNT(*) AS completed_bookings FROM tbl_bookings WHERE booking_status = '3'";
$completed_bookings_result = mysqli_query($conn, $completed_bookings_query);
$completed_bookings = mysqli_fetch_assoc($completed_bookings_result)['completed_bookings'];

// Count Cancelled Bookings
$cancelled_bookings_query = "SELECT COUNT(*) AS cancelled_bookings FROM tbl_bookings WHERE booking_status = '4'";
$cancelled_bookings_result = mysqli_query($conn, $cancelled_bookings_query);
$cancelled_bookings = mysqli_fetch_assoc($cancelled_bookings_result)['cancelled_bookings'];

// Count Available Employees (Employees not assigned any task)
$available_employee_query = "SELECT COUNT(*) AS available_employees FROM tbl_employee WHERE employee_status = '1'";
$available_employee_result = mysqli_query($conn, $available_employee_query);
$available_employees = mysqli_fetch_assoc($available_employee_result)['available_employees'];

// Count On-Duty Employees (Employees currently working)
$on_duty_employee_query = "SELECT COUNT(*) AS on_duty_employees FROM tbl_employee WHERE employee_status = '2'";
$on_duty_employee_result = mysqli_query($conn, $on_duty_employee_query);
$on_duty_employees = mysqli_fetch_assoc($on_duty_employee_result)['on_duty_employees'];
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">
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

        <!-- Customer Feedbacks -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "review/" ?>" class="info-box-icon bg-info elevation-1">
              <i class="fas fa-comments"></i>
            </a>
            <div class="info-box-content">
              <span class="info-box-text">Customer Feedbacks</span>
              <span class="info-box-number"><?= $reviews_count ?></span>
            </div>
          </div>
        </div>

        <!-- Total Bookings -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "bookings/" ?>" class="info-box-icon bg-info elevation-1">
              <i class="fas fa-calendar-alt"></i>
            </a>
            <div class="info-box-content">
              <span class="info-box-text">Total Bookings</span>
              <span class="info-box-number"><?= $total_bookings ?></span>
            </div>
          </div>
        </div>

        <!-- Pending Bookings -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "bookings/index.php?booking_status=1" ?>" class="info-box-icon bg-warning elevation-1">
              <i class="fas fa-clock"></i>
            </a>
            <div class="info-box-content">
              <span class="info-box-text">Pending Bookings</span>
              <span class="info-box-number"><?= $pending_bookings ?></span>
            </div>
          </div>
        </div>

        <!-- Completed Bookings -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "bookings/index.php?booking_status=3" ?>" class="info-box-icon bg-success elevation-1">
              <i class="fas fa-check-circle"></i>
            </a>
            <div class="info-box-content">
              <span class="info-box-text">Completed Bookings</span>
              <span class="info-box-number"><?= $completed_bookings ?></span>
            </div>
          </div>
        </div>

        <!-- Cancelled Bookings -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <a href="<?= $base_url . "bookings/" ?>" class="info-box-icon bg-danger elevation-1">
              <i class="fas fa-times-circle"></i>
            </a>
            <div class="info-box-content">
              <span class="info-box-text">Cancelled Bookings</span>
              <span class="info-box-number"><?= $cancelled_bookings ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include "component/footer.php"; ?>
