<?php 
include __DIR__ . "/../sessionFile.php";

$pageName = "editCategory";
$editCategory = true;
$baseHref = "../";

include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";
include __DIR__ . "/../includes/adminAccess.php";

// 1. Properly get the ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "<div class='alert alert-danger'>Error: Valid Category ID is missing.</div>";
    include __DIR__ . "/../includes/footer.php";
    exit;
}

// 2. UPDATE LOGIC
if (isset($_POST['submit'])) {
    $errors = [];
    
    // Sanitize inputs
    $name = trim($_POST['categoryName'] ?? '');
    $status = trim($_POST['categoryStatus'] ?? '');

    // --- VALIDATION RULES ---
    if (empty($name)) {
        $errors[] = "Category Name is required.";
    } elseif (strlen($name) < 3) {
        $errors[] = "Category Name must be at least 3 characters long.";
    }

    if (empty($status)) {
        $errors[] = "Please select a status (Active/Inactive).";
    }

    // Check if the NEW name already exists in ANOTHER category
    $safeName = mysqli_real_escape_string($conn, $name);
    $checkDuplicate = $conn->query("SELECT category_id FROM categories WHERE category_name = '$safeName' AND category_id != $id");
    if ($checkDuplicate->num_rows > 0) {
        $errors[] = "A different category with this name already exists.";
    }

    // --- EXECUTION ---
    if (empty($errors)) {
        $safeStatus = mysqli_real_escape_string($conn, $status);
        
        $updateSql = "UPDATE categories 
                      SET category_name = '$safeName', 
                          category_status = '$safeStatus' 
                      WHERE category_id = $id";

        if (mysqli_query($conn, $updateSql)) {
            // Success! Using session to carry message across redirect
            $_SESSION['msg'] = ["type" => "success", "text" => "Category updated successfully!"];
            echo "<script>window.location.href='category/listCategories.php';</script>";
            exit;
        } else {
            $errors[] = "Database Error: " . mysqli_error($conn);
        }
    }
    
    // If there were errors, store them in the session to show after reload
    if (!empty($errors)) {
        $_SESSION['msg'] = ["type" => "danger", "text" => implode("<br>", $errors)];
        // Reload page to clear POST and show session errors
        echo "<script>window.location.href='category/editCategory.php?id=$id';</script>";
        exit;
    }
}

// 3. FETCH DATA
$fetchSql = "SELECT * FROM categories WHERE category_id = $id";
$res = mysqli_query($conn, $fetchSql);
$cat = mysqli_fetch_assoc($res);

if (!$cat) {
    echo "<div class='alert alert-danger'>Error: Category not found.</div>";
    include __DIR__ . "/../includes/footer.php";
    exit;
}
?>

<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title"><h5>Edit Category</h5></div>
        <div class="ibox-content">
            
            <?php if (isset($_SESSION['msg'])): ?>
                <div class="alert alert-<?= $_SESSION['msg']['type']; ?> alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <?= $_SESSION['msg']['text']; ?>
                </div>
                <?php unset($_SESSION['msg']); ?>
            <?php endif; ?>

            <form id="categoryForm" method="POST">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Category Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="categoryName" value="<?= htmlspecialchars($cat['category_name']); ?>" class="form-control">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Category Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="categoryStatus">
                            <option value="active" <?= ($cat['category_status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?= ($cat['category_status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <button class="btn btn-primary" type="submit" name="submit">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>