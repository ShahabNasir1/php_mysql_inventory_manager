<?php 

session_start(); // Sabse pehle session shuru karein

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pageName = "editCategory";
$editCategory = true;
$baseHref = "../";

include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";

// 1. Properly get the ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "<div class='alert alert-danger'>Error: Valid Category ID is missing.</div>";
    include __DIR__ . "/../includes/footer.php";
    exit;
}

// 2. UPDATE LOGIC
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $status = mysqli_real_escape_string($conn, $_POST['category_status']);

    // Changed 'id' to 'category_id' to match your database
    $updateSql = "UPDATE categories 
                  SET category_name = '$name', 
                      category_status = '$status' 
                  WHERE category_id = $id";

    if (mysqli_query($conn, $updateSql)) {
        echo "<script>window.location.href='category/listCategories.php';</script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// 3. FETCH DATA (Changed 'id' to 'category_id' here too)
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
        <div class="ibox-title">
            <h5>Edit Category: <?php echo htmlspecialchars($cat['category_name']); ?></h5>
        </div>

        <div class="ibox-content">
            <form id="categoryForm" method="POST">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Updated Category Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="category_name" class="form-control" 
                               value="<?php echo htmlspecialchars($cat['category_name']); ?>" required>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Updated Category Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="category_status">
                            <option value="active" <?php echo ($cat['category_status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($cat['category_status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit" name="submit">
                            <i class="fa fa-check"></i> Save Changes
                        </button>
                        <a href="listCategories.php" class="btn btn-white">Cancel</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>