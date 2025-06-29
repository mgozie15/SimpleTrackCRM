<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
include '../connection.php';

$message = '';

// On form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $timezone = $_POST['timezone'];
    $userId   = $_SESSION['user_id'];

    // Check if email exists
    $checkStmt = $conn->prepare("SELECT id FROM customers WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $_SESSION['message'] = "This email already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO customers (name, email, phone, timezone, created_by) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $name, $email, $phone, $timezone, $userId);
        $stmt->execute();
        $_SESSION['message'] = "Customer added successfully!";
    }

    // Redirect to same page to prevent resubmission
    header("Location: add_customer.php");
    exit;
}

// On page load, show message
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Remove after showing
}
?>




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
                    <li class="breadcrumb-item"><a href="/admin/add_customer.php">Add Customers</a></li>
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
        <div class="card shadow p-2">
            <div class="card border-0 shadow-sm" style="background-color: #ffffff;">
                <div class="card-header bg-white border-bottom">
                    <h4 class="mb-0 text-black">Add New Customer</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($message)) : ?>
                        <div class="alert alert-info">
                            <?= $message ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label text-black">Name</label>
                            <input name="name" class="form-control border-dark-subtle" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-black">Email</label>
                            <input name="email" type="email" class="form-control border-dark-subtle" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-black">Phone</label>
                            <input name="phone" class="form-control border-dark-subtle">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-black">Timezone</label>
                            <select name="timezone" class="form-select border-dark-subtle" required>
                                <option value="Europe/Dublin">Europe/Dublin (Ireland)</option>
                                <option value="Asia/Karachi">Asia/Karachi</option>
                                <option value="Europe/London">Europe/London</option>
                                <option value="America/New_York">America/New_York</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-dark">Add Customer</button>
                            <a href="/admin/view_customers.php" class="btn btn-outline-dark">View All Customers</a>
                        </div>
                    </form>
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