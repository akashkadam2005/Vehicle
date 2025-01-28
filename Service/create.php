<?php
include "../config/connection.php";
include "../component/header.php";
include "../component/sidebar.php";

// Check if the form is submitted
if (isset($_POST["service_create"])) {
    // Sanitize and get form data
    $service_name = mysqli_real_escape_string($conn, $_POST["service_name"]);
    $service_description = mysqli_real_escape_string($conn, $_POST["service_description"]);
    $service_price = mysqli_real_escape_string($conn, $_POST["service_price"]); 
    $category_id = mysqli_real_escape_string($conn, $_POST["category_id"]);
    $service_dis = mysqli_real_escape_string($conn, $_POST["service_dis"]);
    $service_dis_value = mysqli_real_escape_string($conn, $_POST["service_dis_value"]);
    $service_status = mysqli_real_escape_string($conn, $_POST["service_status"]);
    $service_image = $_FILES["service_image"]["name"];
    $service_image_temp = $_FILES["service_image"]["tmp_name"];

    // Validate required fields
    if (empty($service_name) || empty($service_price) || empty($category_id) || empty($service_status)) {
        $_SESSION["error"] = "Please fill in all required fields!";
    } else {
        // Handle image upload if a file is uploaded
        if (!empty($service_image)) {
            $target_dir = "../uploads/services/";
            $target_file = $target_dir . basename($service_image);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $check = getimagesize($service_image_temp);

            if ($check === false) {
                $_SESSION["error"] = "File is not an image!";
            } elseif (file_exists($target_file)) {
                $_SESSION["error"] = "Sorry, the file already exists!";
            } elseif ($_FILES["service_image"]["size"] > 5000000) {
                $_SESSION["error"] = "Sorry, your file is too large!";
            } elseif (!in_array($imageFileType, ["jpg", "png", "jpeg"])) {
                $_SESSION["error"] = "Only JPG, JPEG, & PNG files are allowed!";
            } else {
                if (move_uploaded_file($service_image_temp, $target_file)) {
                    $image_path = $service_image;
                } else {
                    $_SESSION["error"] = "Error uploading the image!";
                }
            }
        } else {
            $image_path = null;
        }

        // Insert query with new fields
        $insertQuery = "INSERT INTO tbl_services (service_name, service_description, service_price, category_id, service_image, service_dis, service_dis_value, service_status) 
                        VALUES ('$service_name', '$service_description', '$service_price', '$category_id', '$image_path', '$service_dis', '$service_dis_value', '$service_status')";
        if (mysqli_query($conn, $insertQuery)) {
            $_SESSION["success"] = "Service Created Successfully!";
            echo "<script>window.location = 'index.php';</script>";
        } else {
            $_SESSION["error"] = "Error creating product: " . mysqli_error($conn);
        }
    }
}
?>

<div class="content-wrapper p-2">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card">
            <div class="card-header">
                <div class="d-flex p-2 justify-content-between">
                    <div class="h5 font-weight-bold">Create Service</div>
                    <a href="index.php" class="btn btn-info shadow font-weight-bold">
                        <i class="fa fa-eye"></i>&nbsp; Service List
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <label for="service_name">Service Name <span class="text-danger">*</span></label>
                        <input type="text" placeholder="Service Name" class="form-control font-weight-bold" name="service_name" id="service_name" required>
                    </div>
                    <div class="col-4">
                        <label for="category_id">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-control font-weight-bold" required>
                            <option value="">Select Category</option>
                            <?php
                            $categoryQuery = "SELECT * FROM tbl_category WHERE category_status = 1";
                            $categoryResult = mysqli_query($conn, $categoryQuery);
                            while ($category = mysqli_fetch_assoc($categoryResult)) {
                                echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-2  ">
                        <label for="service_status">Visibillity<span class="text-danger">*</span></label>
                        <select name="service_status" id="service_status" class="form-control font-weight-bold" required>
                            <option value="">Select Visibility</option>
                            <option value="1">Public</option>
                            <option value="2">Hidden</option>
                        </select>
                    </div>
                    <div class="col-3 mt-3">
                        <label for="service_price">Service Price <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" placeholder="Service Price" class="form-control font-weight-bold" name="service_price" id="service_price" required oninput="calculateDiscountValue()">
                    </div>
                    <div class="col-3 mt-3">
                        <label for="service_dis">Service Discount (%)</label>
                        <input type="number" placeholder="Discount Percentage" class="form-control font-weight-bold" name="service_dis" id="service_dis" oninput="calculateDiscountValue()">
                    </div>
                    <div class="col-3 mt-3">
                        <label for="service_dis_value">Discount Value</label>
                        <input type="number" step="0.01" placeholder="Discount Value" class="form-control font-weight-bold" name="service_dis_value" id="service_dis_value" readonly>
                    </div>
                  
                    <div class="col-3 mt-3">
                        <label for="service_image">Service Image</label>
                        <input type="file" class="form-control font-weight-bold" name="service_image" id="service_image" accept="image/*">
                    </div>
                    <div class="col-12 mt-3">
                        <label for="service_description">Service Description</label>
                        <textarea rows="10" name="service_description" id="service_description" rows="3" class="form-control font-weight-bold" placeholder="Enter product description"></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button name="service_create" type="submit" class="btn btn-primary shadow font-weight-bold">
                        <i class="fa fa-save"></i>&nbsp; Create Service
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

<script>
    function calculateDiscountValue() {
        const price = parseFloat(document.getElementById("service_price").value);
        const discountPercentage = parseFloat(document.getElementById("service_dis").value);
        
        if (!isNaN(price) && !isNaN(discountPercentage)) {
            const discountValue = (price * discountPercentage) / 100;
            document.getElementById("service_dis_value").value = discountValue.toFixed(2);
        } else {
            document.getElementById("service_dis_value").value = '';
        }
    }
</script>

<?php include "../component/footer.php"; ?>
