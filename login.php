<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `user_info` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){

      $row = mysqli_fetch_assoc($select);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:index.php');

      }
   }
   
   else{
      $message[] = 'Incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/styleme.css">
   <script>
      function validateForm() {
         const email = document.forms["loginForm"]["email"].value;
         const password = document.forms["loginForm"]["password"].value;
         const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

         // Check if email is in the correct format
         if (!emailRegex.test(email)) {
            alert("Please enter a valid email address.");
            return false;
         }

         // Check if password field is empty
         if (password.length === 0) {
            alert("Please enter your password.");
            return false;
         }

         return true;
      }
   </script>
</head>
<body>

<?php
if(isset($message)){
   foreach($message as $msg){
      echo '<div class="message"> 
               <span>'.$msg.'</span>
               <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>';
   }
}
?>

<div class="form-container">
   <form name="loginForm" action="" method="post" onsubmit="return validateForm();">
      <h3>Login Now</h3>
      <input type="email" name="email" required placeholder="Enter email" class="box">
      <input type="password" name="password" required placeholder="Enter password" class="box">
      <input type="submit" name="submit" class="btn" value="Login Now">
      <p>Don't have an account? <a href="register.php">Register Now</a></p>
   </form>
</div>

</body>
</html>
