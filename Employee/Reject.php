<?php
include "../config/connection.php";
include "../component/header.php";
include "../component/sidebar.php";
?>

<div class="content-wrapper p-2">
    <div class="card">
        <div class="card-header">
            <div class="text-center p-3">
                <h3 class="font-weight-bold">Filtered Customers</h3>
            </div>
            <form action="">
                <div class="row justify-content-end">
                    <div class="col-2 font-weight-bold">
                        Customer Name
                        <input type="search" name="customer_name" value="<?= isset($_GET["customer_name"]) ? $_GET["customer_name"] : "" ?>" class="form-control font-weight-bold" placeholder="Customer Name">
                    </div>
                    <div class="col-1 font-weight-bold">
                        <br>
                        <button type="submit" class="shadow btn w-100 btn-info font-weight-bold"> <i class="fas fa-search"></i> &nbsp;Find</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            <?php
            if (isset($_SESSION["success"])) {
            ?>
                <div class="font-weight-bold alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5 class="font-weight-bold"><i class="icon fas fa-check"></i> Success!</h5>
                    <?= $_SESSION["success"] ?>
                </div>
            <?php
                unset($_SESSION["success"]);
            }
            ?>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Profile</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $count = 0;
                    $limit = 10;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    // Base query to count and fetch filtered customers
                    $countQuery = "SELECT COUNT(*) as total FROM tbl_customer WHERE customer_status IN (0, 2)";
                    $selectQuery = "SELECT * FROM tbl_customer WHERE customer_status IN (0, 2) LIMIT $limit OFFSET $offset";

                    // If search is applied, add search filter
                    if (isset($_GET["customer_name"]) && $_GET["customer_name"] !== "") {
                        $customer_name = mysqli_real_escape_string($conn, $_GET["customer_name"]);
                        $countQuery = "SELECT COUNT(*) as total FROM tbl_customer WHERE customer_status IN (0, 2) AND customer_name LIKE '%$customer_name%'";
                        $selectQuery = "SELECT * FROM tbl_customer WHERE customer_status IN (0, 2) AND customer_name LIKE '%$customer_name%' LIMIT $limit OFFSET $offset";
                    }

                    // Execute count query to calculate total records
                    $countResult = mysqli_query($conn, $countQuery);
                    $totalRecords = mysqli_fetch_assoc($countResult)['total'];
                    $totalPages = ceil($totalRecords / $limit);

                    // Execute select query to fetch filtered records
                    $result = mysqli_query($conn, $selectQuery);
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?= ++$count ?></td>
                            <td><img src="../uploads/customers/<?= $data['customer_image'] == null ? "no_img.png" : $data['customer_image'] ?>" width="100" height="100" alt="Customer Image"></td>
                            <td><?= $data["customer_name"] ?></td>
                            <td><?= $data["customer_email"] ?></td>
                            <td><?= $data["customer_phone"] ?></td>
                            <td><?= $data["customer_address"] ?></td>
                            <td><?= $data["customer_status"] == 1 ? 'Active' : ($data["customer_status"] == 2 ? 'Inactive 2' : 'Inactive') ?></td>
                            <td>
                                <a href="view.php?customer_id=<?= $data["customer_id"] ?>" class="btn btn-sm shadow btn-success">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="edit.php?customer_id=<?= $data["customer_id"] ?>" class="btn btn-sm shadow btn-info">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <a href="delete.php?customer_id=<?= $data["customer_id"] ?>" onclick="return confirm('Are you sure you want to delete this customer?');" class="btn btn-sm shadow btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    <?php if ($count == 0) { ?>
                        <tr>
                            <td colspan="8" class="font-weight-bold text-center text-danger">No Customers Found.</td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>

        <div class="card-footer">
            <div class="d-flex justify-content-center">
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a class="btn btn-sm btn-outline-info ml-2" href="?page=<?= $page - 1 ?>&customer_name=<?= isset($_GET['customer_name']) ? $_GET['customer_name'] : '' ?>">Previous</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a class="btn btn-sm <?= $page == $i ? "btn-info" : "btn-outline-info" ?> ml-2 shadow" href="?page=<?= $i ?>&customer_name=<?= isset($_GET['customer_name']) ? $_GET['customer_name'] : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a class="btn btn-sm btn-outline-info ml-2" href="?page=<?= $page + 1 ?>&customer_name=<?= isset($_GET['customer_name']) ? $_GET['customer_name'] : '' ?>">Next</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "../component/footer.php";
?>
