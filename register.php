<?php
include 'connection.php';
require '/home/rawrear/public_html/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

$name = $email = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(32));
        
        $query = "INSERT INTO users (name, email, password, email_verification_token) VALUES ('$name', '$email', '$hashed_password', '$token')";
        
        
         if (mysqli_query($conn, $query)) {
            // Send verification email
            $verifyUrl = "https://rawrear.com/verify_email.php?token=$token";

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'mail.rawrear.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply@rawrear.com';
            $mail->Password = 'x?y5Z7OdQ6!8T?EF';
            // $mail->SMTPSecure = 'tls';
            // $mail->Port = 587;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;


            $mail->setFrom('noreply@rawrear.com', 'SimpleTrack CRM');
            $mail->addAddress($email, $name);
            $mail->Subject = 'Email Verification';
            $mail->Body = "Hi $name,\n\nPlease verify your email by clicking the link below:\n\n$verifyUrl";

            if ($mail->send()) {
                header("Location: thankyou.php"); // Show a message to check email
                exit();
            } else {
                // $error = "Registration successful, but failed to send email.";
                $error = "Registration successful, but failed to send email. Mailer Error: " . $mail->ErrorInfo;
            }
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}

        // if (mysqli_query($conn, $query)) {
        //     header("Location: index.php");
        //     exit();
        // } else {
        //     $error = "Error: " . mysqli_error($conn);
        // }
    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        <?php include 'style.css'; ?>
    </style>
</head>

<body>
    <div class="container">
        <div class="Log_Cont">
            <form method="POST" action="register.php">
                <h2>Register</h2>

                <?php if (!empty($error)): ?>
                    <div style="color:red;"><?php echo $error; ?></div>
                <?php endif; ?>

                <div class="d-flex flex-column gap-1">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required placeholder="Enter your full name">
                </div>

                <div class="d-flex flex-column gap-1">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required placeholder="Enter your email">
                </div>

                <div class="d-flex flex-column gap-1">
                    <label for="password">Password</label>
                    <input type="password" name="password" required placeholder="Create a password">
                </div>

                <div class="d-flex flex-column gap-1">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" required placeholder="Confirm your password">
                </div>

                <div class="options d-flex justify-content-between align-items-center">
                    <label><input type="checkbox" name="terms" > I agree to the Terms & Conditions</label>
                    <a href="login.php">Already have an account? Login</a>
                </div>

                <div class="d-flex flex-column gap-1">
                    <button type="submit" name="submit-btn" class="submit-btn">Register</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>