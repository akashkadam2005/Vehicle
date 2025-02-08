<?php
session_start();
include "../config/connection.php";

// Get employee_id from the URL
$employee_id = $_GET["employee_id"];

// Delete employee query
$deleteQuery = "DELETE FROM `tbl_employee` WHERE `employee_id` = '$employee_id'";

if (mysqli_query($conn, $deleteQuery)) {
    $_SESSION["success"] = "Employee deleted successfully!";
} else {
    $_SESSION["error"] = "Error deleting employee: " . mysqli_error($conn);
}

// Redirect back to the employee list
echo "<script>window.location = 'index.php';</script>";
?>
