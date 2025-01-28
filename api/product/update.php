<?php
include "../config/connection.php";
header("Content-Type: application/json");

// Check if it's a PUT request
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    $service_id = $data['service_id'] ?? null;
    $service_name = $data['service_name'] ?? null;
    $service_description = $data['service_description'] ?? null;
    $service_image = $data['service_image'] ?? null;
    $service_price = $data['service_price'] ?? null;
    $service_dis = $data['service_dis'] ?? null;
    $service_dis_value = $data['service_dis_value'] ?? null;
    $category_id = $data['category_id'] ?? null;

    if (!$service_id || !$service_name || !$service_price || !$category_id) {
        echo json_encode(["status" => "error", "message" => "Product ID, name, price, and category are required"]);
        exit;
    }

    $stmt = $conn->prepare("UPDATE tbl_services SET service_name = ?, service_description = ?, service_image = ?, service_price = ?, service_dis = ?, service_dis_value = ?, category_id = ? WHERE service_id = ?");
    $stmt->bind_param("sssdssii", $service_name, $service_description, $service_image, $service_price, $service_dis, $service_dis_value, $category_id, $service_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Product updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update product"]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
