<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/cart.css">
   <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />

</head>
<body>
<div class="content1 ">
        <div class="header">
            <div class="navbar  " id="header">
                <div class="logodiv">
                    <a href="index.php" class="logo">FOODHUB.</a>
                </div>
                <div class="main-nav">
                    <ul class="navlists">
                        <li class="navitem"><a href="index.php" class="navlink">Home</a></li>
                        <li class="navitem"><a href="menu.php" class="navlink">Menu</a></li>
                        <li class="navitem"><a href="contract.php" class="navlink">Contract</a></li>
                        <li class="navitem"><a href="orders.php" class="navlink">Orders</a></li>
                    </ul>
                </div>
                <div class="side-nav">
                    <div class="cart">
                       <a href="cart.php"> <i class="ri-shopping-cart-fill"></i></a>
                    </div>
                    <div class="flex contract">
      
      <a href="index.php?logout=<?php echo $user_id; ?>" onclick="return confirm('are your sure you want to logout?');" class="delete-btn"><i class="ri-login-circle-fill"></i></a>
   </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    </body>
</html>