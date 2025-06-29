<?php
include 'connection.php';

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);

    $query = "SELECT * FROM users WHERE email_verification_token = '$token' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        $update = "UPDATE users SET email_verified = 1, email_verification_token = NULL WHERE id = {$user['id']}";
        if (mysqli_query($conn, $update)) {
            header("Location: login.php?verified=1");
            exit;
        } else {
            echo "Failed to verify your email. Please try again.";
        }
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "No token provided.";
}
?>
