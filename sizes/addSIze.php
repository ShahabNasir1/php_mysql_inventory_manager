<?php
include __DIR__ . "/../sessionFile.php";
$pageName = "addSize";
$baseHref = "../";
include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";

$message = "";

if (isset($_POST['submit'])) {
    $sizeName = mysqli_real_escape_string($conn, trim($_POST['sizeName']));
    $sizeStatus = mysqli_real_escape_string($conn, $_POST['sizeStatus']);

    if (empty($sizeName) || empty($sizeStatus)) {
        $message = "<div class='alert alert-warning'>All fields are required.</div>";
    } else {
        // Check if size already exists in the sizes table
        $check = $conn->query("SELECT * FROM sizes WHERE size_name = '$sizeName'");
        
        if ($check->num_rows > 0) {
            $message = "<div class='alert alert-danger'>Size already exists!</div>";
        } else {
            // Updated table to 'sizes' and columns to 'size_name', 'size_status'
            $sql = "INSERT INTO sizes (size_name, size_status) VALUES ('$sizeName', '$sizeStatus')";
            
            try {
                if ($conn->query($sql)) {
                    $message = "<div class='alert alert-success'>Size Added Successfully!</div>";
                }
            } catch (mysqli_sql_exception $e) {
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
            <h5>Add New Size (S, M, L, XL, etc.)</h5>
        </div>
        <div class="ibox-content">
            <form method="POST">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Size Name</label>
                    <div class="col-sm-10">
                        <!-- Example: Small, Medium, Large or 32, 34, 36 -->
                        <input type="text" name="sizeName" class="form-control" placeholder="e.g. XL or 42" required>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Size Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="sizeStatus" required>
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" name="submit">Save Size</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>