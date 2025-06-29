<?php
require '../connection.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// $customers = $conn->query("SELECT id, name, timezone FROM customers");

$userId = $_SESSION['user_id'];
$customers = $conn->query("SELECT id, name, timezone FROM customers WHERE created_by = $userId ORDER BY name ASC");
?>
<?php include '../includes/sidebar.php'; ?>
<main class="nxl-container">
    <div class="container mt-4">
         <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/schedule_email.php">Email</a></li>
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
            <div class="card-header bg-white border-bottom">
                <h4 class="mb-0 text-black">Schedule Follow-up Email</h4>
            </div>

            <div class="card-body">
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['message']; ?>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>
                <form action="/admin/insert_email_schedule.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label text-black">Customer</label>
                        <select name="customer_id" class="form-select border-dark-subtle" required>
                            <?php while ($row = $customers->fetch_assoc()) { ?>
                                <option value="<?= $row['id'] ?>">
                                    <?= htmlspecialchars($row['name']) ?> (<?= htmlspecialchars($row['timezone']) ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-black">Subject</label>
                        <input type="text" name="subject" class="form-control border-dark-subtle" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-black">Body</label>
                        <textarea name="body" rows="5" class="form-control border-dark-subtle" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-black">Local Time to Send</label>
                        <input type="datetime-local" name="local_time" class="form-control border-dark-subtle" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-dark">Schedule Email</button>
                        <a href="/admin/view_email_schedule.php" class="btn btn-outline-dark">View All Scheduled Emails</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <?php include '../includes/footer.php'; ?>

</main>
<?php include '../includes/theme-customization.php'; ?>