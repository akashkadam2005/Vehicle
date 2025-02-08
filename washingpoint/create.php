<?php
include "../config/connection.php";
include "../component/header.php";
include "../component/sidebar.php";

// Handle form submission
if (isset($_POST["store_washing_point"])) {
    $washing_city_id = $_POST['washing_city_id'];
    $washing_location = mysqli_real_escape_string($conn, $_POST['washing_location']);
    $washing_landmark = mysqli_real_escape_string($conn, $_POST['washing_landmark']);
    
    // Insert new washing point
    $query = "INSERT INTO tbl_washing_point (washing_city_id, washing_location, washing_landmark) 
              VALUES ('$washing_city_id', '$washing_location', '$washing_landmark')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION["success"] = "Washing Point Created Successfully!";
        echo "<script>window.location = 'index.php';</script>";
    } else {
        $_SESSION["error"] = "Error in creating washing point: " . mysqli_error($conn);
    }
}
?>

<div class="content-wrapper p-2">
    <form action="" method="post">
        <div class="card">
            <div class="card-header">
                <div class="d-flex p-2 justify-content-between">
                    <div class="h5 font-weight-bold">Create New Washing Point</div>
                    <a href="index.php" class="btn btn-info shadow font-weight-bold">
                        <i class="fa fa-eye"></i>&nbsp; Washing Point List
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- City Dropdown -->
                <div class="row">
                    <div class="col-6">
                        <label for="washing_city_id">City <span class="text-danger">*</span></label>
                        <select name="washing_city_id" class="form-control font-weight-bold" required>
                            <option value="">Select City</option>
                            <?php
                            $cityResult = mysqli_query($conn, "SELECT * FROM tbl_city");
                            while ($city = mysqli_fetch_assoc($cityResult)) {
                                echo "<option value='" . $city['city_id'] . "'>" . $city['city_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Location -->
                    <div class="col-6">
                        <label for="washing_location">Location <span class="text-danger">*</span></label>
                        <input type="text" class="form-control font-weight-bold" name="washing_location" required>
                    </div>
                </div>

                <!-- Landmark -->
                <div class="row">
                    <div class="col-6">
                        <label for="washing_landmark">Landmark</label>
                        <input type="text" class="form-control font-weight-bold" name="washing_landmark">
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="d-flex p-2 justify-content-end">
                    <button name="store_washing_point" type="submit" class="btn btn-primary shadow font-weight-bold">
                        <i class="fa fa-save"></i>&nbsp; Save Washing Point
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

<?php
include "../component/footer.php";
?>
