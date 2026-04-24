<?php 
session_start(); // Sabse pehle session shuru karein

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php $pageName = "";?>
<?php $infra = true;?>
<?php $baseHref = "../"; ?>


<?php include __DIR__ . "/../includes/header.php"; ?>
<?php include __DIR__ . "/../includes/slider.php"; ?>
<?php include __DIR__ . "/../includes/topbar.php"; ?>


 
 

    


<?php include __DIR__ . "/../includes/footer.php"; ?>