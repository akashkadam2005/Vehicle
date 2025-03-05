<?php
session_start();
include "../config/connection.php";

// Get washing_id from the URL
$washing_id = $_GET["washing_id"];

// Delete employee query
$deleteQuery = "DELETE FROM `tbl_washing_point` WHERE `washing_id` = '$washing_id'";

if (mysqli_query($conn, $deleteQuery)) {
    $_SESSION["success"] = "Washing Point deleted successfully!";
} else {
    $_SESSION["error"] = "Error deleting washing point: " . mysqli_error($conn);
}

// Redirect back to the employee list
echo "<script>window.location = 'index.php';</script>";
?>
