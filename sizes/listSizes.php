<?php 
include __DIR__ . "/../sessionFile.php";
$pageName = "listSizes"; 
$listSizes = true; 
$baseHref = "../"; 
$dataTable = true; 

include __DIR__ . "/../config.php"; 
include __DIR__ . "/../includes/header.php"; 
include __DIR__ . "/../includes/slider.php"; 
include __DIR__ . "/../includes/topbar.php"; 
include __DIR__ . "/../includes/adminAccess.php";
?>

<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Sizes List</h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th>Size ID</th>
                            <th>Size Name</th>
                            <th>Size Status</th>
                            <th>Added Date</th>
                            <th>Update Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Updated Query for sizes table
                        $sql = "SELECT * FROM sizes ORDER BY size_id DESC"; 
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Logic for status formatting
                                $status = $row['size_status'];
                                $statusClass = ($status == 'active' || $status == '1') ? 'label-primary' : 'label-warning';
                                $statusText = ($status == 'active' || $status == '1') ? 'Active' : 'Inactive';
                        ?>
                                <tr>
                                    <td><?= $row['size_id']; ?></td>
                                    <td><strong><?= htmlspecialchars($row['size_name']); ?></strong></td>
                                    <td>
                                        <span class="label <?= $statusClass; ?>">
                                            <?= $statusText; ?>
                                        </span>
                                    </td>
                                    <td><?= $row['created_at']; ?></td>
                                    <td><?= $row['updated_at']; ?></td>
                                    <td class="center">
                                        <!-- Edit Path updated to sizes folder -->
                                        <a href="sizes/editSize.php?id=<?= $row['size_id']; ?>" class="btn btn-info btn-sm">
                                            <i class="fa fa-paste"></i> Edit
                                        </a>

                                        <!-- Delete Button Triggering Modal -->
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= $row['size_id']; ?>">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal<?= $row['size_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-left">
                                                        Are you sure you want to delete the size <strong><?= htmlspecialchars($row['size_name']); ?></strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Cancel</button>
                                                        <a href="sizes/deleteSize.php?id=<?= $row['size_id']; ?>" class="btn btn-danger">Yes, Delete It</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No sizes found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>