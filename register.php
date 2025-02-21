<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = $_POST['user_type'];

   $select = mysqli_query($conn, "SELECT * FROM `user_info` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'User already exists!';
   } else {
      if($pass != $cpass){
         $message[] = 'Passwords do not match!';
      } else {
         mysqli_query($conn, "INSERT INTO `user_info`(name, email, password, user_type) VALUES('$name', '$email', '$pass', '$user_type')") or die('query failed');
         $message[] = 'Registered successfully!';
         header('location:login.php');
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/styleme.css">

   <style>
      .strength {
         display: block;
         font-size: 0.9em;
         margin-top: 5px;
      }
      .low {
         color: red;
      }
      .medium {
         color: orange;
      }
      .high {
         color: green;
      }
   </style>
   <script>
      // Validate Name
      function validateName() {
         const name = document.getElementById('name').value;
         const nameError = document.getElementById('nameError');

         const nameRegex = /^[A-Za-z]{4}/;

   if (!nameRegex.test(name)) {
      nameError.textContent = "Name must start with at least 4 alphabetic characters.";
      return false;
   } else {
      nameError.textContent = "";
      return true;
   }
}

      // Validate Email
      function validateEmail() {
         const email = document.getElementById('email').value;
         const emailError = document.getElementById('emailError');
         const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

         if (!emailRegex.test(email)) {
            emailError.textContent = "Please enter a valid email address.";
            return false;
         } else {
            emailError.textContent = "";
            return true;
         }
      }

      
      // Password Validation with Strength Indicator
      function checkPasswordStrength() {
         const password = document.getElementById('password').value;
         const strength = document.getElementById('strength');
         const upperCase = /[A-Z]/;
         const lowerCase = /[a-z]/;
         const number = /[0-9]/;
         const specialChar = /[\W]/; // Special characters

         let isValid = password.length >= 8 &&
                       upperCase.test(password) &&
                       lowerCase.test(password) &&
                       number.test(password) &&
                       specialChar.test(password);

         if (!isValid) {
            strength.textContent = "Password must be at least 8 characters long, include uppercase, lowercase, a number, and a special character.";
            strength.className = "strength low";
            return false;
         } else {
            strength.textContent = "Valid password!";
            strength.className = "strength high";
            return true;
         }
      }

      // Confirm Password Match
      function validateConfirmPassword() {
         const password = document.getElementById('password').value;
         const confirmPassword = document.getElementById('cpassword').value;
         const cpassError = document.getElementById('cpassError');

         if (password !== confirmPassword) {
            cpassError.textContent = "Passwords do not match.";
            return false;
         } else {
            cpassError.textContent = "";
            return true;
         }
      }

      // Final Form Validation
      function validateForm() {
         return validateName() && validateEmail() && validateConfirmPassword();
      }
   </script>
</head>
<body>

<?php
if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<div class="form-container">

   <form action="" method="post" onsubmit="return validateForm();">
      <h3>Register Now</h3>
      <input type="text" id="name" name="name" required placeholder="Enter username" class="box" oninput="validateName();">
      <span id="nameError" style="color: red; font-size: 0.9em;"></span>

      <input type="email" id="email" name="email" required placeholder="Enter email" class="box" oninput="validateEmail();">
      <span id="emailError" style="color: red; font-size: 0.9em;"></span>

      <input type="password" id="password" name="password" required placeholder="Enter password" class="box" oninput="checkPasswordStrength();">
      <span id="strength" class="strength"></span>

      <input type="password" id="cpassword" name="cpassword" required placeholder="Confirm password" class="box" oninput="validateConfirmPassword();">
      <span id="cpassError" style="color: red; font-size: 0.9em;"></span>

      <select name="user_type" class="box">
         <option value="user">User</option>
         <option value="admin">Admin</option>
      </select>
      <input type="submit" name="submit" class="btn" value="Register Now">
      <p>Already have an account? <a href="login.php">Login Now</a></p>
   </form>

</div>

</body>
</html>
