<?php
include 'connection.php';

$token = $_GET['token'] ?? '';
$error = $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ?, password_reset_token = NULL WHERE password_reset_token = ?");
        $stmt->bind_param("ss", $hashed, $token);
        if ($stmt->execute() && $stmt->affected_rows === 1) {
            $success = "Password reset successfully. <a href='login.php'>Login now</a>";
        } else {
            $error = "Invalid or expired token.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        <?php include 'style.css'; ?>
    </style>
</head>
<body>
    <div class="container">
        <div class="Log_Cont">
            <form method="POST">
                <h2>Reset Password</h2>

                <?php if ($error) echo "<span style='color:red;'>$error</span>"; ?>
                <?php if ($success) echo "<span style='color:green;'>$success</span>"; ?>

                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                <div class="d-flex flex-column gap-1">
                    <label for="password">New Password</label>
                    <input type="password" name="password" required placeholder="Enter new password">
                </div>

                <div class="d-flex flex-column gap-1">
                    <label for="confirm">Confirm Password</label>
                    <input type="password" name="confirm" required placeholder="Confirm password">
                </div>

                <div class="d-flex flex-column gap-1">
                    <button type="submit" class="submit-btn">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
