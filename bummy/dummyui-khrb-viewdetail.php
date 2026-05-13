<?php
include_once __DIR__ . "/config.php";
include_once __DIR__ . "/sessionFile.php";
include_once __DIR__ . "/viewIncludes/header.php";

// 1. URL se ID uthana aur Database se data fetch karna
$p_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT p.*, b.brand_name, c.category_name,
        (SELECT GROUP_CONCAT(cl.color_name) 
         FROM product_colors pc 
         JOIN colors cl ON pc.color_id = cl.color_id 
         WHERE pc.product_id = p.product_id) as product_colors,
        (SELECT GROUP_CONCAT(sz.size_name) 
         FROM product_sizes ps 
         JOIN sizes sz ON ps.size_id = sz.size_id 
         WHERE ps.product_id = p.product_id) as product_sizes
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.brand_id 
        LEFT JOIN categories c ON p.category_id = c.category_id
        WHERE p.product_id = $p_id";

$res = $conn->query($sql);
$product = $res->fetch_assoc();

// Agar product nahi milta
if (!$product) {
    echo "<div class='container py-5 text-center'><h3>Product not found!</h3><a href='view.php' class='btn btn-primary'>Back to Shop</a></div>";
    include __DIR__ . "/viewIncludes/footer.php";
    exit;
}

// 2. Images fetch karna
$imgSql = "SELECT image_url FROM product_images WHERE product_id = $p_id";
$imgRes = $conn->query($imgSql);
$images = [];
while ($row = $imgRes->fetch_assoc()) {
    $images[] = $row['image_url'];
}

// Agar koi image nahi hai toh placeholder dikhayen
if (empty($images)) {
    $images[] = 'assets/img/placeholder.jpg';
}
?>

<link rel="stylesheet" href="viewIncludes/viewDetail.css" />

<style>
    /* Listing page ke elements hide karne ke liye */
    .page-title,
    #productsGrid,
    #noResults {
        display: none !important;
    }

    .main-content {
        background: transparent !important;
        padding: 0 !important;
    }
</style>

