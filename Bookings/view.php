<?php
include "../config/connection.php";
include "../component/header.php";
include "../component/sidebar.php";

$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : null;

if (!$booking_id) {
    $_SESSION['error'] = 'Booking ID is missing!';
    header("Location: index.php");
    exit;
}

// Fetch booking details
$query = "SELECT * FROM tbl_bookings
INNER JOIN tbl_customer ON tbl_customer.customer_id = tbl_bookings.booking_customer_id
INNER JOIN tbl_category ON tbl_category.category_id = tbl_bookings.booking_category_id
INNER JOIN tbl_services ON tbl_services.service_id = tbl_bookings.booking_service_id
LEFT JOIN tbl_employee ON tbl_employee.employee_id = tbl_bookings.booking_employee_id
WHERE booking_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $booking_id);
$stmt->execute();
$booking_result = $stmt->get_result();
$booking = $booking_result->fetch_assoc();

if (!$booking) {
    $_SESSION['error'] = 'Booking not found!';
    header("Location: index.php");
    exit;
}

// Fetch Employees for Assignment
$employee_query = "SELECT * FROM tbl_employee";
$employee_result = $conn->query($employee_query);

// Update booking status and assigned employee
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_status = $_POST['payment_status'];
    $booking_status = $_POST['booking_status'];
    $booking_employee_id = $_POST['booking_employee_id']; // New field

    $update_query = "UPDATE tbl_bookings SET booking_payment_status = ?, booking_status = ?, booking_employee_id = ? WHERE booking_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('siii', $payment_status, $booking_status, $booking_employee_id, $booking_id);

    if ($update_stmt->execute()) {
        $_SESSION['success'] = 'Booking updated successfully!';
        echo "<script>window.location = 'view.php?booking_id=$booking_id';</script>";
        exit;
    } else {
        $_SESSION['error'] = 'Failed to update booking!';
    }
}
?>

<div class="content-wrapper p-3">
    <div class="card shadow border-0">
        <div class="card-header">
            <h3 class="text-center font-weight-bold mb-0">Booking Details - <span class="text-warning">#<?= htmlspecialchars($booking['booking_id']) ?></span></h3>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['success'])) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['success'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php unset($_SESSION['success']);
            } ?>
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['error'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php unset($_SESSION['error']);
            } ?>

            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th>Booking ID</th>
                            <td><?= htmlspecialchars($booking['booking_id']) ?></td>
                        </tr>
                        <tr>
                            <th>Customer Name</th>
                            <td><?= htmlspecialchars($booking['customer_name']) ?></td>
                        </tr>
                        <tr>
                            <th>Booking Date</th>
                            <td><?= date("d/m/Y h:i A", strtotime($booking['booking_date'])) ?></td>
                        </tr>
                        <tr>
                            <th>Total Price</th>
                            <td>&#8377; <?= number_format($booking['booking_price'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td><?= htmlspecialchars($booking['category_name']) ?></td>
                        </tr>
                        <tr>
                            <th>Service</th>
                            <td><?= htmlspecialchars($booking['service_name']) ?></td>
                        </tr>
                        <tr>
                            <th>Assigned Employee</th>
                            <td>
                                <?= $booking['employee_name'] ? htmlspecialchars($booking['employee_name']) : "<span class='text-muted'>Not Assigned</span>" ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th>Payment Status</th>
                            <td><?= htmlspecialchars($booking['booking_payment_status']) == 2 ? "<span class='text-success font-weight-bold'>Paid</span>" : "<span class='text-danger font-weight-bold'>Unpaid</span>" ?></td>
                        </tr>
                        <tr>
                            <th>Booking Status</th>
                            <td><?= htmlspecialchars($booking['booking_status']) == 1 ? "Pending" : ($booking['booking_status'] == 2 ? "Accepted" : ($booking['booking_status'] == 3 ? "Completed" : "Rejected")) ?></td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td><?= date("d/m/Y h:i A", strtotime($booking['created_at'])) ?></td>
                        </tr>
                        <tr>
                            <th>Assigned Employee</th>
                            <td><?= $booking["employee_name"] ?? "Not Assigned" ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <form method="POST" class="p-3 bg-light rounded shadow-sm">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="payment_status">Payment Status</label>
                            <select name="payment_status" id="payment_status" class="form-control">
                                <option value="1" <?= $booking['booking_payment_status'] == 1 ? 'selected' : '' ?>>Unpaid</option>
                                <option value="2" <?= $booking['booking_payment_status'] == 2 ? 'selected' : '' ?>>Paid</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="booking_status">Booking Status</label>
                            <select name="booking_status" class="form-control">
                                <option value="1" <?= $booking["booking_status"] == "1" ? "selected" : "" ?>>Pending</option>
                                <option value="2" <?= $booking["booking_status"] == "2" ? "selected" : "" ?>>Accepted</option>
                                <option value="3" <?= $booking["booking_status"] == "3" ? "selected" : "" ?>>Completed</option>
                                <option value="4" <?= $booking["booking_status"] == "4" ? "selected" : "" ?>>Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="booking_employee_id">Assign Employee</label>
                            <select name="booking_employee_id" id="booking_employee_id" class="form-control">
                                <option value="">Select Employee</option>
                                <?php while ($employee = $employee_result->fetch_assoc()) { ?>
                                    <option value="<?= $employee['employee_id'] ?>" <?= $booking['booking_employee_id'] == $employee['employee_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($employee['employee_name']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary shadow">Update</button>
                    <a href="index.php" class="mx-2 btn btn-success shadow"> <i class="fas fa-arrow-left"></i> Back</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "../component/footer.php"; ?>
