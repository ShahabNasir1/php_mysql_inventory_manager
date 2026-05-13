<?php 

include __DIR__ . "/../sessionFile.php";
include __DIR__ . "/../config.php"; 
$pageName = "deleteBrand";
$deleteBrand = true;
$baseHref = "../";
?>

<?php 
if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // 2. DELETE Query
    $sql = "DELETE FROM brands WHERE brand_id = '$id'";
    
    if ($conn->query($sql)) {
        // 3. Agar delete ho jaye to wapas list wale page par bhej dein
        echo "<script>window.location.href='brands/listBrands.php';</script>";
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    
    echo "<script>window.location.href='brands/listBrands.php';</script>";
    exit();
}
?>



<?php include __DIR__ . "/../includes/footer.php"; ?>