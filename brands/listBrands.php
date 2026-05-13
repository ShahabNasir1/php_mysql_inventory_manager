<?php 

include __DIR__ . "/../sessionFile.php";
$pageName = "listBrands"; 
$listBrands = true; 
$baseHref = "../"; 
$dataTable = true; 

// Database connection check karein ke path sahi hai
include __DIR__ . "/../config.php"; 
include __DIR__ . "/../includes/header.php"; 
include __DIR__ . "/../includes/slider.php"; 
include __DIR__ . "/../includes/topbar.php"; 
include __DIR__ . "/../includes/adminAccess.php";
?>

<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Brands List</h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th>Brand ID</th>
                            <th>Brand Name</th>
                            <th>Brand Status</th>
                            <th>Added Date</th>
                            <th>Update Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Check karein ke columns ke naam database mein yahi hain (created_at, updated_at)
                        $sql = "SELECT * FROM brands ORDER BY brand_id DESC"; 
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Status color logic
                                // Agar DB mein 1/0 hai to wo check karein, agar 'active'/'inactive' hai to ye sahi hai
                                $status = $row['brand_status'];
                                $statusClass = ($status == 'active' || $status == '1') ? 'label-primary' : 'label-warning';
                                $statusText = ($status == 'active' || $status == '1') ? 'Active' : 'Inactive';
                        ?>
                                <tr>
                                    <td><?= $row['brand_id']; ?></td>
                                    <td><strong><?= htmlspecialchars($row['brand_name']); ?></strong></td>
                                    <td>
                                        <span class="label <?= $statusClass; ?>">
                                            <?= $statusText; ?>
                                        </span>
                                    </td>
                                    <td><?= $row['created_at']; ?></td>
                                    <td><?= $row['updated_at']; ?></td>
                                    <td class="center">
                                        <a href="brands/editBrand.php?id=<?= (int)$row['brand_id']; ?>" class="btn btn-info btn-sm">
                                            <i class="fa fa-paste"></i> Edit
                                        </a>

                                         <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= $row['brand_id']; ?>">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>

                                        <div class="modal fade" id="deleteModal<?= $row['brand_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Do you want to delete the brand <strong><?= $row['brand_name']; ?></strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Cancel</button>
                                                        <a href="brands/deleteBrand.php?id=<?= $row['brand_id']; ?>" class="btn btn-danger">Yes, Delete It</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No brands found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>