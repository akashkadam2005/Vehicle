<?php
include "../config/connection.php";
include "../component/header.php";
include "../component/sidebar.php"; // Database connection
// session_start();

// Check if form is submitted
if (isset($_POST["city_create"])) {
    $city_name = mysqli_real_escape_string($conn, $_POST["city_name"]);
    $city_status = isset($_POST["city_status"]) ? 1 : 0; // Checkbox for status (Active/Inactive)

    // Validate required fields
    if (empty($city_name)) {
        $_SESSION["error"] = "City Name is required!";
    } else {
        // Insert city data into the database
        $insertQuery = "INSERT INTO tbl_city (city_name, city_status) VALUES ('$city_name', '$city_status')";

        if (mysqli_query($conn, $insertQuery)) {
            $_SESSION["success"] = "City Created Successfully!";
            echo "<script>window.location = 'index.php';</script>";
        } else {
            $_SESSION["error"] = "Error in creating city: " . mysqli_error($conn);
        }
    }
}
?>

<div class="content-wrapper p-2">
    <form action="store.php" method="post">
        <div class="card">
            <div class="card-header">
                <div class="d-flex p-2 justify-content-between">
                    <div class="h5 font-weight-bold">Create New City</div>
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
                        <input type="text" placeholder="Enter City Name" class="form-control font-weight-bold" name="city_name" id="city_name" required>
                    </div>

                    <!-- City Status -->
                    <div class="col-6">
                        <label for="city_status">City Status</label><br>
                        <input type="checkbox" name="city_status" id="city_status" checked> Active
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="d-flex p-2 justify-content-end">
                    <button name="city_create" type="submit" class="btn btn-primary shadow font-weight-bold">
                        <i class="fa fa-save"></i>&nbsp; Create City
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
