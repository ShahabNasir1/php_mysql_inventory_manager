<?php
include __DIR__ . "/config.php";
include __DIR__ . "/sessionFile.php";
include __DIR__ . "/viewIncludes/header.php";
include __DIR__ . "/viewIncludes/nav.php";
include __DIR__ . "/viewIncludes/sidebar.php";

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

if (!$product) {
    echo "<div class='container py-5 text-center'><h3>Product not found!</h3></div>";
    include __DIR__ . "/viewIncludes/footer.php";
    exit;
}

$imgSql = "SELECT image_url FROM product_images WHERE product_id = $p_id";
$imgRes = $conn->query($imgSql);
$images = [];
while ($row = $imgRes->fetch_assoc()) { $images[] = $row['image_url']; }
if (empty($images)) { $images[] = 'assets/img/placeholder.jpg'; }
?>

<style>
    /* Images ko container ke mutabiq fix karne ke liye */
    .carousel-item img {
        width: 100%;
        height: 450px;
        object-fit: contain;
        background: #f8f9fa;
    }
    .thumb-strip {
        display: flex;
        gap: 10px;
        margin-top: 15px;
        overflow-x: auto;
    }
    .thumb img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid transparent;
    }
    .thumb.active img { border-color: var(--teal); }
    .color-badge {
        padding: 5px 12px;
        border-radius: 20px;
        background: #eee;
        font-size: 13px;
        display: inline-block;
        margin-right: 5px;
    }
</style>

<div class="col-lg-10 col-xl-10 col-12">
    <div class="content-area">
        <div class="product-card shadow-sm p-4 bg-white rounded">
            <div class="row">
                <div class="col-lg-5">
                    <div id="mainCarousel" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner rounded border">
                            <?php foreach ($images as $index => $img): ?>
                                <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
                                    <img src="<?= htmlspecialchars($img) ?>" class="d-block w-100">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($images) > 1): ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-dark rounded-circle"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon bg-dark rounded-circle"></span>
                            </button>
                        <?php endif; ?>
                    </div>

                    <div class="thumb-strip">
                        <?php foreach ($images as $index => $img): ?>
                            <div class="thumb <?= $index == 0 ? 'active' : '' ?>" data-bs-target="#mainCarousel" data-bs-slide-to="<?= $index ?>">
                                <img src="<?= htmlspecialchars($img) ?>" class="rounded border">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="col-lg-7 ps-lg-5 mt-4 mt-lg-0">
                    <h1 class="product-title fw-bold mb-3"><?= htmlspecialchars($product['product_name']) ?></h1>
                    
                    <div class="price-row mb-4">
                        <span class="price-now fs-3 fw-bold text-teal">PKR <?= number_format($product['price'], 2) ?></span>
                        <span class="price-old text-muted text-decoration-line-through ms-3">PKR <?= number_format($product['price'] * 1.2, 2) ?></span>
                    </div>

                    <table class="table table-borderless meta-table">
                        <tr>
                            <td class="label text-muted" style="width:120px;">Brand:</td>
                            <td class="fw-semibold"><?= htmlspecialchars($product['brand_name'] ?? 'N/A') ?></td>
                        </tr>
                        <tr>
                            <td class="label text-muted">Category:</td>
                            <td><?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></td>
                        </tr>
                        <tr>
                            <td class="label text-muted">Colors:</td>
                            <td>
                                <?php 
                                if(!empty($product['product_colors'])){
                                    $colors = explode(',', $product['product_colors']);
                                    foreach($colors as $c) echo "<span class='color-badge'>".trim($c)."</span>";
                                } else { echo "N/A"; }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="label text-muted">Sizes:</td>
                            <td>
                                <?php 
                                if(!empty($product['product_sizes'])){
                                    $sizes = explode(',', $product['product_sizes']);
                                    foreach($sizes as $s) echo "<span class='size-badge border px-3 py-1 me-2 rounded bg-light'>".trim($s)."</span>";
                                } else { echo "Standard"; }
                                ?>
                            </td>
                        </tr>
                    </table>

                    <div class="d-flex align-items-center gap-3 mt-4">
                        <div class="qty-wrap d-flex border rounded">
                            <button class="btn px-3" id="minusBtn"><i class="bi bi-dash"></i></button>
                            <input type="number" id="qtyInput" class="form-control border-0 text-center" style="width:60px;" value="1" readonly>
                            <button class="btn px-3" id="plusBtn"><i class="bi bi-plus"></i></button>
                        </div>
                        <button class="btn btn-dark btn-lg flex-grow-1 py-3 fw-bold">
                            <i class="bi bi-cart-plus me-2"></i> ADD TO CART
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="desc-section mt-5 p-4 bg-white rounded shadow-sm">
            <h4 class="fw-bold border-bottom pb-3 mb-3">Description</h4>
            <div class="text-secondary leading-relaxed">
                <?= nl2br(htmlspecialchars($product['description'])) ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Quantity logic
    const qtyInput = document.getElementById('qtyInput');
    document.getElementById('plusBtn').onclick = () => qtyInput.value = parseInt(qtyInput.value) + 1;
    document.getElementById('minusBtn').onclick = () => {
        if(qtyInput.value > 1) qtyInput.value = parseInt(qtyInput.value) - 1;
    };

    // Thumb active class toggle
    const thumbs = document.querySelectorAll('.thumb');
    thumbs.forEach(t => {
        t.addEventListener('click', function() {
            thumbs.forEach(el => el.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>

<?php include __DIR__ . "/viewIncludes/footer.php"; ?>