<?php
include "../config/connection.php";
header("Content-Type: application/json");

// Check if it's a GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $conn->query("SELECT * FROM tbl_city");
    $cities = [];

    while ($row = $result->fetch_assoc()) {
        $cities[] = $row;
    }

    echo json_encode(["status" => "success", "data" => $cities]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
