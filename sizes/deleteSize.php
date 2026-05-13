<?php 
include __DIR__ . "/../sessionFile.php";

$pageName = "deleteSize";
$deleteSize = true;
$baseHref = "../";

// 1. MUST include config to access $conn
include __DIR__ . "/../config.php"; 

if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    // Use intval for security since IDs are numbers
    $id = intval($_GET['id']);
    
    // 2. DELETE Query updated for the sizes table
    $sql = "DELETE FROM sizes WHERE size_id = $id";
    
    if ($conn->query($sql)) {
        // 3. Redirect back to the sizes list page
        echo "<script>window.location.href='listSizes.php';</script>";
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // If no ID is provided, go back to the list
    echo "<script>window.location.href='listSizes.php';</script>";
    exit();
}
?>