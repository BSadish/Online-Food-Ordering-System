<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}
if (isset($_POST['update_order'])) {
   $order_id = $_POST['order_id']; // Getting the order ID from the form
   $new_status = 'completed'; // Setting the new status to 'completed'

   // Step 1: Update the order status to 'completed'
   $update_query = "UPDATE `orders` SET payment_status = '$new_status' WHERE order_id = '$order_id'";
   if (mysqli_query($conn, $update_query)) {
       echo "Order status updated to completed.";
   } else {
       echo "Failed to update order status.";
   }

   // Step 2: Delete or archive the completed order
   if ($new_status == 'completed') {
       // Archive the completed order by moving it to an archive table
       $archive_query = "INSERT INTO `archived_orders` (order_id, user_id, total_price, total_products, payment_status, placed_on) 
                         SELECT order_id, user_id, total_price, total_products, payment_status, placed_on 
                         FROM `orders` WHERE order_id = '$order_id'";
       if (mysqli_query($conn, $archive_query)) {
           // Step 3: Delete the order from the original table after archiving
           $delete_query = "DELETE FROM `orders` WHERE order_id = '$order_id' AND payment_status = 'completed'";
           if (mysqli_query($conn, $delete_query)) {
               echo "Completed order archived and deleted.";
           } else {
               echo "Failed to delete completed order.";
           }
       } else {
           echo "Failed to archive completed order.";
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
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/cart.css">
   <link rel="stylesheet" href="css/orders.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<!-- <div class="heading">
   <h3>your orders</h3>
   <p> <a href="home.php">home</a> / orders </p>
</div> -->

<section class="placed-orders">

   <h1 class="title">Placed orders</h1>

   <div class="box-container">

      <?php
         $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($order_query) > 0){
            while($fetch_orders = mysqli_fetch_assoc($order_query)){
      ?>
      <div class="box">
         <p> placed on : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> name : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> number : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> address : <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <p> your orders : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> total price : <span>Rs: <?php echo $fetch_orders['total_price']; ?>/-</span> </p>
         <p> payment status : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
         </div>
      <?php
       }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      ?>
   </div>

</section>










<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>