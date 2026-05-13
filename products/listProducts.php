<?php
include __DIR__ . "/../sessionFile.php";
$pageName = "listProducts";
$listProducts = true;
$baseHref = "../";
$dataTable = true;

include __DIR__ . "/../config.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/slider.php";
include __DIR__ . "/../includes/topbar.php";



?>

<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Products List</h5>
        </div>

        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example" data-order='[[ 0, "desc" ]]'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Description</th>
                            <!-- <th>Image</th> -->
                            <th>Colors</th>
                            <th>Sizes</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $current_user_id = $_SESSION['user_id'];

                        // SQL updated with GROUP_CONCAT to get multiple colors and sizes in one string
                        $sql = "SELECT 
    p.product_id, 
    p.product_name, 
    p.description, 
    p.price, 
    p.product_status,
    c.category_name, 
    b.brand_name, 
    (SELECT GROUP_CONCAT(cl.color_name SEPARATOR ', ') 
     FROM product_colors pc 
     JOIN colors cl ON pc.color_id = cl.color_id 
     WHERE pc.product_id = p.product_id) AS colors,
    (SELECT GROUP_CONCAT(sz.size_name SEPARATOR ', ') 
     FROM product_sizes ps 
     JOIN sizes sz ON ps.size_id = sz.size_id 
     WHERE ps.product_id = p.product_id) AS sizes
FROM products p
LEFT JOIN categories c ON p.category_id = c.category_id
LEFT JOIN brands b ON p.brand_id = b.brand_id
ORDER BY p.product_id DESC";

                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $statusClass = ($row['product_status'] == 'active') ? 'label-primary' : 'label-warning';
                        ?>
                                <tr>
                                    <td><?= $row['product_id']; ?></td>
                                    <td><strong><?= htmlspecialchars($row['product_name']); ?></strong></td>
                                    <td><?= htmlspecialchars($row['category_name']); ?></td>
                                    <td><?= htmlspecialchars($row['brand_name']); ?></td>
                                    <td><?= number_format($row['price'], 2); ?></td>
                                    
                                    <td>
                                        <?= htmlspecialchars($row['description']); ?>
                                    </td>

                                    <!-- <td>
                                        <?php if (!empty($row['product_image'])) { ?>
                                            <img src="products/<?= $row['product_image']; ?>" width="50">
                                        <?php } else { ?>
                                            N/A
                                        <?php } ?>
                                    </td> -->

                                   
                                    <!-- Displaying Colors -->
                                    <td>
                                        <?php if (!empty($row['colors'])) {
                                            $colorList = explode(', ', $row['colors']);
                                            foreach($colorList as $color) {
                                                echo "<span class='badge badge-info' style='margin-right:2px;'>$color</span>";
                                            }
                                        } else { echo "<small class='text-muted'>No Colors</small>"; } ?>
                                    </td>

                                    <!-- Displaying Sizes -->
                                    <td>
                                        <?php if (!empty($row['sizes'])) {
                                            $sizeList = explode(', ', $row['sizes']);
                                            foreach($sizeList as $size) {
                                                echo "<span class='badge badge-default' style='margin-right:2px;'>$size</span>";
                                            }
                                        } else { echo "<small class='text-muted'>No Sizes</small>"; } ?>
                                    </td>

                                    <td>
                                        <span class="label <?= $statusClass; ?>">
                                            <?= ucfirst($row['product_status']); ?>
                                        </span>
                                    </td>

                                    <td class="center">
                                        <a href="products/editProduct.php?id=<?= $row['product_id']; ?>" class="btn btn-info btn-sm">
                                            <i class="fa fa-paste"></i> Edit
                                        </a>

                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= $row['product_id']; ?>">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal<?= $row['product_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Do you want to delete <strong><?= $row['product_name']; ?></strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <a href="products/deleteProduct.php?id=<?= $row['product_id']; ?>" class="btn btn-danger">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='10' class='text-center'>No products found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php include __DIR__ . "/../includes/footer.php"; ?>