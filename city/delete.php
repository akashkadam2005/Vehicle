<?php
session_start();
include "../config/connection.php";

if (isset($_GET['city_id'])) {
    $city_id = $_GET['city_id'];

    // Check if the city has associated washing points
    $checkQuery = "SELECT COUNT(*) as total FROM tbl_washing_point WHERE washing_city_id = '$city_id'";
    $result = mysqli_query($conn, $checkQuery);
    $data = mysqli_fetch_assoc($result);

    if ($data['total'] > 0) {
        $_SESSION["error"] = "Cannot delete city. It has associated washing points!";
        echo "<script>window.location = 'index.php';</script>";
    } else {
        // Safe to delete
        $deleteCity = "DELETE FROM tbl_city WHERE city_id = '$city_id'";
        if (mysqli_query($conn, $deleteCity)) {
            $_SESSION["success"] = "City deleted successfully!";
        } else {
            $_SESSION["error"] = "Error deleting city: " . mysqli_error($conn);
        }
        echo "<script>window.location = 'index.php';</script>";
    }
}

?>
