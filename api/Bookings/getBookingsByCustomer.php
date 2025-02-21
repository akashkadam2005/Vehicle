<?php
include "../config/connection.php";

// Set response header
header("Content-Type: application/json");

// Check if customer_id is passed as a query parameter
if (isset($_GET['customer_id']) && !empty($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];

    // Prepare the query to fetch all relevant fields
    $query = "SELECT 
                b.booking_id, 
                c.customer_name, 
                cat.category_name, 
                s.service_name, 
                b.booking_date, 
                b.booking_time, 
                b.booking_washing_point, 
                b.booking_message, 
                b.booking_price, 
                b.booking_payment_method, 
                b.booking_payment_status, 
                b.booking_status 
              FROM tbl_bookings b
              JOIN tbl_customer c ON b.booking_customer_id = c.customer_id
              JOIN tbl_category cat ON b.booking_category_id = cat.category_id
              JOIN tbl_services s ON b.booking_service_id = s.service_id
              WHERE b.booking_customer_id = $customer_id";

    $result = mysqli_query($conn, $query);
    
    // Check if there are any results
    if (mysqli_num_rows($result) > 0) {
        $bookings = [];
        while ($data = mysqli_fetch_array($result)) {
            $bookings[] = [
                'booking_id' => $data['booking_id'],
                'customer_name' => $data['customer_name'],
                'category_name' => $data['category_name'],
                'service_name' => $data['service_name'],
                'booking_date' => date("d M Y", strtotime($data["booking_date"])),
                'booking_time' => date("h:i A", strtotime($data["booking_time"])),
                'booking_washing_point' => $data['booking_washing_point'] ?? 'N/A',
                'booking_message' => $data['booking_message'] ?? 'N/A',
                'booking_price' => "₹" . number_format($data['booking_price'], 2),
                'booking_payment_method' => $data['booking_payment_method'] ?? 'N/A',
                'booking_payment_status' => ($data["booking_payment_status"] == 2 ? "Paid" : "Pending"),
                'booking_status' => getStatusLabel($data["booking_status"]),
            ];
        }

        // Return the bookings data as JSON
        echo json_encode([
            'status' => 'success',
            'data' => $bookings
        ]);
    } else {
        // No bookings found
        echo json_encode([
            'status' => 'error',
            'message' => 'No bookings found for the provided customer.'
        ]);
    }
} else {
    // Missing customer_id
    echo json_encode([
        'status' => 'error',
        'message' => 'Customer ID is required.'
    ]);
}

// Helper function to get status label
function getStatusLabel($status) {
    $labels = [
        1 => "Pending",
        2 => "InProgress",
        3 => "Completed",
        4 => "Rejected"
    ];
    return $labels[$status] ?? "Unknown";
}
?>
