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

         if (name.length < 3) {
            nameError.textContent = "Name must be at least 3 characters.";
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

      // Password Strength Checker
      function checkPasswordStrength() {
         const password = document.getElementById('password').value;
         const strength = document.getElementById('strength');
         const low = /[a-z]/;
         const medium = /[A-Z0-9]/;
         const high = /[@$!%*?&#]/;

         let strengthLevel = 0;

         if (low.test(password)) strengthLevel++;
         if (medium.test(password)) strengthLevel++;
         if (high.test(password)) strengthLevel++;

         if (password.length < 6) {
            strength.textContent = "Strength: Low (Too short)";
            strength.className = "strength low";
         } else if (strengthLevel === 1) {
            strength.textContent = "Strength: Low";
            strength.className = "strength low";
         } else if (strengthLevel === 2) {
            strength.textContent = "Strength: Medium";
            strength.className = "strength medium";
         } else if (strengthLevel === 3) {
            strength.textContent = "Strength: High";
            strength.className = "strength high";
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
