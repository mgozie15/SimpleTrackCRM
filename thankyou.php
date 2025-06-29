<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f0f2f5, #e0e7ff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .thankyou-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        .thankyou-icon {
            font-size: 60px;
            color: #4CAF50;
        }
        .thankyou-message h1 {
            font-size: 32px;
            font-weight: 700;
            margin-top: 20px;
        }
        .thankyou-message p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }
        .btn-custom {
            padding: 10px 25px;
            font-size: 16px;
            border-radius: 30px;
        }
    </style>
</head>
<body>

<div class="thankyou-container">
    <div class="thankyou-icon">
        ✅
    </div>
    <div class="thankyou-message">
        <h1>Thank You!</h1>
        <p>Your registration was successful.<br>We’ve sent a verification email to your inbox.</p>
                <a href="login.php" class="btn btn-primary btn-custom">Please Login First</a>
    </div>
</div>

</body>
</html>
