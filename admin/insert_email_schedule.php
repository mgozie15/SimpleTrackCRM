<?php
require '../connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $subject     = $_POST['subject'];
    $body        = $_POST['body'];
    $local_time  = $_POST['local_time'];
    $created_by  = $_SESSION['user_id'];

    // Get customer timezone
    $tz_result = $conn->query("SELECT timezone FROM customers WHERE id = $customer_id")->fetch_assoc();
    $timezone  = $tz_result['timezone'];

    // Convert local time to UTC
    $date = new DateTime($local_time, new DateTimeZone($timezone));
    $date->setTimezone(new DateTimeZone('UTC'));
    $scheduled_time_utc = $date->format('Y-m-d H:i:s');

    // Insert with created_by
    $stmt = $conn->prepare("INSERT INTO email_schedule (customer_id, subject, body, scheduled_time_utc, created_by)
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $customer_id, $subject, $body, $scheduled_time_utc, $created_by);
    $stmt->execute();

    $_SESSION['message'] = "Email scheduled successfully!";
    header("Location: schedule_email.php");
    exit;
}
?>
