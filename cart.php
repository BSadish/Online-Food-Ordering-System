<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   if ($product_quantity > 100) {
      $message[] = 'Quantity cannot exceed 100!';
  } else {
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
      
      if (mysqli_num_rows($select_cart) > 0) {
          $message[] = 'Product already in cart!';
      } else {
          mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
          $message[] = 'Product added to cart!';
      }
  }
}


if(isset($_POST['update_cart'])){
   $update_quantity = $_POST['cart_quantity'];
   $update_id = $_POST['cart_id'];

   if ($update_quantity > 100) {
      $message[] = 'Quantity cannot exceed 100!';
   } else {
      mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
      $message[] = 'Cart quantity updated successfully!';
   }
}

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
   header('location:cart.php');
}
  
if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:cart.php');
}

?>
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
                    <a href="index" class="logo">FOODHUB.</a>
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
                    <div class="contract">
                        <i class="ri-phone-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>



<div class="container">

     
<div class="user-profile">
<!-- <div class="heading">Menu</div> -->
   <?php
      $select_user = mysqli_query($conn, "SELECT * FROM `user_info` WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_user) > 0){
         $fetch_user = mysqli_fetch_assoc($select_user);
      };
   ?>
<div class="shopping-cart">

   <h1 class="heading">Ordering Cart</h1>

   <table>
      <thead>
         <th>image</th>
        
         <th>name</th>
         <th>price</th>
         <th>quantity</th>
         <th>total price</th>
         <th>action</th>
      </thead>
      <tbody>
      <?php
         $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         $grand_total = 0;
         if(mysqli_num_rows($cart_query) > 0){
            while($fetch_cart = mysqli_fetch_assoc($cart_query)){
      ?>
         <tr>
            <td class="image"><img src="images/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
            <td><?php echo $fetch_cart['name']; ?></td>
            <td>Rs: <?php echo $fetch_cart['price']; ?>/-</td>
            <td>
               <form action="" method="post" class="num">
                  <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                  <input type="number"  min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                  <input type="submit" name="update_cart" value="Update" class="option-btn">
               </form>
            </td>
            <td>Rs: <?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</td>
            <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm('remove item from cart?');">Remove</a></td>
         </tr>
      <?php
         $grand_total += $sub_total;
            }
         }else{
            echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
         }
      ?>
      <tr class="table-bottom">
         <td colspan="4">Grand Total :</td>
         <td>Rs: <?php echo $grand_total; ?>/-</td>
         <td><a href="cart.php?delete_all" onclick="return confirm('delete all from cart?');" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">Delete all</a></td>
      </tr>
   </tbody>
   </table>

   <div class="cart-btn">  
      <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">Proceed To Checkout</a>
   </div>

</div>

</div>

</body>
</html>