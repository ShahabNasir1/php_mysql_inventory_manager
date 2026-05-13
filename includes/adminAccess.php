<?php   

if($_SESSION['user_type'] !== 'admin') {
    // echo "<script>window.location.href='products/listProducts.php';</script>";
     echo "<script>window.location.href='view.php';</script>";
    exit;
}
?>