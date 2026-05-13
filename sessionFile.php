<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// session_start(); // Sabse pehle session shuru karein

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}



?>

