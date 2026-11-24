<?php
require_once __DIR__ . '/functions/common_functions.php';
cart();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrewCart</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!--navbar-->
    <header>
        <a href="#" class="logo">
        <img src="images/55.png" alt="" class="icon">
        </a>

        <!--manu icon-->
        <img src="images/144p.png.png" class="icon1">

        
        <!--Links-->
        <ul class="navbar">
            <li><a href="#home">HOME</a></li>
            <li><a href="#about">ABOUT US</a></li>
            <li><a href="#product">PRODUCTS</a></li>
            <li><a href="#customers">CUSTOMERS</a></li>
        </ul>


        
        <div class="button">
            <a href="" class="cart"><img src=images/144.png.png class="icon2"><sup class="sup"><?php cart_item(); ?></sup></a>
            <a href="login.html" class="login">LOGIN</a>
        </div>
 
    </header>

    <!--Home-->
    <section class="home" id="home">
        <div class="home-text">
            <h1>Start Your Day<br>With Coffee.</h1>
            <p>Welcome to Brewcart, Sri Lanka’s premier online coffee shop where passion for coffee meets convenience. Explore our wide range of locally sourced and internationally inspired coffee blends, crafted to deliver the perfect brew for every moment. </p>
                
            <div class="button">
                <a href="#product" class="btn">ORDER NOW</a>
                <a href="#about" class="btn1">SEE MORE</a>
            </div> 
        </div>

        <div class="home-img">
            <img src="images/45.png">
        </div>

    </section>

    <!--About Us-->

    <section class="about"  id="about">
        <div class="about-img">
            <img src="images/51.png" alt="">
        </div>

        <div class="about-text">
            <h1>Our History</h1>
            <p>At Brewcart, we celebrate the artistry of coffee and the vibrant coffee culture of Sri Lanka. Our journey began with a simple idea: to make high-quality, sustainably sourced coffee accessible to every home in the country. By combining tradition with innovation, we bring you a curated selection of premium coffee blends, each crafted to ignite your senses and create memorable moments.</p><br>
            <p>What sets us apart is our commitment to supporting local farmers and fostering sustainable practices. We work directly with small-scale coffee growers across Sri Lanka’s lush highlands, ensuring ethical sourcing and fair trade. Every cup of Brewcart coffee carries the story of these hardworking communities and the rich heritage of Sri Lankan coffee.</p><br>
            <p>From single-origin specialty blends to artisanal snacks that pair perfectly with your brew, we aim to offer a complete coffee experience. Join us as we redefine coffee culture in Sri Lanka, one cup at a time.</p>
      
        </div>

    </section>


    <!--Products-->
    <section class="product" id = "product">
        <div class="heading">
            <h2>Our Popular Products</h2>
        </div>

        <!--fetching products-->
        <div class='product-container'>
        <?php getproducts(); ?>
        </div>
        
        
    </section>


    <!--Customers-->
    
    <section class="customers" id="customers">
        <div class="heading">
            <h2>Our Customer's</h2>
        </div>

        <!--container-->
        <div class="customers-container">

            <div class="box">
                <div class="stars">
                    <img src="images/star.png" alt="">
                    <img src="images/star.png" alt="">
                    <img src="images/star.png" alt="">
                    <img src="images/star.png" alt="">
                    <img src="images/star.png" alt="">  
                </div>

             <p>Brewcart has completely transformed my mornings! The coffee is rich and aromatic, and I love how fresh it tastes. Highly recommend it to any coffee lover out there!</p>
             
             <img src="images/rev2.jpg" class="p-pic" alt="">  
             <h2>Tharuk Senvidu</h2>
            </div>


            <div class="box">
                <div class="stars">
                    <img src="images/star.png" alt="">
                    <img src="images/star.png" alt="">
                    <img src="images/star.png" alt="">
                    <img src="images/star.png" alt="">
                    <img src="images/h-star.png" alt="">
                </div>

             <p>I’m really impressed with the quality of their products. The flavor of their coffee is unmatched, and the packaging is eco-friendly too. Definitely worth every penny!</p>
             
             <img src="images/rev3.jpg" class="p-pic" alt="">  
             <h2>Tharindi Ekanayaka</h2>
            </div>


            <div class="box">
                <div class="stars">
                    <img src="images/star.png" alt="">
                    <img src="images/star.png" alt="">
                    <img src="images/star.png" alt="">
                    <img src="images/star.png" alt="">
                    <img src="images/h-star.png" alt="">               
                </div>

             <p>Amazing experience! The taste, the aroma, and the freshness are on another level. Brewcart has become a daily part of my routine!</p>
             
             <img src="images/rev1.jpg" class="p-pic" alt="">  
             <h2>Sanju Perera</h2>
            </div>

        </div>

    </section>


<!-- Footer -->

 <section class="footer">
    <div class="footer-box">
        <img src="images/55.png" alt="">
        <h3 class="csp">Coffee Shop</h3>

      <div class="social">
        <img src="images/facebook.png" class="si" alt="">
        <img src="images/instagram.png" class="si" alt="">
        <img src="images/twitter.png" class="si" alt="">
        <img src="images/tiktok.png" class="si"alt="">
      </div>
    </div>

    <div class="footer-box">
        <h3>Support</h3>
        <li><a href="#product">>Products</a></li>
        <li><a href="#">>Help and Support</a></li>
        <li><a href="#">>Return Policy</a></li>
        <li><a href="#">>Terms Of Use</a></li>
        <li><a href="#">>Products</a></li>
    </div>

    <div class="footer-box">
        <h3>View Guides</h3>
        <li><a href="#">Features</a></li>
        <li><a href="#">Careers</a></li>
        <li><a href="#">Blog Post</a></li>
        <li><a href="#">Our Branches</a></li> 
    </div>

    <div class="footer-box">
        <h3>Contact</h3>
        <div class="contact">
            <span><img src="images/map.png" alt="">30,Borolla Road,Kamburugamuwa.</span>
            <span><img src="images/telephone.png" alt="">+94 717555460</span>
            <span><img src="images/email.png" alt="">brewcart@gmail.com</span>

        </div>
    </div>



 </section>


 <script src="script.js"></script>
    
</body>
</html>