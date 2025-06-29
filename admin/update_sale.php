<?php
require '../connection.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $customer_id = $_POST['customer_id'];
    $product_name = $_POST['product_name'];
    $amount = $_POST['amount'];
    $sale_date = $_POST['sale_date'];
    $notes = $_POST['notes'];

    $stmt = $conn->prepare("UPDATE sales SET customer_id=?, product_name=?, amount=?, sale_date=?, notes=? WHERE id=?");
    $stmt->bind_param("isdssi", $customer_id, $product_name, $amount, $sale_date, $notes, $id);
    $stmt->execute();

    header("Location: view_sales.php");
    exit;
}
?>