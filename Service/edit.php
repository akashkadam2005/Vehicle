<?php
include "../config/connection.php";
include "../component/header.php";
include "../component/sidebar.php";

// Get the product ID from the URL
$service_id = $_GET['service_id'];

// Fetch product details
$productQuery = "SELECT * FROM tbl_product WHERE service_id = $service_id";
$productResult = mysqli_query($conn, $productQuery);
$product = mysqli_fetch_assoc($productResult);

// Check if the form is submitted
if (isset($_POST["service_update"])) {
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
    
    // Handle image upload if a new image is uploaded
    if (!empty($service_image)) {
        $target_dir = "../uploads/products/";
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
        $image_path = $product['service_image']; // Keep existing image if no new one is uploaded
    }

    // Update query
    $updateQuery = "UPDATE tbl_product SET 
        service_name = '$service_name',
        service_description = '$service_description',
        service_price = '$service_price', 
        category_id = '$category_id',
        service_image = '$image_path',
        service_dis = '$service_dis',
        service_dis_value = '$service_dis_value',
        service_status = '$service_status'
        WHERE service_id = $service_id";

    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION["success"] = "Product Updated Successfully!";
        echo "<script>window.location = 'index.php';</script>";
    } else {
        $_SESSION["error"] = "Error updating product: " . mysqli_error($conn);
    }
}
?>

<div class="content-wrapper p-2">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card">
            <div class="card-header">
                <div class="d-flex p-2 justify-content-between">
                    <div class="h5 font-weight-bold">Edit Product</div>
                    <a href="index.php" class="btn btn-info shadow font-weight-bold">
                        <i class="fa fa-eye"></i>&nbsp; Product List
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <label for="service_name">Product Name <span class="text-danger">*</span></label>
                        <input type="text" value="<?= $product['service_name'] ?>" placeholder="Product Name" class="form-control font-weight-bold" name="service_name" id="service_name" required>
                    </div>
                    <div class="col-4">
                        <label for="category_id">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-control font-weight-bold" required>
                            <option value="">Select Category</option>
                            <?php
                            $categoryQuery = "SELECT * FROM tbl_category WHERE category_status = 1";
                            $categoryResult = mysqli_query($conn, $categoryQuery);
                            while ($category = mysqli_fetch_assoc($categoryResult)) {
                                $selected = $product['category_id'] == $category['category_id'] ? "selected" : "";
                                echo "<option value='{$category['category_id']}' $selected>{$category['category_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-2">
                        <label for="service_status">Food Type <span class="text-danger">*</span></label>
                        <select name="service_status" id="service_status" class="form-control font-weight-bold" required>
                            <option value="">Select Food Type</option>
                            <option value="1" <?= $product['service_status'] == 1 ? "selected" : "" ?>>Veg</option>
                            <option value="2" <?= $product['service_status'] == 2 ? "selected" : "" ?>>Non-Veg</option>
                        </select>
                    </div>
                    <div class="col-3 mt-3">
                        <label for="service_price">Product Price <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" value="<?= $product['service_price'] ?>" placeholder="Product Price" class="form-control font-weight-bold" name="service_price" id="service_price" required oninput="calculateDiscountValue()">
                    </div>
                    <div class="col-3 mt-3">
                        <label for="service_dis">Product Discount (%)</label>
                        <input type="number" value="<?= $product['service_dis'] ?>" placeholder="Discount Percentage" class="form-control font-weight-bold" name="service_dis" id="service_dis" oninput="calculateDiscountValue()">
                    </div>
                    <div class="col-3 mt-3">
                        <label for="service_dis_value">Discount Value</label>
                        <input type="number" step="0.01" value="<?= $product['service_dis_value'] ?>" placeholder="Discount Value" class="form-control font-weight-bold" name="service_dis_value" id="service_dis_value" readonly>
                    </div>
                    <div class="col-3 mt-3">
                        <label for="service_image">Product Image</label>
                        <input type="file" class="form-control font-weight-bold" name="service_image" id="service_image" accept="image/*">
                        <?php if (!empty($product['service_image'])): ?>
                            <img src="../uploads/products/<?= $product['service_image'] ?>" alt="Product Image" width="100" class="mt-2">
                        <?php endif; ?>
                    </div>
                    <div class="col-12 mt-3">
                        <label for="service_description">Product Description</label>
                        <textarea rows="10" name="service_description" id="service_description" class="form-control font-weight-bold" placeholder="Enter product description"><?= $product['service_description'] ?></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button name="service_update" type="submit" class="btn btn-primary shadow font-weight-bold">
                        <i class="fa fa-save"></i>&nbsp; Update Product
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
