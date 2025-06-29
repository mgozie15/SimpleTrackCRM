<?php
require '../connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id  = $_POST['customer_id'];
    $product_name = $_POST['product_name'];
    $amount       = $_POST['amount'];
    $sale_date    = $_POST['sale_date'];
    $notes        = $_POST['notes'];
    $created_by   = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO sales (customer_id, product_name, amount, sale_date, notes, created_by) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isdssi", $customer_id, $product_name, $amount, $sale_date, $notes, $created_by);
    $stmt->execute();

    $_SESSION['message'] = "Sale added successfully!";

    header("Location: add_sale.php");
    exit;
}
?>
