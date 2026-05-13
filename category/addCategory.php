<?php

include __DIR__ . "/../sessionFile.php";

$pageName = "addCategory";
$addCategory = true;
$baseHref = "../";

include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";
include __DIR__ . "/../includes/adminAccess.php";
include __DIR__ . "/../serverValidation.php";


if (isset($_POST['submit'])) {
    $errors = [];

    // Taking the data
    $categoryName = $_POST['categoryName'];
    $categoryStatus = $_POST['categoryStatus'];

    // Name Validation - empty check and length check parameters are category name aur minimum length 3 characters
    $nameCheck = validateText($categoryName, 3);
    if ($nameCheck !== true) {
        $errors[] = "Category Name: " . $nameCheck;
    }
    // Duplicate check karein
    elseif (isDuplicate($conn, 'categories', 'category_name', $categoryName)) {
        $errors[] = "This category already exists.";
    }

    // Status Check
    if (empty($categoryStatus)) {
        $errors[] = "Please select a category status.";
    }

    // If no errors then insert the records
    if (empty($errors)) {
        $data = [
            "category_name" => $categoryName,
            "category_status" => $categoryStatus
        ];
        
        insertRecord($conn, 'categories', $data);
    }
    else {
        // Display all errors at once
        displayAlert($errors, "warning");
    }
}
?>

<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Add New category</h5>
        </div>
        <div class="ibox-content">

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