<?php 
session_start(); // Sabse pehle session shuru karein

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php $pageName='' ?>
<?php include "includes/header.php"; ?>
<?php include "includes/slider.php"; ?>
<?php include "includes/topbar.php"; ?>


   
<div class="wrapper wrapper-content">
    <h2>Dashboard</h2>
    <p>Welcome to Home Page</p>
</div>

<?php include "includes/footer.php"; ?>