<?php
include "../config/connection.php";
header("Content-Type: application/json");

// Check if it's a DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);

    $service_id = $data['service_id'] ?? null;

    if (!$service_id) {
        echo json_encode(["status" => "error", "message" => "Service ID is required"]);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM tbl_services WHERE service_id = ?");
    $stmt->bind_param("i", $service_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Service deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete product"]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
