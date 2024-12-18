
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>

<body style="background-color: #ffeae0;">
    <!-- Header-->

    <div class="content1 container">
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
                    <div class="contract">
                    <a href="logout.php"><i class="ri-login-circle-fill"></i>  </a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Section 1 -->
    <div class="container">
        <div class="content2">
            <div class="text-content">
                <div class="first-text">
                    <h2>Enjoy <span>Delicious</span></h1>
                        <h2><span>Food</span> At Your</h2>
                        <h2>Door Step</h3>
                </div>
                <div class="second-text">
                    <p>We offer the best online portal that allows</p>
                    <p>customers to order food online without</p>
                    <p>vistiong restaurant.</p>

                </div>
                <div class="first-button">
                    <a href="menu.php">Order Now <i class="ri-arrow-right-fill"></i></a>
                </div>

            </div>
            <div class="logo-content">
                <img src="pic/pic1.png" alt="online food image">
            </div>
        </div>
    </div>


    <!-- Section 2 -->
    <div class="container">
        <div class="section2">

            <div class="tasty-food">
                <img class="section2-img" src="pic/diet.png" alt="img1">
                <h2 class="pic1-title">Tasty Foods</h2>
                <p>There are so many varieties of food around the town but ours got one more taste</p>
                <a class="btn" href="menu.php">See Menu</a>
            </div>

            <div class="drinks">
                <img class="section2-img" src="pic/drink.png" alt="img1">
                <h2 class="pic1-title">Drinks</h2>
                <p>There are so many varieties of food around the town but ours got one more taste</p>
                <a class="btn" href="menu.php">See Menu</a>
            </div>

            <div class="cakes">
                <img class="section2-img" src="pic/cake.png" alt="img1">
                <h2 class="pic1-title">Cakes</h2>
                <p>There are so many varieties of food around the town but ours got one more taste</p>
                <a class="btn" href="menu.php">See Menu</a>
            </div>

            <div class="dessert">
                <img class="section2-img" src="pic/dessert.png" alt="img1">
                <h2 class="pic1-title">Dessert</h2>
                <p>There are so many varieties of food around the town but ours got one more taste</p>
                <a class="btn" href="menu.php">See Menu</a>
            </div>
        </div>
    </div>

    <!-- Section 3 -->

    <div class="container">
        <div class="content3">

            <div class="logo-content">
                <div class="logoimg">
                    <img src="pic/aboutImage.png" alt="online food image" style="width: 350px;">
                </div>
            </div>
            <div class="about-text">
                <h2 class="h2-content2">Why People Choose Us!</h2>

                <div class="text-content2">
                    <div class="point-1" style="margin-top: 20px;">
                        <div class="point1-img">
                            <img class="section3-img" src="pic/hamburger.png" alt="">
                        </div>
                        <div class="point1-content">
                            <h2>Choose Your Favourite </h2>
                            <p>There are so many varieties of food aroudn the town but ours get one more taste</p>
                        </div>
                    </div>

                    <div class="point2">
                        <div class="point2-img">
                            <img class="section3-img" src="pic/delivery-man.png" alt="">
                        </div>
                        <div class="point2-content">
                            <h2>We Deliver Your Meals</h2>
                            <p>There are so many varieties of food aroudn the town but ours get one more taste</p>
                        </div>
                    </div>

                    <div class="point3">
                        <div class="point3-img">
                            <img class="section3-img" src="pic/dish.png" alt="">
                        </div>
                        <div class="point3-content">
                            <h2>Grab Your Delicious</h2>
                            <p>There are so many varieties of food aroudn the town but ours get one more taste</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>



    <!-- Section 4 -->
    <div class="container">
        <div class="content4">
            <div class="item-heading">
                <h2>Our Popular Food Iteam</h2>
                <p>You don't want to miss these </p>
            </div>
            <div class="gallary-wrap">
                <span id="backBtn" class="material-symbols-outlined" >
                    arrow_back
                    </span>
                <div class="slider-container">

                    <div class="slider ">
                        <div class="slider-item">
                            <img src="images/product-1.jpeg" alt="">
                            <h2>MoMo</h2>
                            <p>This is the description demo for the food you want to order in our site</p>
                            <div class="down-price">
                                <h2>Rs: 120</h2>
                                <a href="menu.php">Details</a>
                            </div>
                        </div>



                        <div class="slider-item">
                            <img src="images/product-2.jpeg" alt="">
                            <h2>Chowmein</h2>
                            <p>This is the description demo for the food you want to order in our site</p>
                            <div class="down-price">
                                <h2>Rs: 100</h2>
                                <a href="menu.php">Details</a>
                            </div>
                        </div>


                        <div class="slider-item">
                            <img src="images/product-3.jpeg" alt="">
                            <h2>Tandoori</h2>
                            <p>This is the description demo for the food you want to order in our site</p>
                            <div class="down-price">
                                <h2>Rs: 150</h2>
                                <a href="menu.php">Details</a>
                            </div>
                        </div>


                        <div class="slider-item">
                            <img src="images/product-4.jpeg" alt="">
                            <h2>Naan Roti</h2>
                            <p>This is the description demo for the food you want to order in our site</p>
                            <div class="down-price">
                                <h2>Rs: 160</h2>
                                <a href="menu.php">Details</a>
                            </div>
                        </div>
                    </div>


                    <div class="slider">
                        <div class="slider-item"> <img src="images/product-5.jpeg" alt="">
                            <h2>Pizza</h2>
                            <p>This is the description demo for the food you want to order in our site</p>
                            <div class="down-price">
                                <h2>Rs: 400</h2>
                                <a href="menu.php">Details</a>
                            </div>
                        </div>

                        <div class="slider-item"> <img src="images/product-6.jpeg" alt="">
                            <h2>Ice-Cream</h2>
                            <p>This is the description demo for the food you want to order in our site</p>
                            <div class="down-price">
                                <h2>Rs: 180</h2>
                                <a href="menu.php">Details</a>
                            </div>
                        </div>

                        <div class="slider-item"> <img src="images/product-7.jpg" alt="">
                            <h2>Burger</h2>
                            <p>This is the description demo for the food you want to order in our site</p>
                            <div class="down-price">
                                <h2>Rs: 150</h2>
                                <a href="menu.php">Details</a>
                            </div>
                        </div>

                        <div class="slider-item"> <img src="images/product-8.jpg" alt="">
                            <h2>Samosa</h2>
                            <p>This is the description demo for the food you want to order in our site</p>
                            <div class="down-price">
                                <h2>Rs: 50</h2>
                                <a href="menu.php">Details</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <span id="nextBtn" class="material-symbols-outlined">
                    arrow_forward
                    </span>

            </div>
           
        </div>
       
    </div>

    </div>



    <!-- Section 5 -->
     <div class="container">
        <div class="content5">
