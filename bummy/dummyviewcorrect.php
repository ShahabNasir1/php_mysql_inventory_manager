<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "config.php";

$pageName = 'publicSide';
$publicSide = true;

include "includes/header.php";
include "includes/slider.php";
include "includes/topbar.php";

$query = "SELECT p.*, 
          (SELECT image_url 
           FROM product_images 
           WHERE product_id = p.product_id 
           LIMIT 1) as main_image
          FROM products p
          WHERE p.product_status = 'active'
          ORDER BY p.product_id DESC";

$result = $conn->query($query);
?>

<style>

/* PRODUCT GRID */
.product-row{
    display:flex;
    flex-wrap:wrap;
}

/* COLUMN SPACING */
.product-row > div{
    padding-left:10px;
    padding-right:10px;
    margin-bottom:20px;
}

/* PRODUCT CARD */
.product-card{
    background:#ffffff;
    border:1px solid #e7eaec;
    transition:0.3s;
    position:relative;
}

.product-card:hover{
    transform:translateY(-4px);
    box-shadow:0 8px 15px rgba(0,0,0,0.08);
}

/* IMAGE */
.image-container{
    position:relative;
    width:100%;
    height:340px;
    overflow:hidden;
    background:#fff;
}

.image-container img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}

/* NEW BADGE */
.badge-new{
    position:absolute;
    top:12px;
    left:-28px;
    background:#1ab394;
    color:#fff;
    padding:5px 30px;
    transform:rotate(-45deg);
    font-size:11px;
    font-weight:bold;
    z-index:10;
}

/* HEART */
.heart-icon{
    position:absolute;
    top:10px;
    right:10px;
    width:38px;
    height:38px;
    border-radius:50%;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#ccc;
    box-shadow:0 2px 8px rgba(0,0,0,0.12);
    cursor:pointer;
    z-index:5;
}

.heart-icon:hover{
    color:#ed5565;
}

/* PRODUCT INFO */
.info-section{
    padding:18px 15px;
    text-align:center;
    position:relative;
}

/* PRICE */
.price-box{
    position:absolute;
    top:-20px;
    right:12px;
    background:#fff;
    padding:6px 12px;
    border-radius:3px;
    box-shadow:0 2px 8px rgba(0,0,0,0.12);
}

.current-price{
    color:#2f4050;
    font-size:16px;
    font-weight:bold;
}

.old-price{
    color:#aaa;
    font-size:12px;
    margin-left:5px;
    text-decoration:line-through;
}

/* TITLE */
.prod-title{
    display:block;
    color:#1ab394;
    font-size:15px;
    font-weight:500;
    text-decoration:none !important;
    margin:18px 0;
    min-height:45px;

    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

.prod-title:hover{
    color:#18a689;
}

/* BUTTON */
.btn-add-cart{
    width:100%;
    border:1px solid #1ab394;
    background:#fff;
    color:#1ab394;
    padding:10px;
    font-size:13px;
    font-weight:bold;
    text-transform:uppercase;
    transition:0.3s;
}

.btn-add-cart:hover{
    background:#1ab394;
    color:#fff;
}

</style>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row product-row">

        <?php
        if ($result && $result->num_rows > 0):

            while ($p = $result->fetch_assoc()):

                $imagePath = !empty($p['main_image'])
                    ? $p['main_image']
                    : 'assets/img/placeholder.jpg';
        ?>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">

            <div class="product-card">

                <div class="image-container">

                    <div class="badge-new">
                        New
                    </div>

                    <div class="heart-icon">
                        <i class="fa fa-heart"></i>
                    </div>

                    <img
                        src="<?= $imagePath; ?>"
                        alt="<?= htmlspecialchars($p['product_name']); ?>">

                </div>

                <div class="info-section">

                    <div class="price-box">

                        <span class="current-price">
                            PKR<?= number_format($p['price'], 2); ?>
                        </span>

                        <span class="old-price">
                            PKR<?= number_format($p['price'] * 1.2, 2); ?>
                        </span>

                    </div>

                    <a
                        href="view_product.php?id=<?= $p['product_id']; ?>"
                        class="prod-title">

                        <?= htmlspecialchars($p['product_name']); ?>

                    </a>

                    <button class="btn btn-add-cart">
                        Add To Cart
                    </button>

                </div>

            </div>

        </div>

        <?php
            endwhile;

        else:
        ?>

        <div class="col-12">

            <div class="alert alert-warning text-center">
                No products found in database.
            </div>

        </div>

        <?php endif; ?>

    </div>

</div>

<?php include "includes/footer.php"; ?>