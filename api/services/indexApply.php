<?php
include "../config/connection.php"; // Include database connection
header("Content-Type: application/json");

// Check if it's a GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Query to fetch all booking services
    $query = "SELECT 
                booking_id, 
                booking_category_id, 
                booking_service_id, 
                booking_customer_id, 
                booking_time, 
                booking_date, 
                booking_washing_point, 
                booking_message, 
                booking_status, 
                booking_price, 
                booking_payment_method, 
                booking_payment_status 
              FROM tbl_bookings";

    $result = $conn->query($query);

    if ($result === false) {
        echo json_encode([
            "status" => "error",
            "message" => "Database query failed: " . $conn->error
        ]);
        exit;
    }

    if ($result->num_rows > 0) {
        $bookings = [];

        // Fetch all rows as an associative array
        while ($row = $result->fetch_assoc()) {
            $bookings[] = [
                "booking_id" => $row["booking_id"],
                "booking_category_id" => $row["booking_category_id"],
                "booking_service_id" => $row["booking_service_id"],
                "booking_customer_id" => $row["booking_customer_id"],
                "booking_time" => $row["booking_time"],
                "booking_date" => $row["booking_date"],
                "booking_washing_point" => $row["booking_washing_point"],
                "booking_message" => $row["booking_message"],
                "booking_status" => $row["booking_status"],
                "booking_status_label" => getStatusLabel($row["booking_status"]),
                "booking_price" => $row["booking_price"],
                "booking_payment_method" => $row["booking_payment_method"],
                "booking_payment_status" => $row["booking_payment_status"],
                "payment_status_label" => getPaymentStatusLabel($row["booking_payment_status"])
            ];
        }

        // Return data as JSON
        echo json_encode([
            "status" => "success",
            "message" => "Bookings fetched successfully",
            "data" => $bookings
        ]);
    } else {
        // If no bookings are found
        echo json_encode([
            "status" => "success",
            "message" => "No bookings found",
            "data" => []
        ]);
    }
} else {
    // Invalid request method
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

// Helper functions to get labels
function getStatusLabel($status) {
    $labels = [
        1 => "Pending",
        2 => "Accepted",
        3 => "Completed",
        4 => "Rejected"
    ];
    return $labels[$status] ?? "Unknown";
}

function getPaymentStatusLabel($payment_status) {
    $labels = [
        1 => "Pending",
        2 => "Complete",
        3 => "Rejected"
    ];
    return $labels[$payment_status] ?? "Unknown";
}
?>
