<?php
session_start();
include 'includes/db.php';
include 'includes/auth.php';

if (!isset($_SESSION['pending_order'])) {
    die("No pending order found.");
}

$order = $_SESSION['pending_order'];
$total = $order['total_price'];

// eSewa Sandbox Config
$secret_key = "8gBm/:&EnhH.1/q"; 
$product_code = "EPAYTEST"; 
$transaction_uuid = uniqid("TXN_");

// Store transaction UUID for verification
$_SESSION['transaction_uuid'] = $transaction_uuid;

$success_url = "http://localhost/Project%20Demo%201/success.php";
$failure_url = "http://localhost/Project%20Demo%201/failure.php";

// Required data
$data = [
    'amount' => $total,
    'tax_amount' => 0,
    'total_amount' => $total,
    'transaction_uuid' => $transaction_uuid,
    'product_code' => $product_code,
    'product_service_charge' => 0,
    'product_delivery_charge' => 0,
    'success_url' => $success_url,
    'failure_url' => $failure_url,
];

// Generate signature
$signing_string = "total_amount={$data['total_amount']},transaction_uuid={$data['transaction_uuid']},product_code={$data['product_code']}";
$signature = base64_encode(hash_hmac('sha256', $signing_string, $secret_key, true));
?>
<!DOCTYPE html>
<html>
<head>
    <title>eSewa Payment</title>
</head>
<body>
<h2>Redirecting to eSewa...</h2>
<form method="POST" action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" id="esewaForm">
    <?php foreach ($data as $key => $value): ?>
        <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
    <?php endforeach; ?>
    <input type="hidden" name="signed_field_names" value="total_amount,transaction_uuid,product_code">
    <input type="hidden" name="signature" value="<?php echo $signature; ?>">
</form>
<script>
    document.getElementById("esewaForm").submit();
</script>
</body>
</html>
