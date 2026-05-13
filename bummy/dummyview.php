<?php
session_start(); // Sabse pehle session shuru karein

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php $pageName = 'publicSide' ?>
<?php $publicSide = true ?>
<?php include "includes/header.php"; ?>
<?php include "includes/slider.php"; ?>
<?php include "includes/topbar.php"; ?>
<?php include "config.php"; ?>



<div class="wrapper wrapper-content">
    <style>
        /* Card Styling */
        .product-card {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            margin-bottom: 25px;
            transition: transform 0.2s ease;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .image-container {
            position: relative;
            height: 200px;
            background: #fdfdfd;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .image-container img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }

        /* Teal Badge & Heart */
        .badge-new {
            position: absolute;
            top: 0;
            left: 0;
            background: #1ab394;
            color: white;
            padding: 5px 25px;
            transform: rotate(-45deg) translate(-18px, -6px);
            font-size: 10px;
            font-weight: bold;
            z-index: 2;
        }

        .heart-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            background: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        /* Info Area */
        .info-section {
            padding: 15px;
            position: relative;
            border-top: 1px solid #f5f5f5;
            text-align: center;
        }

        .price-box {
            position: absolute;
            top: -18px;
            right: 10px;
            background: white;
            padding: 3px 8px;
            border-radius: 2px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .current-price {
            color: #2f4050;
            font-weight: bold;
            font-size: 15px;
        }

        .old-price {
            color: #aaa;
            text-decoration: line-through;
            font-size: 11px;
            margin-left: 5px;
        }

        .prod-title {
            color: #1ab394;
            font-size: 13px;
            font-weight: 500;
            height: 40px;
            overflow: hidden;
            margin: 10px 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            text-decoration: none !important;
        }

        .btn-add-cart {
            border: 1px solid #1ab394;
            color: #1ab394;
            background: white;
            width: 100%;
            padding: 7px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            transition: 0.3s;
        }

        .btn-add-cart:hover {
            background: #1ab394;
            color: white;
        }
    </style>

    <div class="row">
        <?php
        // Hard-coded dummy data for 4 cards
        $dummyProducts = [
            ['name' => 'Tommy Summer 2025 by Tommy Hilfiger for Men 3.4 fl.oz', 'price' => '74.56', 'old' => '98.00', 'img' => 'https://via.placeholder.com/200x250?text=Perfume+1'],
            ['name' => 'Aramis Devin by Aramis for Men 3.3 fl.oz / 100 ml Cologne', 'price' => '114.98', 'old' => '148.00', 'img' => 'https://via.placeholder.com/200x250?text=Perfume+2'],
            ['name' => 'Acqua Di Gio by Giorgio Armani for Men 4.2 fl.oz Parfum', 'price' => '118.78', 'old' => '168.00', 'img' => 'https://via.placeholder.com/200x250?text=Perfume+3'],
            ['name' => 'Acqua Di Gio Men 6.7 fl.oz / 200 ml Eau de Parfum Spray', 'price' => '122.89', 'old' => '188.00', 'img' => 'https://via.placeholder.com/200x250?text=Perfume+4'],
            ['name' => 'Tommy Summer 2025 by Tommy Hilfiger for Men 3.4 fl.oz', 'price' => '74.56', 'old' => '98.00', 'img' => 'https://via.placeholder.com/200x250?text=Perfume+1'],

        ];

        foreach ($dummyProducts as $p):
        ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product-card">
                    <div class="image-container">
                        <div class="badge-new">New</div>
                        <div class="heart-icon"><i class="fa fa-heart"></i></div>
                        <img src="<?= $p['img'] ?>" alt="product">
                    </div>

                    <div class="info-section">
                        <div class="price-box">
                            <span class="current-price">US$<?= $p['price'] ?></span>
                            <span class="old-price">US$<?= $p['old'] ?></span>
                        </div>

                        <a href="#" class="prod-title"><?= $p['name'] ?></a>

                        <button class="btn btn-add-cart">Add to cart</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<?php include "includes/footer.php"; ?>