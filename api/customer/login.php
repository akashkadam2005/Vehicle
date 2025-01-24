<?php
include "../config/connection.php";

// Set response format to JSON
header("Content-Type: application/json");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get JSON data from request body
    $input = json_decode(file_get_contents("php://input"), true);

    // Check if 'email' and 'password' exist in the JSON input
    if (isset($input["email"]) && isset($input["password"])) {
        $customer_email = mysqli_real_escape_string($conn, $input["email"]);
        $customer_password = mysqli_real_escape_string($conn, $input["password"]);

        // Validate required fields
        if (empty($customer_email) || empty($customer_password)) {
            echo json_encode(["error" => "Please fill in both email and password!"]);
            exit;
        }

        // Query to check if the customer exists in the database
        $query = "SELECT * FROM tbl_customer WHERE customer_email = '$customer_email' AND customer_status = 1";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Fetch customer data
            $customer = mysqli_fetch_assoc($result);

            // Verify the password
            if (password_verify($customer_password, $customer['customer_password'])) {
                // Generate a random token
                $token = bin2hex(random_bytes(32));

                // Store token in the database (Optional: Add token storage logic here)
                // For example: UPDATE tbl_customer SET token = '$token' WHERE customer_id = {$customer['customer_id']}

                // Remove sensitive data
                unset($customer['customer_password']);

                // Return success response with token and customer data
                echo json_encode([
                    "success" => "Login successful!",
                    "token" => $token,
                    "customer" => $customer
                ]);
            } else {
                echo json_encode(["error" => "Incorrect password!"]);
            }
        } else {
            echo json_encode(["error" => "Customer not found or account is inactive!"]);
        }
    } else {
        echo json_encode(["error" => "Please provide both email and password."]);
    }
} else {
    echo json_encode(["error" => "Invalid request method!"]);
}
?>
