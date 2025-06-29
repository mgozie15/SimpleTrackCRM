<?php
include 'connection.php';
require '/home/rawrear/public_html/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $update = $conn->prepare("UPDATE users SET password_reset_token = ? WHERE email = ?");
        $update->bind_param("ss", $token, $email);
        $update->execute();

        $resetLink = "https://rawrear.com/reset_password.php?token=$token";

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'mail.rawrear.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@rawrear.com';
        $mail->Password = 'x?y5Z7OdQ6!8T?EF';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('noreply@rawrear.com', 'SimpleTrack CRM');
        $mail->addAddress($email, $user['name']);
        $mail->Subject = 'Reset Your Password';
        $mail->Body = "Hi {$user['name']},\n\nClick the link below to reset your password:\n$resetLink";

        if ($mail->send()) {
            $msg = "Reset link has been sent to your email.";
        } else {
            $msg = "Failed to send reset email.";
        }
    } else {
        $msg = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        <?php include 'style.css'; ?>
    </style>
</head>
<body>
    <div class="container">
        <div class="Log_Cont">
            <form method="POST">
                <h2>Forgot Password</h2>

                <?php if (!empty($msg)) echo "<span style='color:green;'>$msg</span>"; ?>

                <div class="d-flex flex-column gap-1">
                    <label for="email">Enter your email</label>
                    <input type="email" name="email" required placeholder="Enter your email">
                </div>

                <div class="d-flex flex-column gap-1">
                    <button type="submit" class="submit-btn">Send Reset Link</button>
                    <span><a href="login.php">Back to Login</a></span>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
