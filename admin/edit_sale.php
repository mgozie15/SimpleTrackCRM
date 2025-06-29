<?php
require '../connection.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Sale ID not provided.");
}

$id = $_GET['id'];
$sale = $conn->query("SELECT * FROM sales WHERE id = $id")->fetch_assoc();
$customers = $conn->query("SELECT id, name FROM customers");
?>
<?php include '../includes/sidebar.php'; ?>
<!--! [Start] Main Content !-->
<main class="nxl-container">
    <div class="nxl-content">


             <div class="card border-0 shadow-sm" style="background-color: #ffffff;">
            <div class="card-header bg-white border-bottom">
                <h4 class="mb-0 text-black">Edit Sale</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="/admin/update_sale.php">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($sale['id']) ?>">

                    <div class="mb-3">
                        <label class="form-label">Customer</label>
                        <select name="customer_id" class="form-select" required>
                            <?php while ($row = $customers->fetch_assoc()) { ?>
                                <option value="<?= $row['id'] ?>" <?= $row['id'] == $sale['customer_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['name']) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="product_name" class="form-control"
                            value="<?= htmlspecialchars($sale['product_name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" name="amount" class="form-control"
                            value="<?= htmlspecialchars($sale['amount']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sale Date</label>
                        <input type="date" name="sale_date" class="form-control"
                            value="<?= htmlspecialchars($sale['sale_date']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="4"><?= htmlspecialchars($sale['notes']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/admin/view_sales.php" class="btn btn-outline-dark">Cancel</a>
                        <button type="submit" class="btn btn-dark">Update Sale</button>
                    </div>
                </form>
            </div>
        </div>


    </div>
    <?php include '../includes/footer.php'; ?>
    <!-- [ Footer ] end -->
</main>
<!--! [End] Main Content !-->
<!--! BEGIN: Theme Customizer !-->
<?php include '../includes/theme-customization.php'; ?>
<!--! [End] Theme Customizer !-->