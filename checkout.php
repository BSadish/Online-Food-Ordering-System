<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = mysqli_real_escape_string($conn, 'street '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ',$cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }else{
      if(mysqli_num_rows($order_query) > 0){
         $message[] = 'order already placed!'; 
      }else{
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
         $message[] = 'order placed successfully!';
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
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
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/checkout.css">

</head>
<body>
   


<div class="head">

<section class="display-order ">

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
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   <div class="grand-total"> Grand total : <span>Rs: <?php echo $grand_total; ?>/-</span> </div>
   </div>
</section>
<div class="main-form">
<section class="checkout ">

   <form action="" method="post">
    
      
      <div class="flex">
      <div class="form-content">
      <h3>Place your order</h3>
         <div class="inputBox">
            <span>Your name :</span>
            <input type="text" name="name" required placeholder="enter your name">
         </div>
         <div class="inputBox">
            <span>Your number :</span>
            <input type="number" name="number" required placeholder="enter your number">
         </div>
         <div class="inputBox">
            <span>Your email :</span>
            <input type="email" name="email" required placeholder="enter your email">
         </div>
         <div class="inputBox">
            <span>Payment method :</span>
            <select name="method">
               <option value="cash on delivery" >Cash On Delivery</option>
               <!-- <option value="credit card">credit card</option>
               <option value="paypal">paypal</option>
               <option value="paytm">paytm</option> -->
            </select>
         </div>
         <!-- <div class="inputBox">
            <span>Address line 01 :</span>
            <input type="number" min="0" name="flat" required placeholder="e.g. flat no.">
         </div> -->
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
            <input type="number" min="0" name="pin_code" required placeholder="e.g. 123456">
         </div>
         <div class="button">
         <input type="submit" value="Order Now" class="btn" name="order_btn">
         </div>
      </div>
      
   </form>
   </div>
   </div>
</section>











<!-- custom js file link  -->
<script>
   document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");
  const nameInput = form.querySelector("input[name='name']");
  const numberInput = form.querySelector("input[name='number']");
  const emailInput = form.querySelector("input[name='email']");
  const streetInput = form.querySelector("input[name='street']");
  const cityInput = form.querySelector("input[name='city']");
  const stateInput = form.querySelector("input[name='Provience']");
  const countryInput = form.querySelector("input[name='country']");
  const pinCodeInput = form.querySelector("input[name='pin_code']");
  
  // Function to show error messages
  const showError = (input, message) => {
    let errorDiv = input.nextElementSibling;
    if (!errorDiv || !errorDiv.classList.contains("error-message")) {
      errorDiv = document.createElement("div");
      errorDiv.className = "error-message";
      input.parentElement.appendChild(errorDiv);
    }
    errorDiv.textContent = message;
    input.classList.add("invalid");
  };

  // Function to remove error messages
  const removeError = (input) => {
    const errorDiv = input.nextElementSibling;
    if (errorDiv && errorDiv.classList.contains("error-message")) {
      errorDiv.remove();
    }
    input.classList.remove("invalid");
  };

  // Validate fields
  const validateName = () => {
    const value = nameInput.value.trim();
    if (value.length < 3 || !/^[a-zA-Z ]+$/.test(value)) {
      showError(nameInput, "Name must be at least 3 characters long ");
      return false;
    }
    removeError(nameInput);
    return true;
  };

  const validateNumber = () => {
    const value = numberInput.value.trim();
    const regex = /^(98|97)\d{8}$/;
    if (!regex.test(value)) {
      showError(numberInput, "Number must be 10 digits and start with 98 or 97.");
      return false;
    }
    removeError(numberInput);
    return true;
  };

  const validateEmail = () => {
    const value = emailInput.value.trim();
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regex.test(value)) {
      showError(emailInput, "Enter a valid email address.");
      return false;
    }
    removeError(emailInput);
    return true;
  };

  const validateRequiredField = (input, message) => {
    const value = input.value.trim();
    if (!value) {
      showError(input, message);
      return false;
    }
    removeError(input);
    return true;
  };

  // Address line validation (alphanumeric, spaces)
  const validateAddress = () => {
    const value = streetInput.value.trim();
    if (value.length < 4 || !/^[a-zA-Z0-9\s,.-]+$/.test(value)) {
      showError(streetInput, "Address line must be at least 4 characters long .");
      return false;
    }
    removeError(streetInput);
    return true;
  };

  // Validate city, state, and country for alphabetic characters and minimum length of 4
  const validateCityStateCountry = (input, fieldName) => {
    const value = input.value.trim();
    if (value.length < 4 || !/^[a-zA-Z\s]+$/.test(value)) {
      showError(input, `${fieldName} Must be at least 4 characters long `);
      return false;
    }
    removeError(input);
    return true;
  };

  const validatePinCode = () => {
    const value = pinCodeInput.value.trim();
    const regex = /^\d{5}$/;
    if (!regex.test(value)) {
      showError(pinCodeInput, "Pin code must be 5 digits.");
      return false;
    }
    removeError(pinCodeInput);
    return true;
  };

  // Real-time validation
  nameInput.addEventListener("input", validateName);
  numberInput.addEventListener("input", validateNumber);
  emailInput.addEventListener("input", validateEmail);
  streetInput.addEventListener("input", validateAddress);
  cityInput.addEventListener("input", () => validateCityStateCountry(cityInput, "City"));
  stateInput.addEventListener("input", () => validateCityStateCountry(stateInput, "State"));
  countryInput.addEventListener("input", () => validateCityStateCountry(countryInput, "Country"));
  pinCodeInput.addEventListener("input", validatePinCode);

  // Form submission validation
  form.addEventListener("submit", (e) => {
    const isValid =
      validateName() &&
      validateNumber() &&
      validateEmail() &&
      validateAddress() &&
      validateCityStateCountry(cityInput, "City") &&
      validateCityStateCountry(stateInput, "State") &&
      validateCityStateCountry(countryInput, "Country") &&
      validatePinCode();

    if (!isValid) {
      e.preventDefault();
    }
  });
});

</script>
   
</body>
</html>