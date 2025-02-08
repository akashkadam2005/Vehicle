<?php
include "../config/connection.php";
include "../component/header.php";
include "../component/sidebar.php";

if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];
    $employee_id = mysqli_real_escape_string($conn, $employee_id);

    // Fetch employee details from the database
    $query = "SELECT * FROM tbl_employee WHERE employee_id = '$employee_id'";
    $result = mysqli_query($conn, $query);

    // Check if employee exists
    if (mysqli_num_rows($result) > 0) {
        $employee = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Employee not found.'); window.location.href = 'index.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'index.php';</script>";
    exit();
}
?>

<div class="content-wrapper p-2">
    <div class="card">
        <div class="card-header">
            <div class="text-center p-3">
                <h3 class="font-weight-bold">Employee Identity Card</h3>
            </div>
        </div>

        <div class="card-body">
            <div class="identity-card">
                <div class="text-center">
                    <!-- Profile Image -->
                    <img src="../uploads/employees/<?= $employee['employee_image'] ?: 'no_img.png' ?>" class="employee-img" alt="Employee Image">
                </div>
                <div class="employee-info">
                    <p><strong>Employee Name:</strong> <?= $employee['employee_name'] ?></p>
                    <p><strong>Email:</strong> <?= $employee['employee_email'] ?></p>
                    <p><strong>Phone:</strong> <?= $employee['employee_phone'] ?></p>
                    <p><strong>Address:</strong> <?= $employee['employee_address'] ?></p> 
                    <p><strong>Status:</strong> <?= $employee['employee_status'] == 1 ? 'Active' : 'Inactive' ?></p>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="edit.php?employee_id=<?= $employee['employee_id'] ?>" class="btn btn-info shadow"> <i class="fa fa-pen"></i></a>
                <a href="delete.php?employee_id=<?= $employee['employee_id'] ?>" onclick="return confirm('Are you sure you want to delete this employee?');" class="btn btn-danger shadow"> <i class="fa fa-trash"></i> </a>
                <a href="index.php" class="btn shadow btn-success"> <i class="fa fa-eye"></i>&nbsp;&nbsp;Back to List</a>
            </div>
        </div>
    </div>
</div>

<?php
include "../component/footer.php";
?>

<style>
    .identity-card {
        width: 350px;
        margin: 0 auto;
        padding: 20px;
        border-radius: 15px;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .employee-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 3px solid #ddd;
        object-fit: cover;
        margin-bottom: 20px;
    }

    .employee-info {
        text-align: left;
        font-size: 14px;
    }

    .employee-info p {
        margin: 8px 0;
        font-weight: bold;
    }

    .employee-info strong {
        color: #333;
    }

    .identity-card .btn {
        margin: 5px;
    }
</style>
