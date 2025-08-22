<?php
session_start();
include 'includes/db.php';
include 'includes/auth.php';

// Get error message (default if not provided)
$error_message = $_GET['error'] ?? 'Your payment could not be processed.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed - Unisex Shoes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        h2 {
            color: #e74c3c;
            margin-bottom: 15px;
        }
        p {
            margin: 10px 0;
            color: #333;
        }
        a {
            display: inline-block;
            margin: 10px;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .retry {
            background: #3498db;
            color: #fff;
        }
        .cart {
            background: #2ecc71;
            color: #fff;
        }
        .home {
            background: #95a5a6;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>❌ Payment Failed!</h2>
    <p><?php echo htmlspecialchars($error_message); ?></p>
    <p>If the amount was deducted, please contact our support team with your transaction details.</p>
    
    <a href="checkout.php" class="retry">🔄 Retry Payment</a>
    <a href="cart.php" class="cart">🛒 Return to Cart</a>
    <a href="index.php" class="home">🏠 Continue Shopping</a>
</div>
</body>
</html>
