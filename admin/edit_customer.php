<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

include '../connection.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM customers WHERE id = $id");
$customer = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE customers SET name=?, email=?, phone=?, timezone=? WHERE id=?");
    $stmt->bind_param("ssssi", $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['timezone'], $id);
    $stmt->execute();
    header("Location: view_customers.php");
    exit;
}
?>

<?php include '../includes/sidebar.php'; ?>
<!--! [Start] Main Content !-->
<main class="nxl-container">
    <div class="nxl-content">



        <div class="card shadow border-0" style="background-color: #fff;">
            <div class="card-header text-white d-flex align-items-center">
                <h4 class="mb-0">Edit Customer</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Name:</label>
                        <input name="name" value="<?= htmlspecialchars($customer['name']) ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <input name="email" type="email" value="<?= htmlspecialchars($customer['email']) ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone:</label>
                        <input name="phone" value="<?= htmlspecialchars($customer['phone']) ?>" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Timezone:</label>
                        <select name="timezone" class="form-select" required>
                            <option value="Asia/Karachi" <?= $customer['timezone'] === 'Asia/Karachi' ? 'selected' : '' ?>>Asia/Karachi</option>
                            <option value="Europe/London" <?= $customer['timezone'] === 'Europe/London' ? 'selected' : '' ?>>Europe/London</option>
                            <option value="America/New_York" <?= $customer['timezone'] === 'America/New_York' ? 'selected' : '' ?>>America/New_York</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/admin/view_customers.php" class="btn btn-outline-dark">Cancel</a>
                        <button type="submit" class="btn btn-dark">Update Customer</button>
                    </div>
                </form>
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