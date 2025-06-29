<?php
require '../connection.php';
session_start();
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];
$conn->query("DELETE FROM sales WHERE id = $id");

header("Location: view_sales.php");
exit;
?>