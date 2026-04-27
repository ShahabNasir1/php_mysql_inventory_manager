<?php 

session_start(); // Sabse pehle session shuru karein

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

?>

