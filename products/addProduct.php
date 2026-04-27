<?php

include __DIR__ . "/../sessionFile.php";
$pageName = "addProduct";
$addCategory = true;
$baseHref = "../";

include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";

$readCategories = "SELECT category_id, category_name FROM categories WHERE category_status = 'active'";
$readBrands = "SELECT brand_id, brand_name FROM brands WHERE brand_status = 'active'";


$categories = $conn->query($readCategories);
$brands = $conn->query($readBrands); // Assuming 1 is active for brands

if (isset($_POST['submit'])) {
    $productcategory = mysqli_real_escape_string($conn, $_POST['productCategory']);
    $productBrand    = mysqli_real_escape_string($conn, $_POST['productBrand']);
    $productName     = mysqli_real_escape_string($conn, $_POST['productName']);
    $description     = mysqli_real_escape_string($conn, $_POST['productDescription']);
    $price           = mysqli_real_escape_string($conn, $_POST['price']);
    $productStatus   = mysqli_real_escape_string($conn, $_POST['productStatus']);

  
    // --- FILE UPLOAD LOGIC ---
    $targetDir = "uploads/";
    $fileName  = basename($_FILES["productPic"]["name"]);
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $uniqueName = time() . "_" . $fileName;

    $targetFilePath = $targetDir . $uniqueName;
    $thumbFilePath  = $targetDir . "thumb_" . $uniqueName; // Path for the 50x50 copy

    if (move_uploaded_file($_FILES["productPic"]["tmp_name"], $targetFilePath)) {

        // --- RESIZE LOGIC (50x50) ---
        // 1. Create image resource based on file type
        if ($extension == 'jpg' || $extension == 'jpeg') {
            $srcImage = imagecreatefromjpeg($targetFilePath);
        } elseif ($extension == 'png') {
            $srcImage = imagecreatefrompng($targetFilePath);
        } elseif ($extension == 'gif') {
            $srcImage = imagecreatefromgif($targetFilePath);
        }

        if ($srcImage) {
            // 2. Create a blank 50x50 canvas
            $thumbnail = imagecreatetruecolor(50, 50);

            // 3. Handle transparency for PNGs/GIFs
            if ($extension == 'png' || $extension == 'gif') {
                imagealphablending($thumbnail, false);
                imagesavealpha($thumbnail, true);
            }

            // 4. Resize original into the 50x50 canvas
            list($width, $height) = getimagesize($targetFilePath);
            imagecopyresampled($thumbnail, $srcImage, 0, 0, 0, 0, 50, 50, $width, $height);

            // 5. Save the thumbnail
            if ($extension == 'jpg' || $extension == 'jpeg') {
                imagejpeg($thumbnail, $thumbFilePath, 90);
            } elseif ($extension == 'png') {
                imagepng($thumbnail, $thumbFilePath);
            } elseif ($extension == 'gif') {
                imagegif($thumbnail, $thumbFilePath);
            }

            // 6. Clean up memory
            imagedestroy($srcImage);
            imagedestroy($thumbnail);
        }

        // Save the original path/filename to the database
        $sql = "INSERT INTO products (category_id, brand_id, product_name, description, product_image, price, product_status) 
            VALUES ('$productcategory', '$productBrand', '$productName', '$description', '$targetFilePath', '$price', '$productStatus')";

        if ($conn->query($sql)) {
            echo "<div class='alert alert-success'>Product and Thumbnail Added Successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
    }
}


?>



<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Add New Product</h5>
        </div>
        <div class="ibox-content">
            <form id="productForm" method="POST" enctype="multipart/form-data">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Product's Category</label>
                    <div class="col-sm-10">
                        <select class="form-control required" name="productCategory">
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
                        <select class="form-control required" name="productBrand">
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
                    <div class="col-sm-10"><input type="text" name="productName" class="form-control required"></div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10"><input type="text" name="productDescription" class="form-control required"></div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Product's Picture</label>
                    <div class="col-sm-10"><input type="file" name="productPic" class="form-control required"></div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-10"><input type="number" name="price" class="form-control required"></div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Product Status</label>
                    <div class="col-sm-10">
                        <select class="form-control required" name="productStatus">
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