<?php 
include __DIR__ . "/../sessionFile.php";

$pageName = "deleteProduct";
$deleteProduct = true;
$baseHref = "../";

include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // 1. Pehle images fetch karein taake records delete hone se pehle unka naam mil jaye
    $getImagesSql = "SELECT image_url FROM product_images WHERE product_id = '$id'";
    $result = $conn->query($getImagesSql);
    
    // Ek array mein images save kar letay hain
    $imagesToDelete = [];
    while ($row = $result->fetch_assoc()) {
        $imagesToDelete[] = $row['image_url'];
    }

    // 2. Database se product delete karein 
    // (Ensure karein ke aapki DB tables mein 'ON DELETE CASCADE' laga ho, 
    // warna pehle product_images se delete karna parega)
    $sql = "DELETE FROM products WHERE product_id = '$id'";
    
    if ($conn->query($sql)) {
        
        // 3. Ab physical files delete karein folder se
        foreach ($imagesToDelete as $dbPath) {
            
            // Agar DB mein path "products/uploads/image.jpg" hai
            // Toh humein sirf filename chahiye ya relative path adjust karna hoga
            // Aapne folder bataya: htdocs\ecommerce\products\uploads\
            
            $fileName = basename($dbPath); // Sirf file ka naam nikalega (e.g., 12345.jpg)
            $filePath = __DIR__ . "/uploads/" . $fileName; 
            // Debugging ke liye check karein ke path sahi ban raha hai
            if (!empty($fileName) && file_exists($filePath)) {
                unlink($filePath);
            }
        }

        echo "<script>window.location.href='products/listProducts.php';</script>";
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "<script>window.location.href='products/listProducts.php';</script>";
    exit();
}

include __DIR__ . "/../includes/footer.php"; 
?>