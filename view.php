<?php
include __DIR__ . "/config.php";
include __DIR__ . "/sessionFile.php";
include __DIR__ . "/viewIncludes/header.php";
include __DIR__ . "/viewIncludes/nav.php";
include __DIR__ . "/viewIncludes/sidebar.php";

// 1. URL se Category ya Brand ID uthana
$cat_id = isset($_GET['cat_id']) ? (int)$_GET['cat_id'] : 0;
$brand_id = isset($_GET['brand_id']) ? (int)$_GET['brand_id'] : 0;

// 2. Dynamic Title aur Breadcrumb ke liye database se naam nikaalna
$pageTitle = "All Products";
if ($cat_id > 0) {
    $res = $conn->query("SELECT category_name FROM categories WHERE category_id = $cat_id");
    if($row = $res->fetch_assoc()) $pageTitle = $row['category_name'];
} elseif ($brand_id > 0) {
    $res = $conn->query("SELECT brand_name FROM brands WHERE brand_id = $brand_id");
    if($row = $res->fetch_assoc()) $pageTitle = $row['brand_name'];
}

// 3. Products Fetch karne ki Query
$sql = "SELECT p.*, 
          (SELECT image_url FROM product_images WHERE product_id = p.product_id LIMIT 1) as main_image
        FROM products p
        WHERE p.product_status = 'active'";

if ($cat_id > 0) $sql .= " AND p.category_id = $cat_id";
if ($brand_id > 0) $sql .= " AND p.brand_id = $brand_id";

$sql .= " ORDER BY p.product_id DESC";

$result = $conn->query($sql);
$productsArray = [];
while ($row = $result->fetch_assoc()) {
    $productsArray[] = [
        'id'    => (int)$row['product_id'],
        'name'  => $row['product_name'],
        'price' => (float)$row['price'],
        'img'   => !empty($row['main_image']) ? $row['main_image'] : 'assets/img/placeholder.jpg'
    ];
}
?>

<div class="col-lg-10 col-xl-10 col-12">
    <div class="breadcrumb-wrap">
        <a href="view.php">Home</a>
        <span class="breadcrumb-sep"><i class="bi bi-chevron-right"></i></span>
        <span><?= htmlspecialchars($pageTitle) ?></span>
    </div>

    <div class="main-content">
        <h1 class="page-title"><?= htmlspecialchars($pageTitle) ?></h1>

        <div class="row products-grid" id="productsGrid">
            </div>

        <div id="noResults" class="text-center py-5 d-none">
            <i class="bi bi-search" style="font-size:2.5rem;color:var(--text-muted);"></i>
            <p class="mt-2 text-muted">No products found in this selection.</p>
        </div>
    </div>
</div>

<script>
    // PHP data ko JS array mein convert karna
    const productsData = <?php echo json_encode($productsArray); ?>;

    document.addEventListener('DOMContentLoaded', () => {
        const grid = document.getElementById('productsGrid');
        const noRes = document.getElementById('noResults');

        if (productsData.length === 0) {
            noRes.classList.remove('d-none');
        } else {
            noRes.classList.add('d-none');
            productsData.forEach(p => {
                const col = document.createElement('div');
                col.className = 'col-6 col-md-4 col-xl-3 mb-4';
                col.innerHTML = `
                    <a href="viewDetail.php?id=${p.id}" class="text-decoration-none">
                        <div class="product-card shadow-sm p-3 bg-white rounded h-100 border">
                            <div class="text-center mb-3" style="height:180px; overflow:hidden;">
                                <img src="${p.img}" class="img-fluid h-100 w-100" style="object-fit:contain;" 
                                     onerror="this.src='https://via.placeholder.com/200'">
                            </div>
                            <h6 class="text-dark mb-2" style="height:40px; overflow:hidden;">${p.name}</h6>
                            <p class="fw-bold text-teal mb-0">PKR ${p.price.toLocaleString()}</p>
                        </div>
                    </a>
                `;
                grid.appendChild(col);
            });
        }
    });
</script>

<?php include __DIR__ . "/viewIncludes/footer.php"; ?>