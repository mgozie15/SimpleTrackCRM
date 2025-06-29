<?php
session_start();
include 'connection.php';

$email_error = "";
$pass_error = "";

// If user already logged in, redirect
if (isset($_SESSION['user_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        if ((int)$user['email_verified'] !== 1) {
            echo "<p style='color:red;'>Please verify your email before logging in.</p>";
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            header("Location: admin_dashboard.php");
            exit;
        }
    } else {
        echo "<p style='color:red;'>Invalid credentials</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        <?php include 'style.css'; ?>
    </style>
</head>

<body>
    <div class="container">
        <div class="Log_Cont">
            <?php if (isset($_GET['verified']) && $_GET['verified'] == 1): ?>
                <div class="alert alert-success">Your email has been verified. You can now log in.</div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <h2>Login</h2>

                <div class="d-flex flex-column gap-1">
                    <label for="email">Email</label>
                    <input type="email" name="email" required placeholder="Enter your email">
                    <span style="color:red;"><?php echo $email_error; ?></span>
                </div>

                <div class="d-flex flex-column gap-1">
                    <label for="password">Password</label>
                    <input type="password" name="password" required placeholder="Enter your password">
                    <span style="color:red;"><?php echo $pass_error; ?></span>
                </div>

                <div class="options d-flex justify-content-between align-items-center">
                    <label><input type="checkbox" name="remember"> Remember me</label>
                    <a href="forgot_password.php">Forgot password?</a>
                </div>

                <div class="d-flex flex-column gap-1">
                    <button type="submit" class="submit-btn">Login</button>
                    <span>Or</span>
                    <a href="register.php" class="submit-btn text-center">Register</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>