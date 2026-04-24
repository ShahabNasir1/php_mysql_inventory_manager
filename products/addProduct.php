<?php

session_start(); // Sabse pehle session shuru karein

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pageName = "addProduct";
$addCategory = true;
$baseHref = "../";

include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";


$categories = $conn->query("SELECT category_id, category_name FROM categories WHERE category_status = 'active'");
$brands = $conn->query("SELECT brand_id, brand_name FROM brands WHERE brand_status = 'active'"); // Assuming 1 is active for brands
?>

<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Add New Product</h5>
        </div>
        <div class="ibox-content">
            <?php
            if (isset($_POST['submit'])) {
                $productcategory = mysqli_real_escape_string($conn, $_POST['productCategory']);
                $productBrand    = mysqli_real_escape_string($conn, $_POST['productBrand']);
                $productName     = mysqli_real_escape_string($conn, $_POST['productName']);
                $description     = mysqli_real_escape_string($conn, $_POST['productDescription']);
                $price           = mysqli_real_escape_string($conn, $_POST['price']);
                $productStatus   = mysqli_real_escape_string($conn, $_POST['productStatus']);

                // --- FILE UPLOAD LOGIC ---
                $targetDir = "uploads/"; // Make sure this folder exists!
                $fileName  = basename($_FILES["productPic"]["name"]);
                $targetFilePath = $targetDir . time() . "_" . $fileName; // Add timestamp to prevent overwriting

                if (move_uploaded_file($_FILES["productPic"]["tmp_name"], $targetFilePath)) {
                    // Save the path/filename to the database
                    $sql = "INSERT INTO products (category_id, brand_id, product_name, description, product_image, price, product_status) 
                            VALUES ('$productcategory', '$productBrand', '$productName', '$description', '$targetFilePath', '$price', '$productStatus')";

                    if ($conn->query($sql)) {
                        echo "<div class='alert alert-success'>Product Added Successfully!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
                }
            }
            ?>

            <form id="productForm" method="POST" enctype="multipart/form-data">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Product's Category</label>
                    <div class="col-sm-10">
                        <select class="form-control required" name="productCategory" >
                            <option value="">Select Category</option>
                            <?php while ($row = $categories->fetch_assoc()): ?>
                                <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Product's Brand</label>
                    <div class="col-sm-10">
                        <select class="form-control required" name="productBrand" >
                            <option value="">Select Brand</option>
                            <?php while ($row = $brands->fetch_assoc()): ?>
                                <option value="<?php echo $row['brand_id']; ?>"><?php echo $row['brand_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Product Name</label>
                    <div class="col-sm-10"><input type="text" name="productName" class="form-control required" ></div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10"><input type="text" name="productDescription" class="form-control required"></div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Product's Picture</label>
                    <div class="col-sm-10"><input type="file" name="productPic" class="form-control required" ></div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-10"><input type="number" name="price" class="form-control required" ></div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Product Status</label>
                    <div class="col-sm-10">
                        <select class="form-control required" name="productStatus" >
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <button class="btn btn-primary" type="submit" name="submit">
                    <i class="fa fa-check"></i> Add Product
                </button>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . "/../includes/footer.php"; ?>