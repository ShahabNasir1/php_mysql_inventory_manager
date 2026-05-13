<?php
include __DIR__ . "/../sessionFile.php";
$pageName = "editProduct";
$editProduct = true;
$baseHref = "../";

include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $productRes = $conn->query("SELECT * FROM products WHERE product_id = '$id'");
    $product = $productRes->fetch_assoc();

    if (!$product) {
        echo "<script>window.location.href='products/listProducts.php';</script>";
        exit;
    }
}

// 1. Fetch all options
$categories = $conn->query("SELECT category_id, category_name FROM categories WHERE category_status = 'active'");
$brands = $conn->query("SELECT brand_id, brand_name FROM brands WHERE brand_status = 'active'");
$all_colors = $conn->query("SELECT color_id, color_name FROM colors WHERE color_status = 'active'");
$all_sizes = $conn->query("SELECT size_id, size_name FROM sizes WHERE size_status = 'active'");

// 2. Fetch current Colors & Sizes
$currentColors = [];
$selColorsQuery = $conn->query("SELECT color_id FROM product_colors WHERE product_id = '$id'");
while ($row = $selColorsQuery->fetch_assoc()) {
    $currentColors[] = $row['color_id'];
}

$currentSizes = [];
$selSizesQuery = $conn->query("SELECT size_id FROM product_sizes WHERE product_id = '$id'");
while ($row = $selSizesQuery->fetch_assoc()) {
    $currentSizes[] = $row['size_id'];
}

// 3. FETCH EXISTING IMAGES
$existingImages = $conn->query("SELECT * FROM product_images WHERE product_id = '$id'");

