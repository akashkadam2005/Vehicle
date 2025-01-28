<?php
include "../config/connection.php";
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $service_status = isset($_GET['service_status']) ? intval($_GET['service_status']) : null;

    // SQL Query using GROUP_CONCAT
    $sql = "
        SELECT 
            p.service_id, 
            p.service_name, 
            p.service_description, 
            p.service_image,
            p.service_price,
            p.service_dis, 
            p.service_dis_value,
            p.service_status, 
            c.category_name, 
            COALESCE(ROUND(AVG(r.rating), 1), 0) AS avg_rating,
            GROUP_CONCAT(
                CONCAT(
                    '{\"customer_id\":', cust.customer_id, 
                    ',\"customer_name\":\"', cust.customer_name, 
                    '\",\"rating\":', r.rating, 
                    ',\"review\":\"', r.review_rating, 
                    '\",\"rated_at\":\"', r.created_at, 
                    '\"}'
                )
            ) AS customer_ratings
        FROM tbl_services p
        INNER JOIN tbl_category c ON c.category_id = p.category_id
        LEFT JOIN tbl_ratings r ON r.service_id = p.service_id
        LEFT JOIN tbl_customer cust ON cust.customer_id = r.customer_id";

    if ($service_status === 1) {
        $sql .= " WHERE p.service_status = 1";
    }

    $sql .= " GROUP BY p.service_id";

    // Execute the query
    $result = $conn->query($sql);

    if ($result) {
        $services = [];
        while ($row = $result->fetch_assoc()) {
            // Parse the concatenated customer ratings into an array
            $row['customer_ratings'] = $row['customer_ratings'] ? json_decode("[" . $row['customer_ratings'] . "]", true) : [];
            $services[] = $row;
        }
        echo json_encode(["status" => "success", "data" => $services]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to fetch services. Error: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
