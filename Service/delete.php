<?php
session_start();
include "../config/connection.php";

// Get service_id from the URL
$service_id = $_GET["service_id"];

// Use a prepared statement to delete the product
$stmt = $conn->prepare("DELETE FROM `tbl_services` WHERE `service_id` = ?");
$stmt->bind_param("i", $service_id);

if ($stmt->execute()) {
    $_SESSION["success"] = "Product deleted successfully!";
    echo "<script>window.location = 'index.php';</script>";
} else {
    $_SESSION["error"] = "Error deleting product: " . $stmt->error;
    echo "<script>window.location = 'index.php';</script>";
}

$stmt->close();
$conn->close();
?>
