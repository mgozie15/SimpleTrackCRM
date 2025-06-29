<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'connection.php';

// Get summary data
// $totalCustomers = $conn->query("SELECT COUNT(*) AS total FROM customers")->fetch_assoc()['total'];
// $totalSales = $conn->query("SELECT COUNT(*) AS total FROM sales")->fetch_assoc()['total'];
// $pendingFollowUps = $conn->query("SELECT COUNT(*) AS total FROM follow_ups WHERE status = 'pending'")->fetch_assoc()['total'];

$userId = $_SESSION['user_id'];

$totalCustomers = $conn->query("SELECT COUNT(*) AS total FROM customers WHERE created_by = $userId")->fetch_assoc()['total'];
$totalSales = $conn->query("SELECT COUNT(*) AS total FROM sales WHERE created_by = $userId")->fetch_assoc()['total'];

?>

<?php include 'includes/sidebar.php'; ?>
<!--! [Start] Main Content !-->
<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin_dashboard.php">Home</a></li>
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
        <!-- [ page-header ] end -->
        <!-- [ Main Content ] start -->
        <div class="main-content">
            <div class="row">
                <!-- [Total Customers] start -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-4">
                                <div class="d-flex gap-4 align-items-center">
                                    <div class="avatar-text avatar-lg bg-gray-200">
                                        <i class="feather-users"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark"><?= $totalCustomers ?></div>
                                        <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Customers</h3>
                                    </div>
                                </div>
                                <a href="/admin/add_customer.php" class="">
                                    <i class="feather-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [Total Customers] end -->

                <!-- [Total Sales] start -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-4">
                                <div class="d-flex gap-4 align-items-center">
                                    <div class="avatar-text avatar-lg bg-gray-200">
                                        <i class="feather-shopping-cart"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark"><?= number_format($totalSales) ?></div>
                                        <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Sales</h3>
                                    </div>
                                </div>
                                <a href="/admin/add_sale.php" class="">
                                    <i class="feather-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [Total Sales] end -->
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
    <!-- [ Footer ] start -->

    <?php include 'includes/footer.php'; ?>
    <!-- [ Footer ] end -->
</main>
<!--! [End] Main Content !-->
<!--! BEGIN: Theme Customizer !-->
<?php include 'includes/theme-customization.php'; ?>
<!--! [End] Theme Customizer !-->
