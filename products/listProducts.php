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

                <table class="table table-striped table-bordered table-hover dataTables-example">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Added Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
                    $sql = "SELECT p.*, c.category_name, b.brand_name FROM products p
                            LEFT JOIN categories c ON p.category_id = c.category_id
                            LEFT JOIN brands b ON p.brand_id = b.brand_id
                            ORDER BY p.created_at DESC";

                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {

                        while($row = $result->fetch_assoc()) {

                            $statusClass = ($row['product_status'] == 'active') 
                                ? 'label-primary' 
                                : 'label-warning';
                    ?>

                        <tr>
                            <td><?= $row['product_id']; ?></td>

                            <td><strong><?= htmlspecialchars($row['product_name']); ?></strong></td>

                            <td><?= htmlspecialchars($row['category_name']); ?></td>

                            <td><?= htmlspecialchars($row['brand_name']); ?></td>

                            <td><?= number_format($row['price'], 2); ?></td>

                            <td>
                                <?php if (!empty($row['product_image'])) { ?>
                                    <img src="products/<?= $row['product_image']; ?>" width="50">
                                <?php } else { ?>
                                    N/A
                                <?php } ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['description']); ?>
                            </td>

                            <td>
                                <span class="label <?= $statusClass; ?>">
                                    <?= ucfirst($row['product_status']); ?>
                                </span>
                            </td>

                            <td>
                                <?= date('Y-m-d h:i:s', strtotime($row['created_at'])); ?>
                            </td>

                            <td class="center">

                                <a href="products/editProduct.php?id=<?= $row['product_id']; ?>" 
                                   class="btn btn-info btn-sm">
                                    <i class="fa fa-paste"></i> Edit
                                </a>

                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= $row['product_id']; ?>">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>

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
                                                        Do you want to delete the product <strong><?= $row['product_name']; ?></strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Cancel</button>
                                                        <a href="products/deleteProduct.php?id=<?= $row['product_id']; ?>" class="btn btn-danger">Yes, Delete It</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                            </td>
                        </tr>

                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>No products found</td></tr>";
                    }
                    ?>

                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>