<?php
require '../connection.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// $sales = $conn->query("SELECT s.*, c.name AS customer_name FROM sales s JOIN customers c ON s.customer_id = c.id");

$userId = $_SESSION['user_id'];
$sales = $conn->query("SELECT s.*, c.name AS customer_name 
                       FROM sales s 
                       JOIN customers c ON s.customer_id = c.id 
                       WHERE s.created_by = $userId 
                       ORDER BY s.id DESC");

?>
<style>
    table td,
    table th {
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
<?php include '../includes/sidebar.php'; ?>
<!--! [Start] Main Content !-->
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/view_sales.php">View Sale</a></li>
                    <li class="breadcrumb-item">Dashboard</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex d-md-none">
                        <a href="javascript:void(0)" class="page-header-right-close-toggle">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Back</span>
                        </a>
                    </div>
                </div>
                <div class="d-md-none d-flex align-items-center">
                    <a href="javascript:void(0)" class="page-header-right-open-toggle">
                        <i class="feather-align-right fs-20"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card border-0 shadow-sm" style="background-color: #ffffff;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 text-black">Sales Records</h4>
                    <a href="/admin/add_sale.php" class="btn btn-dark">Add Sale</a>
                </div>

                <div class="card-body">
                    <?php if ($sales->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-black">
                                <thead class="table-light border-bottom border-dark-subtle">
                                    <tr>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Notes</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $sales->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['customer_name']) ?></td>
                                            <td><?= htmlspecialchars($row['product_name']) ?></td>
                                            <td>$<?= number_format($row['amount'], 2) ?></td>
                                            <td><?= htmlspecialchars($row['sale_date']) ?></td>
                                            <td><?= htmlspecialchars($row['notes']) ?></td>
                                            <td>
                                                <a href="/admin/edit_sale.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                                                <a href="/admin/delete_sale.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this sale?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No sales records found.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
    <!-- [ Footer ] start -->

    <?php include '../includes/footer.php'; ?>
    <!-- [ Footer ] end -->
</main>
<!--! [End] Main Content !-->
<!--! BEGIN: Theme Customizer !-->
<?php include '../includes/theme-customization.php'; ?>
<!--! [End] Theme Customizer !-->