<div class="feed1">
    <div class="feed-content1">
        <h2>Customer <span id="span">Feedback</span></h2>
        <h3>This cozy restaurant has left the best impressions! Hospitable hosts, delicious dishes, beautiful presentation, wide wine list and wonderful dessert. I recommend to everyone! I would like to come back here again and again.</h3>
        <div class="feed-logo">
<img src="pic/webpic.jpeg" alt="web picture" style="width: 50px; border-radius: 50%;">
<div class="feed-name">
    <h4>Sadish & Prasun</h3>
    <h4><span id="span">Web Developer</span></h4>
</div>
        </div>
    </div>
    <div class="feed-content2">
        <div class="feed-item1">
            <div class="feed-img">
            <img src="pic/cooker.jpeg" alt="" style="width: 60px; border-radius: 50%;">
        </div>
          <div class="para">
            50
          </div>
           <div class="content-name">
            <h4>Chef</h2>
            <h4>Professionals</h3>
           </div>
        </div>
        <div class="feed-item1">
           <div class="feed-img">
            <img src="pic/reward1.png" alt="" style="width: 60px; border-radius: 50px;" >
        </div>
            <div class="para">140</div>
           <div class="content-name">
            <h4>Customer</h2>
            <h4>Satisfaction</h3>
           </div>
        </div>
    </div>
</div>
<div class="feed2">
    <img src="pic/chef.png" alt="">
</div>

        </div>
     </div>


     <!-- Section Six -->

     <div class="container">
        <div class="detail-section">
            <div class="detail-section1">
                <p id="moto">Healthy <span id="span">Customer</span></p>
            </div>
            <div class="detail-section2">
                <div class="email-detail">
                    
                        <form action="" >
                            <div class="detail1">
                            <input type="email" name="" id="email"  placeholder="Enter your Email">
                        </div>
                        <div class="click-button">
<input type="button" value="Connect Us" >
                        </div>
                        </form>
                    </div>
                
            </div>
        </div>
     </div>



     <!-- Section 6(Footer Section) -->
    <footer>
        <div class="container">
            <div class="footer">
        <div class="footer-section">
            <div class="footer-1">
                <p id="heading"><span id="span">FOODHUB</span></p>
                <p class="text">Parsa,Chitwan</p>
                <p class="text">Chitwan. <span id="span">056-456833</span></p>
                <div class="icons">
                    <p><a href="#"><i class="ri-instagram-fill"></i></a></p>
                <p><a href="#"><i class="ri-facebook-box-fill"></i></a></p>
                <p><a href="#"><i class="ri-whatsapp-fill"></i></a></p>
                <p><a href="#"><i class="ri-youtube-fill"></i></a></p>
                </div>
            </div>
            <div class="footer-2">
                <p id="heading">Opening Hours</p>
                <p class="text">Monday - Friday 8AM - 11PM</p>
                <p class="text">Saturday - Sunday 8AM - 6PM</p>
            </div>
            <div class="footer-3">
                <p id="heading">Quick Link</p>
                <p class="text"><a href="index.html">Home</a></p>
                <p class="text"><a href="menu.html">Menu</a></p>
                <p class="text"><a href="#">Administrator</a></p>
            </div>
        </div>
        </div>
    </div>

    <!-- Last Section -->
     <div class="copyright">
        <p>ALL RIGHT RESERVED | S AND P 2024</p>
     </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>