<?php
require '/home/rawrear/public_html/connection.php';
require '/home/rawrear/public_html/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/home/rawrear/public_html/admin/email_cron_error.log');
error_reporting(E_ALL);

// Log cron start
file_put_contents('/home/rawrear/public_html/admin/cron_check.log', date('Y-m-d H:i:s') . " - Cron started\n", FILE_APPEND);

$now = date('Y-m-d H:i:s');

// Execute query
$result = $conn->query("SELECT e.*, c.email FROM email_schedule e
                        JOIN customers c ON e.customer_id = c.id
                        WHERE e.scheduled_time_utc <= '$now' AND e.sent = 0");

if (! $result) {
    error_log("DB Error: " . $conn->error . "\n", 3, '/home/rawrear/public_html/admin/email_cron_error.log');
    exit;
}

if ($result->num_rows === 0) {
    file_put_contents('/home/rawrear/public_html/admin/cron_check.log', "No emails to send\n", FILE_APPEND);
    exit;
}

while ($row = $result->fetch_assoc()) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'mail.rawrear.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@rawrear.com';
        $mail->Password = 'x?y5Z7OdQ6!8T?EF';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('noreply@rawrear.com', 'SimpleTrack CRM');
        $mail->addAddress($row['email']);
        $mail->Subject = $row['subject'];
        $mail->Body = $row['body'];

        if ($mail->send()) {
            $conn->query("UPDATE email_schedule SET sent = 1 WHERE id = {$row['id']}");
            file_put_contents('/home/rawrear/public_html/admin/cron_check.log', "Email sent to {$row['email']}\n", FILE_APPEND);
        } else {
            file_put_contents('/home/rawrear/public_html/admin/cron_check.log', "Failed to send email to {$row['email']}\n", FILE_APPEND);
        }

    } catch (Exception $e) {
        error_log("Email failed to {$row['email']}: " . $mail->ErrorInfo . "\n", 3, '/home/rawrear/public_html/admin/email_cron_error.log');
    }
}
?>
