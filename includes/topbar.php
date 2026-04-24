<div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome to E-Commerce</span>
                </li>


                <li>
                    <a href="logout.php">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
    </div>
    
    <?php
// 1. Get the current script name without the .php extension
// Example: /var/www/admin/category/addCategory.php -> category/addCategory
$current_path = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME) . '/' . pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_FILENAME);

// Normalize path: remove leading slashes if they exist to match array keys
$current_path = ltrim($current_path, '/');

// 2. Define the menu structure
$menu_structure = [
    'category' => [
        'icon' => 'fa-edit',
        'items' => [
            'category/addCategory' => 'Add Category',
            'category/listCategories' => 'List Categories',
            'category/editCategories' => 'Edit Categories',
            // 'category/deleteCategories' => 'Delete Categories'
        ]
    ],
    'products' => [
        'icon' => 'fa-edit',
        'items' => [
            'products/addProduct' => 'Add Products',
            'products/listProducts' => 'List Products',
            'products/editProducts' => 'Edit Products',
            // 'products/deleteProducts' => 'Delete Products'
        ]
    ],
    'brands' => [
        'icon' => 'fa-edit',
        'items' => [
            'brands/addBrand' => 'Add Brand',
            'brands/listBrands' => 'List Brands',
            'brands/editBrands' => 'Edit Brands',
            // 'brands/deleteBrands' => 'Delete Brands'
        ]
    ],
];

$active_parent = "";
$active_child = "";

// 3. Match the current path against the structure
foreach ($menu_structure as $parent_title => $data) {
    foreach ($data['items'] as $path => $label) {
        // Simple match: does our normalized path contain the menu key?
        if (strpos($current_path, $path) !== false) {
            $active_parent = $parent_title;
            $active_child = $label;
            break 2;
        }
    }
}

// 4. Set $pageName for the Sidebar (backward compatibility)
// This finds just the 'addCategory' part for your sidebar logic
$pageName = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_FILENAME);
?>

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2><?php echo $active_child; ?></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">Home</a>
                </li>
                <?php if ($active_parent): ?>
                    <li class="breadcrumb-item">
                        <a><?php echo $active_parent; ?></a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong><?php echo $active_child; ?></strong>
                    </li>
                <?php endif; ?>
            </ol>
        </div>
        <div class="col-lg-2"></div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">