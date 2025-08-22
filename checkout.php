<?php
include 'config.php';
include 'includes/auth.php'; 
include 'includes/db.php';
include 'includes/navbar.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
   exit();
}

if(isset($_POST['order_btn'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = mysqli_real_escape_string($conn, 'street '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products = [];

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   while($cart_item = mysqli_fetch_assoc($cart_query)){
      $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
      $sub_total = ($cart_item['price'] * $cart_item['quantity']);
      $cart_total += $sub_total;
   }

   $total_products = implode(', ',$cart_products);

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }else{
      if($method == "cash on delivery"){
         // Direct COD order placement
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on, payment_status) 
         VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on', 'pending')") 
         or die('query failed');

         $message[] = 'Order placed successfully!';
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      }
      elseif($method == "esewa"){
         // Save pending order in session and redirect to payment
         $_SESSION['pending_order'] = [
            'user_id' => $user_id,
            'name' => $name,
            'number' => $number,
            'email' => $email,
            'address' => $address,
            'total_products' => $total_products,
            'total_price' => $cart_total,
            'placed_on' => $placed_on
         ];

         header("Location: esewa_payment.php");
         exit();
      }
   }
}
?>

<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/checkout.css">
</head>
<body>
<div class="head">

<section class="display-order">
   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo 'Rs: '.$fetch_cart['price'].'/-'.' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
         }
      }else{
         echo '<p class="empty">Your cart is empty</p>';
      }
   ?>
   <div class="grand-total"> Grand total : <span>Rs: <?php echo $grand_total; ?>/-</span> </div>
</section>

<div class="main-form">
<section class="checkout">
   <form action="" method="post">
      <div class="flex">
      <div class="form-content">
      <h3>Place your order</h3>
         <div class="inputBox">
            <span>Your name :</span>
            <input type="text" name="name" required placeholder="Enter your name">
         </div>
         <div class="inputBox">
            <span>Your number :</span>
            <input type="number" name="number" required placeholder="Enter your number">
         </div>
         <div class="inputBox">
            <span>Your email :</span>
            <input type="email" name="email" required placeholder="Enter your email">
         </div>
         <div class="inputBox">
            <span>Payment method :</span>
            <select name="method" required>
               <option value="cash on delivery">Cash On Delivery</option>
               <option value="esewa">eSewa</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Address line 01 :</span>
            <input type="text" class="all" name="street" required placeholder="e.g. street name">
         </div>
         <div class="inputBox">
            <span>City :</span>
            <input type="text" name="city" required placeholder="e.g. Chitwan">
         </div>
         <div class="inputBox">
            <span>State :</span>
            <input type="text" name="Provience" required placeholder="e.g. Bagmati">
         </div>
         <div class="inputBox">
            <span>Country :</span>
            <input type="text" name="country" required placeholder="e.g. Nepal">
         </div>
         <div class="inputBox">
            <span>Pin code :</span>
            <input type="number" min="0" name="pin_code" required placeholder="e.g. 12345">
         </div>
         <div class="button">
            <input type="submit" value="Order Now" class="btn" name="order_btn">
         </div>
      </div>
   </form>
   </div>
</section>
</div>
</body>
</html>
