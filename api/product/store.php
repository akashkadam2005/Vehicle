<?php
include "../config/connection.php";
header("Content-Type: application/json");

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $service_name = $data['service_name'] ?? null;
    $service_description = $data['service_description'] ?? null;
    $service_image = $data['service_image'] ?? null;
    $service_price = $data['service_price'] ?? null;
    $service_dis = $data['service_dis'] ?? null;
    $service_dis_value = $data['service_dis_value'] ?? null;
    $category_id = $data['category_id'] ?? null;

    if (!$service_name || !$service_price || !$category_id) {
        echo json_encode(["status" => "error", "message" => "Product name, price, and category are required"]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO tbl_product (service_name, service_description, service_image, service_price, service_dis, service_dis_value, category_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdssi", $service_name, $service_description, $service_image, $service_price, $service_dis, $service_dis_value, $category_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Product created successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to create product"]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
