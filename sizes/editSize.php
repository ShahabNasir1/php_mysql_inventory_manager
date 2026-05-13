<?php 
include __DIR__ . "/../sessionFile.php";

$pageName = "editSize";
$editSize = true;
$baseHref = "../";

include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";

// 1. Properly get the ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "<div class='alert alert-danger'>Error: Valid Size ID is missing.</div>";
    include __DIR__ . "/../includes/footer.php";
    exit;
}

// 2. UPDATE LOGIC
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['size_name']);
    $status = mysqli_real_escape_string($conn, $_POST['size_status']);

    // Updated to sizes table and size_id column
    $updateSql = "UPDATE sizes 
                  SET size_name = '$name', 
                      size_status = '$status' 
                  WHERE size_id = $id";

    if (mysqli_query($conn, $updateSql)) {
        // Redirect back to the size list
        echo "<script>window.location.href='sizes/listSizes.php';</script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// 3. FETCH DATA
$fetchSql = "SELECT * FROM sizes WHERE size_id = $id";
$res = mysqli_query($conn, $fetchSql);
$sizeData = mysqli_fetch_assoc($res);

if (!$sizeData) {
    echo "<div class='alert alert-danger'>Error: Size not found.</div>";
    include __DIR__ . "/../includes/footer.php";
    exit;
}
?>

<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Edit Size: <?php echo htmlspecialchars($sizeData['size_name']); ?></h5>
        </div>

        <div class="ibox-content">
            <form id="sizeForm" method="POST">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Updated Size Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="size_name" class="form-control" 
                               value="<?php echo htmlspecialchars($sizeData['size_name']); ?>" required>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Updated Size Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="size_status">
                            <option value="active" <?php echo ($sizeData['size_status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($sizeData['size_status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit" name="submit">
                            <i class="fa fa-check"></i> Save Changes
                        </button>
                        <a href="listSizes.php" class="btn btn-white">Cancel</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>