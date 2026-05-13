<?php
include __DIR__ . "/../sessionFile.php";
$pageName = "addProduct";
$addProduct = true;
$baseHref = "../";

include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";

// 1. Fetch Categories
$categories = $conn->query("SELECT category_id, category_name FROM categories WHERE category_status = 'active'");
// 2. Fetch Brands
$brands = $conn->query("SELECT brand_id, brand_name FROM brands WHERE brand_status = 'active'");
// 3. Fetch Colors
$colors_list = $conn->query("SELECT color_id, color_name FROM colors WHERE color_status = 'active'");
// 4. Fetch Sizes
$sizes_list = $conn->query("SELECT size_id, size_name FROM sizes WHERE size_status = 'active'");

$user_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {
    $productcategory = mysqli_real_escape_string($conn, $_POST['productCategory']);
    $productBrand    = mysqli_real_escape_string($conn, $_POST['productBrand']);
    $productName     = mysqli_real_escape_string($conn, $_POST['productName']);
    $description     = mysqli_real_escape_string($conn, $_POST['productDescription']);
    $price           = mysqli_real_escape_string($conn, $_POST['price']);
    $productStatus   = mysqli_real_escape_string($conn, $_POST['productStatus']);

    $sql = "INSERT INTO products (category_id, brand_id, product_name, description, price, product_status, user_id) 
            VALUES ('$productcategory', '$productBrand', '$productName', '$description', '$price', '$productStatus', '$user_id')";

    if ($conn->query($sql)) {
        $new_product_id = $conn->insert_id;

        // --- FIXED IMAGE UPLOAD FOR YOUR SPECIFIC FOLDER PATH ---
        if (!empty($_FILES['productPic']['name'][0])) {
            // "uploads/" kyunke aap addProduct.php se uploads folder ko direct access kar rahe hain
            $uploadDir = "uploads/"; 

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($_FILES['productPic']['name'] as $key => $val) {
                if ($_FILES['productPic']['error'][$key] == 0) {
                    $originalName = basename($_FILES['productPic']['name'][$key]);
                    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                    
                    $fileName = time() . "_" . bin2hex(random_bytes(4)) . "." . $fileExtension;
                    $targetFilePath = $uploadDir . $fileName;

                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
                    if (in_array($fileExtension, $allowTypes)) {
                        if (move_uploaded_file($_FILES['productPic']['tmp_name'][$key], $targetFilePath)) {
                            // Database mein products/ ke hisaab se path save hoga
                            $db_path = "products/uploads/" . $fileName; 
                            $imgSql = "INSERT INTO product_images (product_id, image_url) VALUES ('$new_product_id', '$db_path')";
                            $conn->query($imgSql);
                        }
                    }
                }
            }
        }
        // --- END FIXED SECTION ---

        if (!empty($_POST['colors'])) {
            foreach ($_POST['colors'] as $c_id) {
                $c_id = mysqli_real_escape_string($conn, $c_id);
                $conn->query("INSERT INTO product_colors (product_id, color_id) VALUES ('$new_product_id', '$c_id')");
            }
        }
        if (!empty($_POST['size'])) {
            foreach ($_POST['size'] as $s_id) {
                $s_id = mysqli_real_escape_string($conn, $s_id);
                $conn->query("INSERT INTO product_sizes (product_id, size_id) VALUES ('$new_product_id', '$s_id')");
            }
        }
        echo "<div class='alert alert-success'>Product uploaded successfully!</div>";
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
                    <label class="col-sm-2 col-form-label">Category</label>
                    <div class="col-sm-4">
                        <select class="form-control required" name="productCategory">
                            <option value="">Select Category</option>
                            <?php while ($row = $categories->fetch_assoc()): ?>
                                <option value="<?= $row['category_id']; ?>"><?= $row['category_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label">Brand</label>
                    <div class="col-sm-4">
                        <select class="form-control required" name="productBrand">
                            <option value="">Select Brand</option>
                            <?php while ($row = $brands->fetch_assoc()): ?>
                                <option value="<?= $row['brand_id']; ?>"><?= $row['brand_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Product Name</label>
                    <div class="col-sm-4"><input type="text" name="productName" class="form-control required"></div>
                    <label for="select2Input" class="col-sm-2 col-form-label">Select Colors</label>
                    <div class="col-sm-4">
                        <select class="form-control select2" name="colors[]" multiple="multiple" id="select">
                            <?php while ($color = $colors_list->fetch_assoc()): ?>
                                <option value="<?= $color['color_id']; ?>"><?= $color['color_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Product Sizes</label>
                    <div class="col-sm-10 mt-2">
                        <?php if ($sizes_list->num_rows > 0): ?>
                            <?php while ($size = $sizes_list->fetch_assoc()): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="size[]" id="size_<?= $size['size_id']; ?>" value="<?= $size['size_id']; ?>">
                                    <label class="form-check-label" for="size_<?= $size['size_id']; ?>"><?= $size['size_name']; ?></label>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-4">
                        <textarea name="productDescription" class="form-control required" rows="1"></textarea>
                    </div>

                    <label class="col-sm-2 col-form-label">Product's Picture</label>
                    <div class="col-sm-4">
                        <div id="image-upload-container">
                            <div class="img-input-row mb-3">
                                <div class="img-input-group">
                                    <div class="preview-wrapper" style="display:none; position:relative; margin-bottom:10px;">
                                        <img class="img-preview" src="#" style="width:120px; height:120px; object-fit:cover; border:1px solid #ddd; border-radius:5px;">
                                        <button type="button" class="btn btn-danger btn-xs"
                                            style="position:absolute; top:-5px; left:105px; border-radius:50%; padding:2px 6px;"
                                            onclick="let row = this.closest('.img-input-row'); row.querySelector('input[type=file]').value = ''; row.querySelector('.preview-wrapper').style.display = 'none';">
                                            x
                                        </button>
                                    </div>
                                    <div class="input-group" style="width: 300px;">
                                        <input type="file" name="productPic[]" class="form-control" onchange="updatePreview(this)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm mt-2" type="button" onclick="addNewRow()">
                            <i class="fa fa-plus"></i> Add Image
                        </button>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-4"><input type="number" name="price" class="form-control required"></div>
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-4">
                        <select class="form-control required" name="productStatus">
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