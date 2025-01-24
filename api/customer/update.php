<?php
header("Content-Type: application/json");
include "../config/connection.php";

// Initialize response
$response = ["status" => "error", "message" => "An unknown error occurred."];

// Check if customer ID is provided via GET
if (!isset($_GET['customer_id']) || empty($_GET['customer_id'])) {
    $response["message"] = "Customer ID is required.";
    echo json_encode($response);
    exit;
}

$customer_id = intval($_GET['customer_id']);

// Fetch customer details from the database
$query = "SELECT * FROM tbl_customer WHERE customer_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

if (!$customer) {
    $response["message"] = "Customer not found.";
    echo json_encode($response);
    exit;
}

// If form is submitted via POST method, process the update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize form inputs
    $customer_name = filter_var($_POST["customer_name"], FILTER_SANITIZE_STRING);
    $customer_email = filter_var($_POST["customer_email"], FILTER_SANITIZE_EMAIL);
    $customer_password = $_POST["customer_password"];
    $customer_phone = filter_var($_POST["customer_phone"], FILTER_SANITIZE_STRING);
    $customer_address = filter_var($_POST["customer_address"], FILTER_SANITIZE_STRING);
    $customer_status = 1;

    // Validate email format
    if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
        $response["message"] = "Invalid email format.";
        echo json_encode($response);
        exit;
    }

    // Hash password if a new one is provided, otherwise keep the existing one
    if (!empty($customer_password)) {
        $hashed_password = password_hash($customer_password, PASSWORD_BCRYPT);
    } else {
        $hashed_password = $customer['customer_password']; // Keep the existing password
    }

    // Handle image upload (if any)
    $image_path = $customer['customer_image'];
    if (isset($_FILES["customer_image"]) && $_FILES["customer_image"]["error"] == 0) {
        $target_dir = "../uploads/customers/";
        $customer_image = basename($_FILES["customer_image"]["name"]);
        $target_file = $target_dir . $customer_image;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png"];

        // Validate image type
        if (!in_array($imageFileType, $allowed_types)) {
            $response["message"] = "Invalid image format. Only JPG, JPEG, and PNG are allowed.";
            echo json_encode($response);
            exit;
        }

        // Validate image size (limit to 5MB)
        if ($_FILES["customer_image"]["size"] > 5000000) {
            $response["message"] = "Image file size exceeds the limit of 5MB.";
            echo json_encode($response);
            exit;
        }

        // Upload image
        if (move_uploaded_file($_FILES["customer_image"]["tmp_name"], $target_file)) {
            $image_path = $customer_image; // Update image path
        } else {
            $response["message"] = "Failed to upload image.";
            echo json_encode($response);
            exit;
        }
    }

    // Prepare and execute the update query
    $updateQuery = "UPDATE tbl_customer SET 
        customer_name = ?, 
        customer_email = ?, 
        customer_password = ?, 
        customer_phone = ?, 
        customer_address = ?, 
        customer_status = ?, 
        customer_image = ? 
        WHERE customer_id = ?";
    
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssssssi", $customer_name, $customer_email, $hashed_password, $customer_phone, $customer_address, $customer_status, $image_path, $customer_id);

    // Execute query and return response
    if ($stmt->execute()) {
        $response = [
            "status" => "success",
            "message" => "Customer profile updated successfully!",
            "data" => [
                "customer_name" => $customer_name,
                "customer_email" => $customer_email,
                "customer_phone" => $customer_phone,
                "customer_address" => $customer_address,
                "customer_status" => $customer_status,
                "customer_image" => $image_path,
            ],
        ];
    } else {
        $response["message"] = "Error updating profile: " . $stmt->error;
    }
}

// Return JSON response
echo json_encode($response);
?>
