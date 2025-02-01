<?php
include "../config/connection.php";
include "../component/header.php";
include "../component/sidebar.php";
?>

<div class="content-wrapper p-2">
    <div class="card">
        <div class="card-header">
            <div class="text-center p-3">
                <h3 class="font-weight-bold">Booking Management</h3>
            </div>
            <form action="" method="get">
                <div class="row justify-content-end">
                    <div class="col-2 font-weight-bold">
                        Booking Status
                        <select name="booking_status" class="form-control font-weight-bold">
                            <option value="">All</option>
                            <option value="1">Pending</option>
                            <option value="2">Accepted</option>
                            <option value="3">Completed</option>
                            <option value="4">Rejected</option>
                        </select>
                    </div>
                    <div class="col-1 font-weight-bold">
                        <br>
                        <button type="submit" class="shadow btn w-100 btn-info font-weight-bold">
                            <i class="fas fa-search"></i> &nbsp;Find
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Customer Name</th>
                        <th>Category Name</th>
                        <th>Service Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Price</th>
                        <th>Payment Status</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    // Apply filtering based on status
                    $whereClause = "";
                    if (isset($_GET['booking_status']) && !empty($_GET['booking_status'])) {
                        $status = $_GET['booking_status'];
                        $whereClause = "WHERE b.booking_status = $status";
                    }

                    // Fetch data with JOINs
                    $query = "SELECT 
                                b.booking_id, 
                                c.customer_name, 
                                cat.category_name, 
                                s.service_name, 
                                b.booking_date, 
                                b.booking_time, 
                                b.booking_price, 
                                b.booking_payment_status, 
                                b.booking_status 
                              FROM tbl_bookings b
                              JOIN tbl_customer c ON b.booking_customer_id = c.customer_id
                              JOIN tbl_category cat ON b.booking_category_id = cat.category_id
                              JOIN tbl_services s ON b.booking_service_id = s.service_id
                              $whereClause";

                    $result = mysqli_query($conn, $query);
                    $count = 0;

                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?= ++$count ?></td>
                            <td><?= $data["customer_name"] ?></td>
                            <td><?= $data["category_name"] ?></td>
                            <td><?= $data["service_name"] ?></td>
                            <td><?= date("d M Y", strtotime($data["booking_date"])) ?></td>
                            <td><?= date("h:i A", strtotime($data["booking_time"])) ?></td>
                            <td>₹<?= number_format($data["booking_price"], 2) ?></td>
                            <td>
                                <span class="badge badge-<?= $data["booking_payment_status"] == 2 ? 'success' : 'warning' ?>">
                                    <?= $data["booking_payment_status"] == 2 ? 'Paid' : 'Pending' ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-<?= getStatusBadge($data["booking_status"]) ?>">
                                    <?= getStatusLabel($data["booking_status"]) ?>
                                </span>
                            </td>
                            <td>
                                <a href="view.php?booking_id=<?= $data['booking_id'] ?>" class="btn btn-sm shadow btn-primary">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="edit.php?booking_id=<?= $data['booking_id'] ?>" class="btn btn-sm shadow btn-info">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <a href="delete.php?booking_id=<?= $data['booking_id'] ?>"
                                    onclick="return confirm('Are you sure you want to delete this booking?')"
                                    class="btn btn-sm shadow btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }

                    // Helper function to get status label
                    function getStatusLabel($status)
                    {
                        $labels = [
                            1 => "Pending",
                            2 => "Accepted",
                            3 => "Completed",
                            4 => "Rejected"
                        ];
                        return $labels[$status] ?? "Unknown";
                    }

                    // Helper function to get status badge color
                    function getStatusBadge($status)
                    {
                        $badges = [
                            1 => "warning",
                            2 => "info",
                            3 => "success",
                            4 => "danger"
                        ];
                        return $badges[$status] ?? "secondary";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include "../component/footer.php";
?>