<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = $_POST['price'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'product name already added';
   }else{
      // File validation - check if the uploaded file is an image
      $allowed_types = ['image/jpg', 'image/jpeg', 'image/png'];
      $image_type = $_FILES['image']['type'];

      if (!in_array($image_type, $allowed_types)) {
         $message[] = 'Only JPG, JPEG, and PNG files are allowed!';
      } else if ($image_size > 2000000) {
         $message[] = 'Image size is too large. It should be less than 2MB.';
      } else {
         // Proceed with the image upload
         $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name, price, image) VALUES('$name', '$price', '$image')") or die('query failed');

         if($add_product_query){
            // Check if directory exists, if not create it
            $target_folder = 'uploaded_img/';
            if (!is_dir($target_folder)) {
               mkdir($target_folder, 0777, true);
            }

            move_uploaded_file($image_tmp_name, $image_folder);  // Move uploaded image
            $message[] = 'Product added successfully!';
         } else {
            $message[] = 'Product could not be added!';
         }
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_products.php');
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];

   mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      // File validation - check if the uploaded file is an image
      $allowed_types = ['image/jpg', 'image/jpeg', 'image/png'];
      $image_type = $_FILES['update_image']['type'];

      if (!in_array($image_type, $allowed_types)) {
         $message[] = 'Only JPG, JPEG, and PNG files are allowed!';
      } else if ($update_image_size > 2000000) {
         $message[] = 'Image file size is too large. It should be less than 2MB.';
      } else {
         mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
   }

   header('location:admin_products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

   



</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title">shop products</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>add product</h3>
      <input type="text" name="name" class="box" placeholder="enter product name" required>
      <input type="number" min="0" name="price" class="box" placeholder="enter product price" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<script>
   document.querySelector('form').addEventListener('submit', function(event) {
      // Get product name and price values
      var productName = document.querySelector('input[name="name"]').value;
      var productPrice = document.querySelector('input[name="price"]').value;

      // Regular expression to allow only alphabets and spaces for the product name
      var namePattern = /^[A-Za-z\s]+$/;

      // Check if the product name is valid (only alphabets and spaces)
      if (!namePattern.test(productName)) {
         alert("Product name should only contain alphabets and spaces.");
         event.preventDefault(); // Prevent form submission
         return false;
      }

      // Check if the product price is valid (must be a number greater than 0)
      if (isNaN(productPrice) || productPrice <= 0) {
         alert("Product price should be a valid number greater than 0.");
         event.preventDefault(); // Prevent form submission
         return false;
      }

      // If both validations pass, allow the form to be submitted
      return true;
   });
</script>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <div class="box">
         <img src="images/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="price">Rs: <?php echo $fetch_products['price']; ?>/-</div>
         <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="images/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="enter product name">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="enter product price">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>

<script>
   document.querySelector('form').addEventListener('submit', function(event) {
   // Get product name and price values
   var productName = document.querySelector('input[name="name"]').value;
   var productPrice = document.querySelector('input[name="price"]').value;
   var image = document.getElementById('productImage').files[0];

   // Regular expression to allow only alphabets and spaces for the product name
   var namePattern = /^[A-Za-z\s]+$/;

   // Check if the product name is valid (only alphabets and spaces)
   if (!namePattern.test(productName)) {
      alert("Product name should only contain alphabets and spaces.");
      event.preventDefault(); // Prevent form submission
      return false;
   }

   // Check if the product price is valid (must be a number greater than 0 and less than or equal to 1500)
   if (isNaN(productPrice) || productPrice <= 0 || productPrice > 1500) {
      alert("Product price should be a valid number between 1 and 1500.");
      event.preventDefault(); // Prevent form submission
      return false;
   }


   var xhr = new XMLHttpRequest();
   xhr.open('POST', 'check_product_name.php', true);
   xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
   xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
         if (xhr.responseText === 'exists') {
            alert("Product name already exists. Please choose a different name.");
            event.preventDefault(); // Prevent form submission
            return false;
         }
      }
   };
   xhr.send('product_name=' + productName);

   // If both validations pass, allow the form to be submitted
   return true;

   if (!name || !price || !image) {
      alert("Please fill in all fields.");
      return;
   }

   if (!allowedTypes.includes(image.type)) {
      alert("Only JPG, JPEG, and PNG files are allowed!");
      return;
   }

   if (image.size > maxSize) {
      alert("Image size is too large. It should be less than 2MB.");
      return;
   }

   // If validation passes, submit the form
   this.submit();
});


</script>





<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>