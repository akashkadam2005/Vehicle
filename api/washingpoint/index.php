<?php
// Include necessary files
include "../config/connection.php";  // Database connection

// Set content-type to JSON
header('Content-Type: application/json');

// Initialize response array
$response = array();

// Check if city_id is provided in the request
$whereClause = "";
if (isset($_GET['washing_city_id']) && !empty($_GET['washing_city_id'])) {
    $city_id = $_GET['washing_city_id'];
    $whereClause = "WHERE washing_city_id = $city_id";
}

// Query to get washing points and their associated city names
$query = "SELECT wp.*, c.city_name FROM tbl_washing_point wp LEFT JOIN tbl_city c ON wp.washing_city_id = c.city_id $whereClause";
$result = mysqli_query($conn, $query);

// Check if there are results
if (mysqli_num_rows($result) > 0) {
    // Fetch all data and store in an array
    $washing_points = array();
    while ($data = mysqli_fetch_assoc($result)) {
        $data['washing_status'] = ($data['washing_status'] == 1) ? 'Active' : 'Inactive';  // Convert status to readable format
        $washing_points[] = $data;
    }

    // Set response success status and data
    $response['status'] = 'success';
    $response['data'] = $washing_points;
} else {
    // If no results are found
    $response['status'] = 'error';
    $response['message'] = 'No washing points found';
}

// Encode response as JSON and send it back
echo json_encode($response);

// Close database connection
mysqli_close($conn);
?>