<div class="product-detail-wrapper">
    <div class="product-card">
        <div class="row g-0">

            <div class="col-lg-5 col-md-6 img-col">
                <div class="main-carousel-wrap">
                    <div id="mainCarousel" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner">
                            <?php foreach ($images as $index => $img): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img src="<?= htmlspecialchars($img) ?>"
                                        alt="<?= htmlspecialchars($product['product_name']) ?>"
                                        data-bs-toggle="modal" data-bs-target="#zoomModal" class="img-fluid" />
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if (count($images) > 1): ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="thumb-strip" id="thumbStrip">
                    <?php foreach ($images as $index => $img): ?>
                        <div class="thumb <?= $index === 0 ? 'active' : '' ?>" data-idx="<?= $index ?>">
                            <img src="<?= htmlspecialchars($img) ?>" alt="thumb">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-lg-7 col-md-6 info-col ps-lg-5">
                <h1 class="product-title">
                    <?= htmlspecialchars($product['product_name']) ?>
                </h1>

                <div class="price-row">
                    <span class="price-now">PKR <?= number_format($product['price'], 2) ?></span>
                    <?php if (isset($product['old_price']) && $product['old_price'] > 0): ?>
                        <span class="price-old">PKR <?= number_format($product['old_price'], 2) ?></span>
                    <?php endif; ?>
                </div>

                <table class="meta-table">
                    <tr>
                        <td class="label">Brand:</td>
                        <td class="value"><?= htmlspecialchars($product['brand_name'] ?? 'General') ?></td>
                    </tr>
                    <tr>
                        <td class="label">Category:</td>
                        <td class="value"><?= htmlspecialchars($product['category_name'] ?? 'Uncategorized') ?></td>
                    </tr>
                    <tr>
                        <td class="label">Product ID:</td>
                        <td class="value"><?= $product['product_id'] ?></td>
                    </tr>
                    <tr>
                        <td class="label">Available Colors:</td>
                        <td class="value">
                            <div class="d-flex flex-wrap gap-2">
                                <?php
                                if (!empty($product['product_colors'])) {
                                    // Comma separated colors ko array mein badalna
                                    $colorArray = explode(',', $product['product_colors']);
                                    foreach ($colorArray as $color) {
                                        $colorName = trim($color);
                                ?>
                                        <div class="d-flex align-items-center border rounded-pill px-2 py-1 bg-light" style="font-size: 0.85rem;">
                                            <span style="width: 12px; height: 12px; background-color: <?= $colorName ?>; border-radius: 50%; display: inline-block; margin-right: 6px; border: 1px solid #ddd;"></span>
                                            <?= htmlspecialchars($colorName) ?>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo '<span class="text-muted">No colors available</span>';
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Sizes:</td>
                        <td class="value">
                            <div class="d-flex flex-wrap gap-2">
                                <?php
                                if (!empty($product['product_sizes'])) {
                                    $sizes = explode(',', $product['product_sizes']);
                                    foreach ($sizes as $s) {
                                        echo "<span class='size-badge'>" . htmlspecialchars(trim($s)) . "</span>";
                                    }
                                } else {
                                    echo "<span class='text-muted'>No Sizes</span>";
                                }
                                ?>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Status:</td>
                        <td class="value">
                            <span class="badge bg-<?= ($product['product_status'] == 'active') ? 'success' : 'danger' ?>">
                                <?= ucfirst($product['product_status']) ?>
                            </span>
                        </td>
                    </tr>
                </table>

                <div class="qty-label">Quantity</div>
                <div class="qty-wrap">
                    <button class="qty-btn" id="qtyMinus"><i class="bi bi-dash"></i></button>
                    <input class="qty-input" type="number" id="qtyInput" value="1" min="1" max="99" readonly />
                    <button class="qty-btn" id="qtyPlus"><i class="bi bi-plus"></i></button>
                </div>

                <button class="btn-addcart" id="addCartBtn" data-id="<?= $product['product_id'] ?>">
                    <i class="bi bi-cart-plus me-2"></i>ADD TO CART
                </button>

                <div class="share-row">
                    <a href="#" class="share-btn s-fb"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="share-btn s-tw"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="share-btn s-pi"><i class="bi bi-pinterest"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="desc-section">
        <h2 class="desc-title">Description</h2>
        <div class="desc-text">
            <?= nl2br(htmlspecialchars($product['description'])) ?>
        </div>
    </div>
</div>

<div class="modal fade" id="zoomModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <img id="zoomModalImg" src="" class="img-fluid w-100" />
            </div>
        </div>
    </div>
</div>

<script>
    // JS Logic for Quantity and Carousel sync
    const carousel = bootstrap.Carousel.getOrCreateInstance(document.getElementById('mainCarousel'));
    const thumbs = document.querySelectorAll('.thumb');

    thumbs.forEach(t => {
        t.addEventListener('click', () => {
            carousel.to(+t.dataset.idx);
        });
    });

    document.getElementById('mainCarousel').addEventListener('slid.bs.carousel', e => {
        thumbs.forEach(x => x.classList.remove('active'));
        document.querySelector(`.thumb[data-idx="${e.to}"]`)?.classList.add('active');
    });

    document.getElementById('qtyMinus').onclick = () => {
        let val = document.getElementById('qtyInput');
        if (val.value > 1) val.value--;
    };
    document.getElementById('qtyPlus').onclick = () => {
        let val = document.getElementById('qtyInput');
        val.value++;
    };

    // Zoom modal image sync
    document.getElementById('zoomModal').addEventListener('show.bs.modal', () => {
        const activeImg = document.querySelector('.carousel-item.active img').src;
        document.getElementById('zoomModalImg').src = activeImg;
    });
</script>

<?php include __DIR__ . "/viewIncludes/footer.php"; ?>