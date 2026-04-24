<?php 

session_start(); // Sabse pehle session shuru karein

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pageName = "deleteCategory";
$deleteCategory = true;
$baseHref = "../";

include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";
?>

<?php 
if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // 2. DELETE Query
    $sql = "DELETE FROM categories WHERE category_id = '$id'";
    
    if ($conn->query($sql)) {
        // 3. Agar delete ho jaye to wapas list wale page par bhej dein
        echo "<script>window.location.href='category/listCategories.php';</script>";
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    
    echo "<script>window.location.href='category/listCategories.php';</script>";
    exit();
}
?>



<?php include __DIR__ . "/../includes/footer.php"; ?>