<?php 

include "../config/connection.php";
include "../component/header.php";
include "../component/sidebar.php";

// Check if the form is submitted
if (isset($_POST["register_employee"])) {
    // Sanitize and get form data
    $employee_name = mysqli_real_escape_string($conn, $_POST["employee_name"]);
    $employee_email = mysqli_real_escape_string($conn, $_POST["employee_email"]);
    $employee_password = mysqli_real_escape_string($conn, $_POST["employee_password"]);
    $confirm_password = mysqli_real_escape_string($conn, $_POST["confirm_password"]);
    $employee_phone = mysqli_real_escape_string($conn, $_POST["employee_phone"]);
    $employee_address = mysqli_real_escape_string($conn, $_POST["employee_address"]);
    $employee_position = mysqli_real_escape_string($conn, $_POST["employee_position"]);
    $employee_salary = mysqli_real_escape_string($conn, $_POST["employee_salary"]);
    $employee_status = 1; // Default status 1 (Active)

    // Image upload processing
    $employee_image = $_FILES["employee_image"]["name"];
    $employee_image_temp = $_FILES["employee_image"]["tmp_name"];
    $image_path = "";

    // Validate required fields
    if (empty($employee_name) || empty($employee_email) || empty($employee_password) || empty($confirm_password) || empty($employee_phone) || empty($employee_address) || empty($employee_position) || empty($employee_salary)) {
        $_SESSION["error"] = "Please fill in all required fields!";
    } elseif ($employee_password !== $confirm_password) {
        $_SESSION["error"] = "Passwords do not match!";
    } else {
        // Check if email already exists
        $checkEmailQuery = "SELECT * FROM tbl_employee WHERE employee_email = '$employee_email'";
        $checkEmailResult = mysqli_query($conn, $checkEmailQuery);
        if (mysqli_num_rows($checkEmailResult) > 0) {
            $_SESSION["error"] = "Email is already registered!";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($employee_password, PASSWORD_DEFAULT);

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
                } elseif (!in_array($imageFileType, ["jpg", "jpeg", "png"])) {
                    $_SESSION["error"] = "Only JPG, JPEG, & PNG files are allowed!";
                } else {
                    if (move_uploaded_file($employee_image_temp, $target_file)) {
                        $image_path = $employee_image;
                    } else {
                        $_SESSION["error"] = "Error uploading the image!";
                    }
                }
            }

            // Insert query with image path
            $insertQuery = "INSERT INTO tbl_employee (employee_name, employee_email, employee_password, employee_phone, employee_address, employee_position, employee_salary, employee_status, employee_image) 
                            VALUES ('$employee_name', '$employee_email', '$hashed_password', '$employee_phone', '$employee_address', '$employee_position', '$employee_salary', '$employee_status', '$image_path')";
            if (mysqli_query($conn, $insertQuery)) {
                $_SESSION["success"] = "Employee registered successfully!";
                echo "<script>window.location = 'index.php';</script>";
            } else {
                $_SESSION["error"] = "Error registering employee: " . mysqli_error($conn);
            }
        }
    }
}
?>

<div class="content-wrapper p-2">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card">
            <div class="card-header">
                <div class="d-flex p-2 justify-content-between">
                    <div class="h5 font-weight-bold">Create Employee</div>
                    <a href="index.php" class="btn btn-info shadow font-weight-bold">
                        <i class="fa fa-eye"></i>&nbsp; Employee List
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Display error or success messages -->
                <?php
                if (isset($_SESSION["error"])) {
                    echo "<p style='color: red;'>".$_SESSION["error"]."</p>";
                    unset($_SESSION["error"]);
                }
                if (isset($_SESSION["success"])) {
                    echo "<p style='color: green;'>".$_SESSION["success"]."</p>";
                    unset($_SESSION["success"]);
                }
                ?>
                
                <div class="row">
                    <div class="col-4">
                        <label for="employee_name">Full Name <span class="text-danger">*</span></label>
                        <input type="text" placeholder="Enter full name" class="form-control font-weight-bold" name="employee_name" id="employee_name" required>
                    </div>
                    <div class="col-4">
                        <label for="employee_email">Email <span class="text-danger">*</span></label>
                        <input type="email" placeholder="Enter email" class="form-control font-weight-bold" name="employee_email" id="employee_email" required>
                    </div>
                    <div class="col-4">
                        <label for="employee_phone">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" placeholder="Enter phone number" class="form-control font-weight-bold" name="employee_phone" id="employee_phone" required>
                    </div>
                    
                    <div class="col-4 mt-3">
                        <label for="employee_password">Password <span class="text-danger">*</span></label>
                        <input type="password" placeholder="Enter password" class="form-control font-weight-bold" name="employee_password" id="employee_password" required>
                    </div>
                    <div class="col-4 mt-3">
                        <label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" placeholder="Confirm password" class="form-control font-weight-bold" name="confirm_password" id="confirm_password" required>
                    </div>
                    <div class="col-4 mt-3">
                        <label for="employee_image">Profile Image</label>
                        <input type="file" class="form-control font-weight-bold" name="employee_image" id="employee_image" accept="image/*">
                    </div>
                    <div class="col-4 mt-3">
                        <label for="employee_position">Position <span class="text-danger">*</span></label>
                        <input type="text" placeholder="Enter position" class="form-control font-weight-bold" name="employee_position" id="employee_position" required>
                    </div>
                    <div class="col-4 mt-3">
                        <label for="employee_salary">Salary <span class="text-danger">*</span></label>
                        <input type="number" placeholder="Enter salary" class="form-control font-weight-bold" name="employee_salary" id="employee_salary" required>
                    </div>
                    <div class="col-12 mt-3">
                        <label for="employee_address">Address <span class="text-danger">*</span></label>
                        <textarea rows="5" type="text" placeholder="Enter address" class="form-control font-weight-bold" name="employee_address" id="employee_address" required></textarea>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button name="register_employee" type="submit" class="btn btn-primary shadow font-weight-bold">
                        <i class="fa fa-save"></i>&nbsp; Register Employee
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
