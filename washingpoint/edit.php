<?php
include "../config/connection.php";
include "../component/header.php";
include "../component/sidebar.php";

// Get washing point details
if (isset($_GET['washing_id'])) {
    $washing_id = $_GET['washing_id'];
    $query = "SELECT * FROM tbl_washing_point WHERE washing_id = '$washing_id'";
    $result = mysqli_query($conn, $query);
    $washing_point = mysqli_fetch_assoc($result);
    if (!$washing_point) {
        $_SESSION["error"] = "Washing Point not found!";
        echo "<script>window.location = 'index.php';</script>";
        exit;
    }
} else {
    echo "<script>window.location = 'index.php';</script>";
    exit;
}

// Handle form submission
if (isset($_POST["update_washing_point"])) {
    $washing_city_id = $_POST['washing_city_id'];
    $washing_location = mysqli_real_escape_string($conn, $_POST['washing_location']);
    $washing_landmark = mysqli_real_escape_string($conn, $_POST['washing_landmark']);
    
    // Update washing point
    $update_query = "UPDATE tbl_washing_point SET washing_city_id = '$washing_city_id', washing_location = '$washing_location', washing_landmark = '$washing_landmark' WHERE washing_id = '$washing_id'";
    
    if (mysqli_query($conn, $update_query)) {
        $_SESSION["success"] = "Washing Point Updated Successfully!";
        echo "<script>window.location = 'index.php';</script>";
    } else {
        $_SESSION["error"] = "Error updating washing point: " . mysqli_error($conn);
    }
}
?>

<div class="content-wrapper p-2">
    <form action="" method="post">
        <div class="card">
            <div class="card-header">
                <div class="d-flex p-2 justify-content-between">
                    <div class="h5 font-weight-bold">Edit Washing Point</div>
                    <a href="index.php" class="btn btn-info shadow font-weight-bold">
                        <i class="fa fa-eye"></i>&nbsp; Washing Point List
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <label for="washing_city_id">City <span class="text-danger">*</span></label>
                        <select name="washing_city_id" class="form-control font-weight-bold" required>
                            <option value="">Select City</option>
                            <?php
                            $cityResult = mysqli_query($conn, "SELECT * FROM tbl_city");
                            while ($city = mysqli_fetch_assoc($cityResult)) {
                                $selected = ($city['city_id'] == $washing_point['washing_city_id']) ? 'selected' : '';
                                echo "<option value='" . $city['city_id'] . "' $selected>" . $city['city_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="washing_location">Location <span class="text-danger">*</span></label>
                        <input type="text" class="form-control font-weight-bold" name="washing_location" value="<?php echo $washing_point['washing_location']; ?>" required>
                    </div> 
                    <div class="col-4">
                        <label for="washing_landmark">Landmark</label>
                        <input type="text" class="form-control font-weight-bold" name="washing_landmark" value="<?php echo $washing_point['washing_landmark']; ?>">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex p-2 justify-content-end">
                    <button name="update_washing_point" type="submit" class="btn btn-primary shadow font-weight-bold">
                        <i class="fa fa-save"></i>&nbsp; Update Washing Point
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

<?php
include "../component/footer.php";
?>
