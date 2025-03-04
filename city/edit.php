<?php
include "../config/connection.php";
include "../component/header.php";
include "../component/sidebar.php";

// Get city ID from URL
if (isset($_GET['city_id'])) {
    $city_id = $_GET['city_id'];
    
    // Fetch city details
    $query = "SELECT * FROM tbl_city WHERE city_id = '$city_id'";
    $result = mysqli_query($conn, $query);
    $city = mysqli_fetch_assoc($result);
    
    if (!$city) {
        $_SESSION["error"] = "City not found!";
        echo "<script>window.location = 'index.php';</script>";
        exit;
    }
} else {
    $_SESSION["error"] = "Invalid request!";
    echo "<script>window.location = 'index.php';</script>";
    exit;
}

// Handle form submission
if (isset($_POST["update_city"])) {
    $city_name = mysqli_real_escape_string($conn, $_POST["city_name"]);
    $city_status = isset($_POST["city_status"]) ? 1 : 0;
    
    // Update city details
    $updateQuery = "UPDATE tbl_city SET city_name = '$city_name', city_status = '$city_status' WHERE city_id = '$city_id'";
    
    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION["success"] = "City Updated Successfully!";
        echo "<script>window.location = 'index.php';</script>";
    } else {
        $_SESSION["error"] = "Error updating city: " . mysqli_error($conn);
    }
}
?>

<div class="content-wrapper p-2">
    <form action="" method="post">
        <div class="card">
            <div class="card-header">
                <div class="d-flex p-2 justify-content-between">
                    <div class="h5 font-weight-bold">Edit City</div>
                    <a href="index.php" class="btn btn-info shadow font-weight-bold">
                        <i class="fa fa-eye"></i>&nbsp; City List
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- City Name -->
                    <div class="col-6">
                        <label for="city_name">City Name <span class="text-danger">*</span></label>
                        <input type="text" placeholder="Enter City Name" class="form-control font-weight-bold" name="city_name" id="city_name" value="<?php echo htmlspecialchars($city['city_name']); ?>" required>
                    </div>

                    <!-- City Status -->
                    <div class="col-6">
                        <label for="city_status">City Status</label><br>
                        <input type="checkbox" name="city_status" id="city_status" <?php echo $city['city_status'] ? 'checked' : ''; ?>> Active
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="d-flex p-2 justify-content-end">
                    <button name="update_city" type="submit" class="btn btn-primary shadow font-weight-bold">
                        <i class="fa fa-save"></i>&nbsp; Update City
                    </button>
                    &nbsp;
                    <a href="index.php" class="btn btn-danger shadow font-weight-bold">
                        <i class="fas fa-times"></i>&nbsp; Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<?php include "../component/footer.php"; ?>
