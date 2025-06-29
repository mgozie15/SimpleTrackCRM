<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
include '../connection.php';
$id = $_GET['id'];
$conn->query("DELETE FROM email_schedule WHERE customer_id = $id");
$conn->query("DELETE FROM sales WHERE customer_id = $id"); // Add this line
$conn->query("DELETE FROM customers WHERE id = $id");
header("Location: view_customers.php");
exit;
?>
