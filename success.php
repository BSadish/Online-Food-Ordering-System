<?php
session_start();
include 'includes/db.php';
include 'includes/auth.php';

if (!isset($_SESSION['pending_order']) || !isset($_SESSION['transaction_uuid'])) {
    header("Location: failure.php?error=no_order_found");
    exit();
}

$order = $_SESSION['pending_order'];
$total_amount = $order['total_price'];
$transaction_uuid = $_SESSION['transaction_uuid'];

// eSewa verification
$product_code = "EPAYTEST";
$verify_url = "https://rc.esewa.com.np/api/epay/transaction/status/?" .
              "product_code={$product_code}&" .
              "total_amount={$total_amount}&" .
              "transaction_uuid={$transaction_uuid}";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $verify_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_FOLLOWLOCATION => true,
]);

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);
$payment_status = $data['status'] ?? 'FAILED';
$reference_id = $data['transaction_code'] ?? '';

if ($payment_status === "COMPLETE") {
    $stmt = $conn->prepare("INSERT INTO payments (transaction_uuid, reference_id, amount, status, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssis", $transaction_uuid, $reference_id, $total_amount, $payment_status);
    $stmt->execute();
    $stmt->close();

    // Clear session & cart
    unset($_SESSION['cart']);
    unset($_SESSION['pending_order']);
    unset($_SESSION['transaction_uuid']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo ($payment_status === "COMPLETE") ? "Payment Successful" : "Payment Failed"; ?></title>
</head>
<body>
<div class="container">
    <?php if ($payment_status === "COMPLETE") { ?>
        <h2>✅ Payment Successful!</h2>
        <p>Transaction ID: <?php echo htmlspecialchars($transaction_uuid); ?></p>
        <p>Reference ID: <?php echo htmlspecialchars($reference_id); ?></p>
        <p>Amount Paid: Rs <?php echo htmlspecialchars($total_amount); ?></p>
        <p>Thank you for shopping with us.</p>
        <a href="index.php">Continue Shopping</a>
    <?php } else { ?>
        <h2>❌ Payment Failed!</h2>
        <p>Your payment could not be verified.</p>
        <a href="checkout.php">Retry Payment</a>
    <?php } ?>
</div>
</body>
</html>
