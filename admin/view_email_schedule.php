<?php
require '../connection.php';
session_start();

$userId = $_SESSION['user_id'];

$userId = $_SESSION['user_id'];
$result = $conn->query("SELECT e.*, c.name 
                        FROM email_schedule e
                        JOIN customers c ON e.customer_id = c.id
                        WHERE e.created_by = $userId
                        ORDER BY e.scheduled_time_utc DESC");

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
                    <li class="breadcrumb-item"><a href="/admin/view_email_schedule.php">Schedule Email</a></li>
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
            <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                <h4 class="mb-0 text-black">Scheduled Emails</h4>
                <a href="/admin/schedule_email.php" class="btn btn-dark">Schedule Email</a>
            </div>

            <div class="card-body">
                <?php if ($result->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-black">
                            <thead class="table-light border-bottom border-dark-subtle">
                                <tr>
                                    <th>Customer</th>
                                    <th>Subject</th>
                                    <th>Scheduled Time (UTC)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars(mb_strimwidth($row['subject'], 0, 90, '...')) ?></td>
                                        <td><?= htmlspecialchars($row['scheduled_time_utc']) ?></td>
                                        <td>
                                            <?php if ($row['sent']): ?>
                                                <span class="badge bg-success">Sent</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No scheduled emails found.</p>
                <?php endif; ?>
            </div>
        </div>



    </div>
    <?php include '../includes/footer.php'; ?>

</main>
<?php include '../includes/theme-customization.php'; ?>