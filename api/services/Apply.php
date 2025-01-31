<?php
include "../config/connection.php";
header("Content-Type: application/json");

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Extracting data from the request
    $booking_category_id = $data['booking_category_id'] ?? null;
    $booking_service_id = $data['booking_service_id'] ?? null;
    $booking_customer_id = $data['booking_customer_id'] ?? null;
    $booking_time = $data['booking_time'] ?? null;
    $booking_date = $data['booking_date'] ?? null;
    $booking_washing_point = $data['booking_washing_point'] ?? null;
    $booking_message = $data['booking_message'] ?? null;
    $booking_price = $data['booking_price'] ?? null;
    $booking_payment_method = $data['booking_payment_method'] ?? null;
    $booking_payment_status = $data['booking_payment_status'] ?? 1; // Default to "Pending"
    $booking_status = $data['booking_status'] ?? 1; // Default to "Pending"

    // Validate required fields
    if (!$booking_category_id || !$booking_service_id || !$booking_customer_id || !$booking_date || !$booking_time || !$booking_price) {
        echo json_encode([
            "status" => "error",
            "message" => "Required fields are missing (category ID, service ID, customer ID, date, time, or price)"
        ]);
        exit;
    }

    // Insert booking into the database
    $stmt = $conn->prepare(
        "INSERT INTO tbl_bookings (booking_category_id, booking_service_id, booking_customer_id, booking_time, booking_date, 
                                    booking_washing_point, booking_message, booking_status, booking_price, 
                                    booking_payment_method, booking_payment_status) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param(
        "iiissssidsi", 
        $booking_category_id, $booking_service_id, $booking_customer_id, $booking_time, $booking_date, 
        $booking_washing_point, $booking_message, $booking_status, $booking_price, 
        $booking_payment_method, $booking_payment_status
    );

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Booking created successfully",
            "booking_id" => $stmt->insert_id
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to create booking: " . $stmt->error
        ]);
    }

    // Close the statement
    $stmt->close();
} else {
    // Invalid request method
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