if (isset($_POST['update'])) {
    $productcategory = mysqli_real_escape_string($conn, $_POST['productCategory']);
    $productBrand    = mysqli_real_escape_string($conn, $_POST['productBrand']);
    $productName     = mysqli_real_escape_string($conn, $_POST['productName']);
    $description     = mysqli_real_escape_string($conn, $_POST['productDescription']);
    $price           = mysqli_real_escape_string($conn, $_POST['price']);
    $productStatus   = mysqli_real_escape_string($conn, $_POST['productStatus']);

    $sql = "UPDATE products SET 
            category_id = '$productcategory', 
            brand_id = '$productBrand', 
            product_name = '$productName', 
            description = '$description', 
            price = '$price', 
            product_status = '$productStatus' 
            WHERE product_id = '$id'";

    if ($conn->query($sql)) {

        // A. Handle Image Deletions
        if (isset($_POST['delete_images'])) {

    foreach ($_POST['delete_images'] as $imgId) {

        $imgId = mysqli_real_escape_string($conn, $imgId);

        $imgQuery = $conn->query("SELECT image_url FROM product_images 
                                  WHERE image_id = '$imgId'");

        if ($imgQuery->num_rows > 0) {

            $imgData = $imgQuery->fetch_assoc();

            // Correct file path
            $filePath = __DIR__ . "/uploads/" . basename($imgData['image_url']);

            // Delete physical image
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete DB record
            $conn->query("DELETE FROM product_images 
                          WHERE image_id = '$imgId'");
        }
    }
}

        // B. Handle New Uploads
        
        if (!empty($_FILES['productPic']['name'][0])) {

            $targetDir = __DIR__ . "/uploads/";

            // Create folder if not exists
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            foreach ($_FILES['productPic']['name'] as $key => $val) {

                if ($_FILES['productPic']['error'][$key] == 0) {

                    $fileExtension = strtolower(pathinfo($_FILES["productPic"]["name"][$key], PATHINFO_EXTENSION));

                    $fileName = time() . "_" . bin2hex(random_bytes(4)) . "." . $fileExtension;

                    $targetFilePath = $targetDir . $fileName;

                    // Save path in DB
                    $dbSavePath = "products/uploads/" . $fileName;

                    if (move_uploaded_file($_FILES["productPic"]["tmp_name"][$key], $targetFilePath)) {

                        $conn->query("INSERT INTO product_images (product_id, image_url)
                              VALUES ('$id', '$dbSavePath')");
                    } else {

                        echo "Upload Failed";
                    }
                }
            }
        }

        // Update Colors & Sizes
        $conn->query("DELETE FROM product_colors WHERE product_id = '$id'");
        if (isset($_POST['colors'])) {
            foreach ($_POST['colors'] as $c_id) {
                $c_id = mysqli_real_escape_string($conn, $c_id);
                $conn->query("INSERT INTO product_colors (product_id, color_id) VALUES ('$id', '$c_id')");
            }
        }

        $conn->query("DELETE FROM product_sizes WHERE product_id = '$id'");
        if (isset($_POST['size'])) {
            foreach ($_POST['size'] as $s_id) {
                $s_id = mysqli_real_escape_string($conn, $s_id);
                $conn->query("INSERT INTO product_sizes (product_id, size_id) VALUES ('$id', '$s_id')");
            }
        }

        echo "<script>window.location.href='products/listProducts.php';</script>";
        exit;
    }
}
?>

<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Edit Product</h5>
        </div>
        <div class="ibox-content">
            <form id="productForm" method="POST" enctype="multipart/form-data">
                <!-- Category & Brand -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Category</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="productCategory" required>
                            <?php while ($cat = $categories->fetch_assoc()): ?>
                                <option value="<?= $cat['category_id']; ?>" <?= ($cat['category_id'] == $product['category_id']) ? 'selected' : ''; ?>>
                                    <?= $cat['category_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label">Brand</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="productBrand" required>
                            <?php while ($brnd = $brands->fetch_assoc()): ?>
                                <option value="<?= $brnd['brand_id']; ?>" <?= ($brnd['brand_id'] == $product['brand_id']) ? 'selected' : ''; ?>>
                                    <?= $brnd['brand_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <!-- Name & Colors -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Product Name</label>
                    <div class="col-sm-4">
                        <input type="text" name="productName" value="<?= htmlspecialchars($product['product_name']); ?>" class="form-control" required>
                    </div>

                    <label class="col-sm-2 col-form-label">Select Colors</label>
                    <div class="col-sm-4">
                        <select class="form-control select2" name="colors[]" multiple="multiple" id="select">
                            <?php
                            $all_colors->data_seek(0);
                            while ($color = $all_colors->fetch_assoc()): ?>
                                <option value="<?= $color['color_id']; ?>" <?= (in_array($color['color_id'], $currentColors)) ? 'selected' : ''; ?>>
                                    <?= $color['color_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Product Sizes</label>
                    <div class="col-sm-10 mt-2">
                        <?php if ($all_sizes->num_rows > 0): ?>
                            <?php
                            $all_sizes->data_seek(0); // Pointer reset
                            while ($size = $all_sizes->fetch_assoc()): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="size[]"
                                        id="size_<?= $size['size_id']; ?>"
                                        value="<?= $size['size_id']; ?>"
                                        <?= (in_array($size['size_id'], $currentSizes)) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="size_<?= $size['size_id']; ?>">
                                        <?= $size['size_name']; ?>
                                    </label>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea name="productDescription" class="form-control" rows="4"><?= htmlspecialchars($product['description'] ?? ''); ?></textarea>
                    </div>
                </div>


                <div class="hr-line-dashed"></div>
                <!-- Images Section -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Current Images</label>
                    <div class="col-sm-10">
                        <div class="row">
                            <?php while ($img = $existingImages->fetch_assoc()): ?>
                                <div class="col-md-2 text-center mb-3" id="img_container_<?= $img['image_id']; ?>">
                                    <img src="/ecommerce/<?= $img['image_url']; ?>" class="img-thumbnail" style="height:100px; width:100px; object-fit:cover;">
                                    <button type="button" class="btn btn-danger btn-xs mt-1 btn-block" onclick="removeImage(<?= $img['image_id']; ?>)">Remove</button>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Add New Pictures</label>
                    <div class="col-sm-10">
                        <!-- Yeh container footer script ke liye lazmi hai -->
                        <div id="image-upload-container"></div>

                        <button class="btn btn-primary btn-sm" type="button" onclick="addNewRow()">
                            <i class="fa fa-plus"></i> Add More Image
                        </button>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <!-- Price & Status -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-4">
                        <input type="number" name="price" value="<?= $product['price']; ?>" class="form-control" required>
                    </div>
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="productStatus" required>
                            <option value="active" <?= ($product['product_status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?= ($product['product_status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <button class="btn btn-primary" type="submit" name="update">
                    <i class="fa fa-save"></i> Update Product
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Remove Existing Image (adds hidden input to tell PHP which image to delete)
    function removeImage(imgId) {
        if (confirm('Are you sure you want to remove this image?')) {
            let container = document.getElementById('img_container_' + imgId);
            if (container) container.remove();

            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete_images[]';
            input.value = imgId;
            document.getElementById('productForm').appendChild(input);
        }
    }
</script>

<?php include __DIR__ . "/../includes/footer.php"; ?>