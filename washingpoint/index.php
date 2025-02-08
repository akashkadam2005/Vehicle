<?php
include "../config/connection.php";
include "../component/header.php";
include "../component/sidebar.php";

?>

<div class="content-wrapper p-2">
    <div class="card">
        <div class="card-header">
            <div class="text-center p-3">
                <h3 class="font-weight-bold">Washing Point Management</h3>
            </div>
            <form action="" method="get">
                <div class="row justify-content-end">
                    <div class="col-2 font-weight-bold">
                        City Name
                        <select name="washing_city_id" class="form-control font-weight-bold">
                            <option value="">Select City</option>
                            <?php
                            $cityResult = mysqli_query($conn, "SELECT * FROM tbl_city");
                            while ($city = mysqli_fetch_assoc($cityResult)) {
                                echo "<option value='" . $city['city_id'] . "'>" . $city['city_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-1 font-weight-bold">
                        <br>
                        <button type="submit" class="shadow btn w-100 btn-info font-weight-bold"> <i class="fas fa-search"></i> &nbsp;Find</button>
                    </div>
                    <div class="col-2 font-weight-bold">
                        <br>
                        <a href="create.php" class="font-weight-bold w-100 shadow btn btn-success"> <i class="fas fa-plus"></i>&nbsp; Add Washing Point</a>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>City Name</th>
                        <th>Location</th>
                        <th>Landmark</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $whereClause = "";
                    if (isset($_GET['washing_city_id']) && !empty($_GET['washing_city_id'])) {
                        $city_id = $_GET['washing_city_id'];
                        $whereClause = "WHERE washing_city_id = $city_id";
                    }

                    $query = "SELECT wp.*, c.city_name FROM tbl_washing_point wp LEFT JOIN tbl_city c ON wp.washing_city_id = c.city_id $whereClause";
                    $result = mysqli_query($conn, $query);
                    $count = 0;

                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?= ++$count ?></td>
                            <td><?= $data["city_name"] ?></td>
                            <td><?= $data["washing_location"] ?></td>
                            <td><?= $data["washing_landmark"] ?></td>
                            <td><?= $data["washing_status"] == 1 ? 'Active' : 'Inactive' ?></td>
                            <td>
                                <a href="edit.php?washing_id=<?= $data['washing_id'] ?>" class="btn btn-sm shadow btn-info">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <a href="delete.php?washing_id=<?= $data['washing_id'] ?>" onclick="if(confirm('Are you sure want to delete this washing point?')){return true}else{return false;}" class="btn btn-sm shadow btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include "../component/footer.php";
?>
