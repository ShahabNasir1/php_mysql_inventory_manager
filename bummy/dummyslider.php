
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <!-- <img alt="image" class="rounded-circle" src="img\profile_small.jpg" /> -->
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">Hi! <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest'; ?></span>

                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <!-- <li><a class="dropdown-item" href="profile.html">UploadProfile</a></li> -->
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    EC+
                </div>
            </li>




          
            <li <?php echo ($pageName == 'addCategory' || $pageName == 'listCategories') ? 'class="active"' : ''; ?>>
                <a href="#"><i class="fa fa-tags"></i> <span class="nav-label">Categories</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">

                    <li id="basic" <?php echo ($pageName == 'addCategory') ? 'class="active"' : ''; ?>><a
                            href="category/addCategory.php">Add Category</a></li>
                    <li id="wizard" <?php echo ($pageName == 'listCategories') ? 'class="active"' : ''; ?>><a
                            href="category/listCategories.php">List Categories</a></li>

                </ul>
            </li>

            <li <?php echo ($pageName == 'addBrand' || $pageName == 'listBrands') ? 'class="active"' : ''; ?>>
                <a href="#"><i class="fa fa-shop"></i> <span class="nav-label">Brands</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li id="basic" <?php echo ($pageName == 'addBrand') ? 'class="active"' : ''; ?>><a
                            href="brands/addBrand.php">Add Brand</a></li>
                    <li id="wizard" <?php echo ($pageName == 'listBrands') ? 'class="active"' : ''; ?>><a
                            href="brands/listBrands.php">List Brands</a></li>
                </ul>
            </li>

            <li <?php echo ($pageName == 'addProduct' || $pageName == 'listProducts') ? 'class="active"' : ''; ?>>
                <a href="#"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-fill" viewBox="0 0 16 16">
                        <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4z" />
                    </svg>
                    <span class="nav-label"> Products</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li id="basic" <?php echo ($pageName == 'addProduct') ? 'class="active"' : ''; ?>><a
                            href="products/addProduct.php">Add Product</a></li>
                    <li id="wizard" <?php echo ($pageName == 'listProducts') ? 'class="active"' : ''; ?>><a
                            href="products/listProducts.php">List Products</a></li>
                </ul>
            </li>

            
<?php if ($pageName!== 'publicSide'): ?>  
            <li <?php echo ($pageName == 'addSize' || $pageName == 'listSizes') ? 'class="active"' : ''; ?>>
                <a href="#"><i class="fa fa-ruler-combined"></i> <span class="nav-label">Sizes</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li id="basic" <?php echo ($pageName == 'addSize') ? 'class="active"' : ''; ?>><a
                            href="sizes/addSize.php">Add Size</a></li>
                    <li id="wizard" <?php echo ($pageName == 'listSizes') ? 'class="active"' : ''; ?>><a
                            href="sizes/listSizes.php">List Sizes</a></li>
                </ul>
            </li>

            <li <?php echo ($pageName == 'addColor' || $pageName == 'listColor') ? 'class="active"' : ''; ?>>
                <a href="#"><i class="fa fa-palette"></i> <span class="nav-label">Colors</span><span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li id="basic" <?php echo ($pageName == 'addColor') ? 'class="active"' : ''; ?>><a
                            href="colors/addColor.php">Add Color</a></li>
                    <li id="wizard" <?php echo ($pageName == 'listColors') ? 'class="active"' : ''; ?>><a
                            href="colors/listColors.php">List Colors</a></li>
                </ul>
            </li>
<?php endif; ?>

        </ul>

    </div>
</nav>