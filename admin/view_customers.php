<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
include '../connection.php';
// $customers = $conn->query("SELECT * FROM customers ORDER BY id DESC");
$userId = $_SESSION['user_id'];
$customers = $conn->query("SELECT * FROM customers WHERE created_by = $userId ORDER BY id DESC");

?>
<style>
    .table-responsive .table{
        width: 95% !important;
        margin: auto !important;
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
                    <li class="breadcrumb-item"><a href="/admin/view_customers.php">All Customers</a></li>
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

        <div class="card border-0 shadow-sm" style="background-color: #ffffff;">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-black">All Customers</h4>
                <a href="/admin/add_customer.php" class="btn btn-dark">+ Add New Customer</a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-black mb-0">
                        <thead class="table-light border-bottom border-dark-subtle">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Timezone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $customers->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars($row['phone']) ?></td>
                                    <td><?= htmlspecialchars($row['timezone']) ?></td>
                                    <td>
                                        <a href="/admin/edit_customer.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                                        <a href="/admin/delete_customer.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this customer?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                            <?php if ($customers->num_rows === 0): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No customers found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
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