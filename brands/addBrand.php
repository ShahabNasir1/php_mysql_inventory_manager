<?php

include __DIR__ . "/../sessionFile.php";

$pageName = "addBrand";
$addBrand = true;
$baseHref = "../";
include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";
include __DIR__ . "/../includes/adminAccess.php";

if (isset($_POST['submit'])) {
    $errors = [];

    $brandName = trim($_POST['brandName'] ?? '');
    $brandStatus = trim($_POST['brandStatus'] ?? '');

    if (empty($brandName)) {
        $errors[] = "Brand name is required.";
    }
    else if (strlen($brandName) < 3) {
        $errors[] = "Brand name must be at least 3 characters long.";
    }

    if (empty($brandStatus)) {
        $errors[] = "Brand status is required.";
    }

    $safeName = mysqli_real_escape_string($conn, $brandName);
    $existingBrand = "SELECT brand_id FROM brands WHERE brand_name = '$safeName'";
    $check = $conn->query($existingBrand);
    if ($check->num_rows > 0) {
        $errors[] = "This brand already exists.";
    }

     if (empty($errors)) {
        // Safe for SQL
        $brandStatus = mysqli_real_escape_string($conn, $brandStatus);
        
        $sql = "INSERT INTO brands (brand_name, brand_status) VALUES ('$safeName', '$brandStatus')";

        if ($conn->query($sql)) {
            echo "<div class='alert alert-success'>Brand Added Successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Database Error: " . $conn->error . "</div>";
        }
    } else {
        // Display all validation errors
        foreach ($errors as $error) {
            echo "<div class='alert alert-warning'><i class='fa fa-exclamation-triangle'></i> $error</div>";
        }
    }
}
?>

<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Add New Brand</h5>
        </div>
        <div class="ibox-content">
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