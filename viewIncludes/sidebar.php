<?php
// Categories fetch karein
include __DIR__ . "/../config.php";
$cat_query = "SELECT * FROM categories WHERE category_status = 'active' ORDER BY category_name ASC";
$cat_result = $conn->query($cat_query);

// Brands fetch karein
$brand_query = "SELECT * FROM brands WHERE brand_status = 'active' ORDER BY brand_name ASC";
$brand_result = $conn->query($brand_query);

// Data ko arrays mein save kar letay hain taake loop do baar (desktop/mobile) chal sake
$categories = [];
while ($row = $cat_result->fetch_assoc()) {
  $categories[] = $row;
}

$brands = [];
while ($row = $brand_result->fetch_assoc()) {
  $brands[] = $row;
}
?>
<div class="col-lg-2 col-xl-2 sidebar" id="desktopSidebar">
    <p class="sidebar-section-title">Shop By</p>
    <ul class="sidebar-nav">
        <li><a href="view.php"><i class="bi bi-house me-2"></i>Home</a></li>
        <li><a href="view.php"><i class="bi bi-grid me-2"></i>All Products</a></li>
    </ul>
    
    <hr class="sidebar-divider">
    <p class="sidebar-section-title">Categories</p>
    <ul class="sidebar-nav">
        <?php foreach ($categories as $cat): ?>
            <li>
                <a href="view.php?cat_id=<?= $cat['category_id'] ?>">
                    <?= htmlspecialchars($cat['category_name']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    
    <hr class="sidebar-divider">
    <p class="sidebar-section-title">Brands</p>
    <ul class="sidebar-nav">
        <?php foreach ($brands as $brand): ?>
            <li>
                <a href="view.php?brand_id=<?= $brand['brand_id'] ?>">
                    <?= htmlspecialchars($brand['brand_name']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="offcanvas offcanvas-start offcanvas-sidebar" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header" style="border-bottom:1px solid var(--border);">
        <h6 class="offcanvas-title fw-bold">Menu</h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body px-0">
        <p class="sidebar-section-title mt-3">Categories</p>
        <ul class="sidebar-nav">
            <?php foreach ($categories as $cat): ?>
                <li>
                    <a href="view.php?cat_id=<?= $cat['category_id'] ?>">
                        <?= htmlspecialchars($cat['category_name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        
        <hr class="sidebar-divider">
        <p class="sidebar-section-title mt-3">Brands</p>
        <ul class="sidebar-nav">
            <?php foreach ($brands as $brand): ?>
                <li>
                    <a href="view.php?brand_id=<?= $brand['brand_id'] ?>">
                        <?= htmlspecialchars($brand['brand_name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>