<?php
require '../connection.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Fetch customers for dropdown
$customers = $conn->query("SELECT id, name FROM customers");
?>

<?php include '../includes/sidebar.php'; ?>
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
                    <li class="breadcrumb-item"><a href="/admin/add_sale.php">Add Sale</a></li>
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
                <h4 class="mb-0 text-black">Add Sale</h4>
            </div>

            <div class="card-body">
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['message']; ?>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>

                <form method="POST" action="/admin/insert_sale.php">
                    <div class="mb-3">
                        <label for="customer" class="form-label text-black">Customer</label>
                        <select name="customer_id" id="customer" class="form-select border-dark-subtle" required>
                            <?php while ($row = $customers->fetch_assoc()) { ?>
                                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="product_name" class="form-label text-black">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control border-dark-subtle" required>
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label text-black">Amount</label>
                        <input type="number" step="0.01" name="amount" id="amount" class="form-control border-dark-subtle" required>
                    </div>

                    <div class="mb-3">
                        <label for="sale_date" class="form-label text-black">Sale Date</label>
                        <input type="date" name="sale_date" id="sale_date" class="form-control border-dark-subtle" required>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label text-black">Notes</label>
                        <textarea name="notes" id="notes" class="form-control border-dark-subtle" rows="3"></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-dark">Add Sale</button>
                        <a href="/admin/view_sales.php" class="btn btn-outline-dark">View All Sales</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- [ Main Content ] end -->
    </div>
    <!-- [ Footer ] start -->

    <?php include '../includes/footer.php'; ?>
    <!-- [ Footer ] end -->
</main>
<!--! [End] Main Content !-->
<!--! BEGIN: Theme Customizer !-->
<?php include '../includes/theme-customization.php'; ?>
<!--! [End] Theme Customizer !-->