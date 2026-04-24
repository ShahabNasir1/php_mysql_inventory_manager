<?php

session_start(); // Sabse pehle session shuru karein

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pageName = "addBrand";
$addBrand = true;
$baseHref = "../";
include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";
?>

<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Add New Brand</h5>
        </div>
        <div class="ibox-content">
            <?php
            // BRAND INSERT LOGI
            if (isset($_POST['submit'])) {
                $brandName = mysqli_real_escape_string($conn, $_POST['brandName']);
                $brandStatus = mysqli_real_escape_string($conn, $_POST['brandStatus']);
                $sql = "INSERT INTO brands (brand_name, brand_status) VALUES ('$brandName', '$brandStatus')";
                if ($conn->query($sql)) {
                    echo "<div class='alert alert-success'>Brand Added Successfully!</div>";
                } else {

                    echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
                }
            }
            ?>
            <form id="brandForm" method="POST">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Brand Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="brandName" class="form-control required">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Brand Status</label>
                    <div class="col-sm-10">
                        <select class="form-control required" name="brandStatus">
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
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

