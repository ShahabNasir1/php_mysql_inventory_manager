<?php

include __DIR__ . "/../sessionFile.php";

$pageName = "listCategories";
$listCategories = true;
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
            <h5>Categories List</h5>
        </div>

        <div class="ibox-content">

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Status</th>
                            <th>Added Date</th>
                            <th>Updated Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $sql = "SELECT * FROM categories ORDER BY created_at DESC";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {

                            while ($row = $result->fetch_assoc()) {

                                $statusClass = ($row['category_status'] == 'active') ? 'label-primary' : 'label-warning';

                        ?>

                                <tr>
                                    <td><?= $row['category_id']; ?></td>

                                    <td><strong><?= htmlspecialchars($row['category_name']); ?></strong></td>

                                    <td>
                                        <span class="label <?= $statusClass; ?>">
                                            <?= ucfirst($row['category_status']); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= date('Y-m-d H:i:s', strtotime($row['created_at'])); ?>
                                    </td>

                                    <td>
                                        <?= date('Y-m-d H:i:s', strtotime($row['updated_at'])); ?>
                                    </td>

                                    <td class="center">
                                        <a href="category/editCategory.php?id=<?= (int)$row['category_id']; ?>" class="btn btn-info btn-sm">
                                            <i class="fa fa-paste"></i> Edit
                                        </a>

                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= $row['category_id']; ?>">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>

                                        <div class="modal fade" id="deleteModal<?= $row['category_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Do you want to delete the category <strong><?= $row['category_name']; ?></strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Cancel</button>
                                                        <a href="category/deleteCategory.php?id=<?= $row['category_id']; ?>" class="btn btn-danger">Yes, Delete It</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No categories found</td></tr>";
                        }
                        ?>

                    </tbody>

                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Status</th>
                            <th>Added Date</th>
                            <th>Updated Date</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>

                </table>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>