<?php
include "../config/connection.php";
include "../component/header.php";
include "../component/sidebar.php";
?>

<div class="content-wrapper p-2">
    <div class="card">
        <div class="card-header">
            <div class="text-center p-3">
                <h3 class="font-weight-bold">Employee Management</h3>
            </div>
            <form action="">
                <div class="row justify-content-end">
                    <div class="col-2 font-weight-bold">
                        Employee Name
                        <input type="search" name="employee_name" value="<?= isset($_GET["employee_name"]) ? $_GET["employee_name"] : "" ?>" class="form-control font-weight-bold" placeholder="Employee Name">
                    </div>
                    <div class="col-1 font-weight-bold">
                        <br>
                        <button type="submit" class="shadow btn w-100 btn-info font-weight-bold"> <i class="fas fa-search"></i> &nbsp;Find</button>
                    </div>
                    <div class="col-2 font-weight-bold">
                        <br>
                        <a href="create.php" class="font-weight-bold w-100 shadow btn btn-success"> <i class="fas fa-plus"></i>&nbsp; Add Employee</a>
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
                    <h5 class="font-weight-bold "><i class="icon fas fa-check"></i> Success!</h5>
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
                        <th>Employee Name</th>
                        <th>Email</th>
                        <th>Phone</th> 
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $count = 0;
                    $limit = 10;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    $countQuery = "SELECT COUNT(*) as total FROM tbl_employee";
                    $selectQuery = "SELECT * FROM tbl_employee LIMIT $limit OFFSET $offset";

                    if (isset($_GET["employee_name"])) {
                        $employee_name = $_GET["employee_name"];
                        $employee_name = mysqli_real_escape_string($conn, $employee_name);
                        $countQuery = "SELECT COUNT(*) as total FROM tbl_employee WHERE employee_name LIKE '%$employee_name%'";
                        $selectQuery = "SELECT * FROM tbl_employee WHERE employee_name LIKE '%$employee_name%' LIMIT $limit OFFSET $offset";
                    }

                    $countResult = mysqli_query($conn, $countQuery);
                    $totalRecords = mysqli_fetch_assoc($countResult)['total'];
                    $totalPages = ceil($totalRecords / $limit);

                    $result = mysqli_query($conn, $selectQuery);
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?= ++$count ?></td>
                            <td><img src="../uploads/employees/<?= $data['employee_image'] == null ? "no_img.png" : $data['employee_image'] ?>" width="100" height="100" alt="Employee Image"></td>
                            <td><?= $data["employee_name"] ?></td>
                            <td><?= $data["employee_email"] ?></td>
                            <td><?= $data["employee_phone"] ?></td> 
                            <td><?= $data["employee_status"] == 1 ? '<span class="text-success font-weight-bold">Available</span>' : '<span class="text-danger font-weight-bold">On-duty</span>' ?></td>
                            <td>
                                <a href="view.php?employee_id=<?= $data["employee_id"] ?>" class="btn btn-sm shadow btn-success">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="edit.php?employee_id=<?= $data["employee_id"] ?>" class="btn btn-sm shadow btn-info">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <a href="delete.php?employee_id=<?= $data["employee_id"] ?>" onclick="return confirm('Are you sure you want to delete this employee?');" class="btn btn-sm shadow btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    if ($count == 0) {
                    ?>
                        <tr>
                            <td colspan="8" class="font-weight-bold text-center">
                                <span class="text-danger">No Employee Found.</span>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>

        <div class="card-footer">
            <div class="d-flex justify-content-center">
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a class="btn btn-sm btn-outline-info ml-2" href="?page=<?php echo $page - 1; ?>&employee_name=<?php echo isset($employee_name) ? $employee_name : ''; ?>">Previous</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a class="btn btn-sm <?= $page == $i ? "btn-info" : "btn-outline-info" ?>  ml-2 shadow" href="?page=<?php echo $i; ?>&employee_name=<?php echo isset($employee_name) ? $employee_name : ''; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a class="btn btn-sm btn-outline-info ml-2" href="?page=<?php echo $page + 1; ?>&employee_name=<?php echo isset($employee_name) ? $employee_name : ''; ?>">Next</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "../component/footer.php";
?>
