<?php 
include __DIR__ . "/../sessionFile.php";

$pageName = "deleteColor";
$deleteColor = true;
$baseHref = "../";

// 1. MUST include config to access $conn
include __DIR__ . "/../config.php"; 

if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    // Use intval for security since IDs are numbers
    $id = intval($_GET['id']);
    
    // 2. DELETE Query using the correct column name
    $sql = "DELETE FROM colors WHERE color_id = $id";
    
    if ($conn->query($sql)) {
        // 3. Redirect back to the list page
        // Use '../colors/listColors.php' or 'listColors.php' depending on if this file is inside the /colors/ folder
        echo "<script>window.location.href='listColors.php';</script>";
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // If no ID is provided, go back to the list
    echo "<script>window.location.href='listColors.php';</script>";
    exit();
}
?>