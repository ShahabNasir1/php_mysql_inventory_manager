<?php
include __DIR__ . "/../sessionFile.php";
$pageName = "addColor";
$baseHref = "../";
include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";

$message = "";

if (isset($_POST['submit'])) {
    $colorName = mysqli_real_escape_string($conn, trim($_POST['colorName']));
    $colorStatus = mysqli_real_escape_string($conn, $_POST['colorStatus']);

    if (empty($colorName) || empty($colorStatus)) {
        $message = "<div class='alert alert-warning'>All fields are required.</div>";
    } else {
        // Check if color exists
        $check = $conn->query("SELECT * FROM colors WHERE color_name = '$colorName'");
        
        if ($check->num_rows > 0) {
            $message = "<div class='alert alert-danger'>Color already exists!</div>";
        } else {
            // Ensure 'color_status' is the EXACT name in your DB
            $sql = "INSERT INTO colors (color_name, color_status) VALUES ('$colorName', '$colorStatus')";
            
            try {
                if ($conn->query($sql)) {
                    $message = "<div class='alert alert-success'>Color Added Successfully!</div>";
                }
            } catch (mysqli_sql_exception $e) {
                // This will catch the "Unknown column" error specifically
                $message = "<div class='alert alert-danger'>SQL Error: " . $e->getMessage() . "</div>";
            }
        }
    }
}
?>

<div class="col-lg-12">
    <?= $message; ?>
    <div class="ibox">
        <div class="ibox-title">
            <h5>Add New Color (ENUM Support)</h5>
        </div>
        <div class="ibox-content">
            <form method="POST">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Color Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="colorName" class="form-control" required>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Color Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="colorStatus" required>
                            <option value="">Select Status</option>
                            <!-- These values MUST match your ENUM options in DB -->
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" name="submit">Save Color</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>