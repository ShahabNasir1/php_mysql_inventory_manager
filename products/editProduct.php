<?php

session_start(); // Sabse pehle session shuru karein

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pageName = "editProduct";
$baseHref = "../";

include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";

// 1. URL se ID lena aur purana data nikalna
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $productRes = $conn->query("SELECT * FROM products WHERE product_id = '$id'");
    $product = $productRes->fetch_assoc();

    if (!$product) {
        echo "<script>window.location.href='listProducts.php';</script>";
    }
}

// Dropdowns ke liye data fetch karna
$categories = $conn->query("SELECT category_id, category_name FROM categories WHERE category_status = 'active'");
$brands = $conn->query("SELECT brand_id, brand_name FROM brands WHERE brand_status = 'active'");
?>

<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title"><h5>Edit Product</h5></div>
        <div class="ibox-content">
            <?php
            if (isset($_POST['update'])) {
                $productcategory = mysqli_real_escape_string($conn, $_POST['productCategory']);
                $productBrand    = mysqli_real_escape_string($conn, $_POST['productBrand']);
                $productName     = mysqli_real_escape_string($conn, $_POST['productName']);
                $description     = mysqli_real_escape_string($conn, $_POST['productDescription']);
                $price           = mysqli_real_escape_string($conn, $_POST['price']);
                $productStatus   = mysqli_real_escape_string($conn, $_POST['productStatus']);

                // Image Handle Karna
                if (!empty($_FILES["productPic"]["name"])) {
                    $targetDir = "uploads/";
                    $targetFilePath = $targetDir . time() . "_" . basename($_FILES["productPic"]["name"]);
                    move_uploaded_file($_FILES["productPic"]["tmp_name"], $targetFilePath);
                    $imageSql = ", product_image = '$targetFilePath'";
                } else {
                    $imageSql = ""; // Agar nayi image nahi upload ki to purani hi rahegi
                }

                $sql = "UPDATE products SET 
                        category_id = '$productcategory', 
                        brand_id = '$productBrand', 
                        product_name = '$productName', 
                        description = '$description', 
                        price = '$price', 
                        product_status = '$productStatus' 
                        $imageSql 
                        WHERE product_id = '$id'";

                if ($conn->query($sql)) {
                     echo "<script>window.location.href='products/listProducts.php';</script>";
        exit;
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
                }
            }
            ?>

            <form id="productForm" method="POST" enctype="multipart/form-data">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Category</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="productCategory" required>
                            <?php while ($cat = $categories->fetch_assoc()): ?>
                                <option value="<?= $cat['category_id']; ?>" <?= ($cat['category_id'] == $product['category_id']) ? 'selected' : ''; ?>>
                                    <?= $cat['category_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Brand</label>
                    <div class="col-sm-10">
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

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Product Name</label>
                    <div class="col-sm-10"><input type="text" name="productName" value="<?= $product['product_name']; ?>" class="form-control" required></div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10"><input type="text" name="productDescription" value="<?= $product['description']; ?>" class="form-control"></div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Current Picture</label>
                    <div class="col-sm-10">
                        <img src="<?= $product['product_image']; ?>" width="100" class="img-thumbnail mb-2"><br>
                        <input type="file" name="productPic" class="form-control">
                        <small class="text-muted">Nayi image sirf tab select karein agar purani badalni ho.</small>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-10"><input type="number" name="price" value="<?= $product['price']; ?>" class="form-control" required></div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
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
<?php include __DIR__ . "/../includes/footer.php"; ?>