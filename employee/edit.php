<?php
include "../config/connection.php";
include "../component/header.php";
include "../component/sidebar.php";

// Get the employee ID from the URL
$employee_id = $_GET['employee_id'];

// Fetch employee details
$employeeQuery = "SELECT * FROM tbl_employee WHERE employee_id = $employee_id";
$employeeResult = mysqli_query($conn, $employeeQuery);
$employee = mysqli_fetch_assoc($employeeResult);

// Check if the form is submitted
if (isset($_POST["employee_update"])) {
    // Sanitize and get form data
    $employee_name = mysqli_real_escape_string($conn, $_POST["employee_name"]);
    $employee_email = mysqli_real_escape_string($conn, $_POST["employee_email"]);
    $employee_password = mysqli_real_escape_string($conn, $_POST["employee_password"]);
    $employee_phone = mysqli_real_escape_string($conn, $_POST["employee_phone"]);
    $employee_address = mysqli_real_escape_string($conn, $_POST["employee_address"]);
    $employee_status = 1;
    $employee_image = $_FILES["employee_image"]["name"];
    $employee_image_temp = $_FILES["employee_image"]["tmp_name"];

    // Handle image upload if a new image is uploaded
    if (!empty($employee_image)) {
        $target_dir = "../uploads/employees/";
        $target_file = $target_dir . basename($employee_image);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($employee_image_temp);

        if ($check === false) {
            $_SESSION["error"] = "File is not an image!";
        } elseif (file_exists($target_file)) {
            $_SESSION["error"] = "Sorry, the file already exists!";
        } elseif ($_FILES["employee_image"]["size"] > 5000000) {
            $_SESSION["error"] = "Sorry, your file is too large!";
        } elseif (!in_array($imageFileType, ["jpg", "png", "jpeg"])) {
            $_SESSION["error"] = "Only JPG, JPEG, & PNG files are allowed!";
        } else {
            if (move_uploaded_file($employee_image_temp, $target_file)) {
                $image_path = $employee_image;
            } else {
                $_SESSION["error"] = "Error uploading the image!";
            }
        }
    } else {
        $image_path = $employee['employee_image']; // Keep existing image if no new one is uploaded
    }

    // Update query
    $updateQuery = "UPDATE tbl_employee SET 
        employee_name = '$employee_name',
        employee_email = '$employee_email',
        employee_password = '$employee_password',
        employee_phone = '$employee_phone',
        employee_address = '$employee_address',
        employee_status = '$employee_status',
        employee_image = '$image_path'
        WHERE employee_id = $employee_id";

    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION["success"] = "Employee Profile Updated Successfully!";
        echo "<script>window.location = 'index.php';</script>"; // Redirect to employee list
    } else {
        $_SESSION["error"] = "Error updating profile: " . mysqli_error($conn);
    }
}
?>

<div class="content-wrapper p-2">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card">
            <div class="card-header">
                <div class="d-flex p-2 justify-content-between">
                    <div class="h5 font-weight-bold">Edit Employee</div>
                    <a href="index.php" class="btn btn-info shadow font-weight-bold">
                        <i class="fa fa-eye"></i>&nbsp; View Employees
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <label for="employee_name">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control font-weight-bold" name="employee_name" id="employee_name" value="<?= $employee['employee_name'] ?>" required>
                    </div>
                    <div class="col-4">
                        <label for="employee_email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control font-weight-bold" name="employee_email" id="employee_email" value="<?= $employee['employee_email'] ?>" required>
                    </div>
                    <div class="col-4">
                        <label for="employee_password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control font-weight-bold" name="employee_password" id="employee_password" value="<?= $employee['employee_password'] ?>" required>
                    </div>
                    <div class="col-6 mt-3">
                        <label for="employee_phone">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control font-weight-bold" name="employee_phone" id="employee_phone" value="<?= $employee['employee_phone'] ?>" required>
                    </div>
                    <div class="col-6 mt-3">
                        <label for="employee_image">Profile Image</label>
                        <input type="file" class="form-control font-weight-bold" name="employee_image" id="employee_image" accept="image/*">
                        <?php if ($employee['employee_image']) { ?>
                            <small class="d-block mt-2">Current Image: <img src="../uploads/employees/<?= $employee['employee_image'] ?>" width="100px" alt="Profile Image"></small>
                        <?php } ?>
                    </div>
                    <div class="col-12 mt-3">
                        <label for="employee_address">Address <span class="text-danger">*</span></label>
                        <textarea name="employee_address" id="employee_address" rows="3" class="form-control font-weight-bold"><?= $employee['employee_address'] ?></textarea>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button name="employee_update" type="submit" class="btn btn-primary shadow font-weight-bold">
                        <i class="fa fa-save"></i>&nbsp; Update Profile
                    </button>
                    &nbsp;
                    <button type="reset" class="btn btn-danger shadow font-weight-bold">
                        <i class="fas fa-times"></i>&nbsp; Clear
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php include "../component/footer.php"; ?>
