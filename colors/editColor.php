<?php 
include __DIR__ . "/../sessionFile.php";

$pageName = "editColor";
$editColor = true;
$baseHref = "../";

include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";
$baseHref = "../";

// 1. Properly get the ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "<div class='alert alert-danger'>Error: Valid Color ID is missing.</div>";
    include __DIR__ . "/../includes/footer.php";
    exit;
}

// 2. UPDATE LOGIC
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['color_name']);
    // Fixed: Changed 'color_status' to match the select name below or vice versa
    $status = mysqli_real_escape_string($conn, $_POST['color_status']);

    $updateSql = "UPDATE colors 
                  SET color_name = '$name', 
                      color_status = '$status' 
                  WHERE color_id = $id";

    if (mysqli_query($conn, $updateSql)) {
        // Updated redirect path to colors/listColors.php
        echo "<script>window.location.href='colors/listColors.php';</script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// 3. FETCH DATA
$fetchSql = "SELECT * FROM colors WHERE color_id = $id";
$res = mysqli_query($conn, $fetchSql);
$colorData = mysqli_fetch_assoc($res); // Renamed to $colorData for clarity

if (!$colorData) {
    echo "<div class='alert alert-danger'>Error: Color not found.</div>";
    include __DIR__ . "/../includes/footer.php";
    exit;
}
?>

<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Edit Color: <?php echo htmlspecialchars($colorData['color_name']); ?></h5>
        </div>

        <div class="ibox-content">
            <form id="colorForm" method="POST">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Updated Color Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="color_name" class="form-control" 
                               value="<?php echo htmlspecialchars($colorData['color_name']); ?>" required>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Updated Color Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="color_status">
                            <!-- Fixed: Changed 'brand_status' to 'color_status' -->
                            <option value="active" <?php echo ($colorData['color_status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($colorData['color_status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit" name="submit">
                            <i class="fa fa-check"></i> Save Changes
                        </button>
                        <!-- Fixed: Corrected redirect path for Cancel button -->
                        <a href="listColors.php" class="btn btn-white">Cancel</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>