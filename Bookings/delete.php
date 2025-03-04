<?php
session_start();
include "../config/connection.php";
$booking_id = $_GET["booking_id"];
$deleteQuery = "DELETE FROM `tbl_bookings` WHERE `booking_id` = '$booking_id'";
if(mysqli_query($conn,$deleteQuery)){
    $_SESSION["success"] = "Deleted Booking Details Successfully!";
    echo "<script>window.location = 'index.php';</script>";
}

?>