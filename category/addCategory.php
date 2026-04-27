<?php 

include __DIR__ . "/../sessionFile.php";

$pageName = "addCategory";
$addCategory = true;
$baseHref = "../";

include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";
?>

<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Add New category</h5>
        </div>
        <div class="ibox-content">
            <?php
            // BRAND INSERT LOGI
            if (isset($_POST['submit'])) {
                $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
                $categoryStatus = mysqli_real_escape_string($conn, $_POST['categoryStatus']);
                
                $sql = "INSERT INTO categories (category_name, category_status) VALUES ('$categoryName', '$categoryStatus')";
            
                if ($conn->query($sql)) {
                    echo "<div class='alert alert-success'>Category Added Successfully!</div>";
                } else {

                    echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
                }
            }
            ?>
            <form id="categoryForm" method="POST">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Category Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="categoryName" class="form-control required">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Category Status</label>
                    <div class="col-sm-10">
                        <select class="form-control required" name="categoryStatus">
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group row">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit" name="submit">
                            <i class="fa fa-check"></i>&nbsp;Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>