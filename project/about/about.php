<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title></title>
<link rel="stylesheet" href="about.css">
<meta charset="utf-8">
<style>
</style>    
</head>
<body>
    <div class="surrounding">
        <header class="navrow">
            <div class="leftdiv">
                <a href="../home/home.php"><img style="margin-bottom: -100px;" src="../assets/elements/logo.gif" alt="manmade"></a>
            </div>
            <nav class="middiv">
                <a class="navspace" style="margin-left: 0;" href="../home/home.php">Home</a>
                <a class="navspace" href="../shop/shop.php">Shop</a>
                <a class="navspace" href="../services/services.php">Services</a>
                <a class="navspace" href="../about/about.php">About</a>
            </nav>
            <div class="rightdiv">
                <img class="iconsize" src="../assets/elements/sneaker.png" alt="sneaker">
                <a href="../cart/cart.php"><img class="iconsize" src="../assets/elements/shopping-cart.png" alt="shopping-cart"></a>
                <img class="iconsize" src="../assets/elements/account.png" alt="account">
            </div>
        </header>

        <div class="bodydiv">
            <div class="headlinediv">
                <div class="headline">
                    <h3 class="hstyle">QUALITY & STYLE IS<br>WHAT MADE US</h3>
                </div>
            </div>

            <h3 class="hstyle" style="margin-bottom: 40px;">WHAT MADE US FALL IN LOVE</h3>

            <p style="margin-bottom: 60px;">
                Each day, our admiration for the beauty crafted with dedication and craftmanship deepens. We cherish items untouched by the trends of fashion or the eroding effects of time. Every day, our conviction strengthens that these qualities should be safeguarded and extended. Thus, our mission is born. Through our footwear and apparel, we take joy in imparting that feeling of liberation to you.
            </p>

            <div class="aboutmiddle">
                <img src="../assets/elements/aboutmiddleimage.png" alt="aboutmiddle" width="100%">
            </div>

            <h3 class="hstyle" style="margin: 60px 0 40px 0;">HOW IT BEGAN</h3>
        
            <p style="margin-bottom: 60px;">
                It was 2008, a year where two young fellow Italians had an inspiration that led them to knock on an artisan's door with the idea: "achieving the creation of high quality men's shoes at affordable prices by adopting a direct-to-customer sales approach". As a result, the team has grown, and our product selection has greatly expanded and diversified. Today, we've evolved into a lifestyle brand catering to both men and women, offering not only shoes but also a wide range of apparel and more.
            </p>

            <img src="../assets/elements/howitbeganimage.png" alt="howitbegan">

            <div class="textandimage">
                <div class="leftdiv">
                    <div>
                        <h3 class="artisans">FROM THE ARTISANS TO YOU</h3>
                    </div>
                    <p>
                        By choosing a streamlined supply chain, we solely focus on the necessary steps. This approach enables us to provide a more equitable value for our products, recognising the exceptional quality and dedication our artisans invest in their creation.
                    </p>
                </div>
                <div class="rightdiv">
                    <img src="../assets/elements/fromtheartisans1.png" alt="fromtheartisan" height="300px">
                    <img src="../assets/elements/fromtheartisans2.png" alt="fromtheartisan" height="300px">
                </div>
            </div>
        </div>
    </div>

    <footer class="footerrow">
        <div class="leftdiv">
            <div>
                <p><strong>STAY IN TOUCH</strong></p>
                <p>Sign up to receive news about our latest collections, exclusives and pre-access to promotions.</p>
                <div style="display: flex;">
                    <input class="inputstyle" type="email" id="email" name="email" placeholder="Enter your email address" autocomplete="on">
                    <button class="buttonstyle">SUBSCRIBE</button>
                </div>
            </div>
            <h6 style="font-style: italic;">MANMADE. Copyright 2023. All rights reserved.</h6>
        </div>
         <div class="middiv">
            <p><strong>WE'RE LOCATED AT:</strong></p>
            <p>123 APPLEVIEW CRESENT LANE #02-322<br>SINGAPORE 288458</p>
            <img src="../assets/elements/map.png" alt="map" width="300">
        </div>
        <div class="rightdiv">
            <table>
                <tr>
                    <th>Directory</th>
                    <th style="padding-left: 35px;">Legal</th>
                    <th>Connect</th>
                </tr>
                <tr>
                    <td><a href="../home/home.php">Home</a></td>
                    <td style="padding-left: 35px;">Privacy Policy</td>
                    <td>Instagram</td>
                </tr>
                <tr>
                    <td><a href="../shop/shop.php">Shop</a></td>
                    <td style="padding-left: 35px;">Terms of Service</td>
                    <td>Facebook</td>
                </tr>
                <tr>
                    <td><a href="../services/services.php">Services</a></td>
                    <td style="padding-left: 35px;">Returns & Exchanges</td>
                    <td>Twitter</td>
                </tr>
                <tr>
                    <td><a href="../about/about.php">About</a></td>
                    <td style="padding-left: 35px;">Order & Delivery</td>
                </tr>
                <tr>
                    <td>FAQs</td>
                    <td style="padding-left: 35px;">International Delivery</td>
                </tr>
            </table>
            <div class="paymentlogorow">
                <img class="firstpaymentlogo" src="../assets/elements/visa.png" alt="visa">
                <img class="paymentlogo" src="../assets/elements/mastercard.png" alt="mastercard">
                <img class="paymentlogo" src="../assets/elements/paypal.png" alt="paypal">
                <img class="paymentlogo" src="../assets/elements/amex.png" alt="amex">
                <img class="paymentlogo" src="../assets/elements/google-pay.png" alt="google-pay">
                <img class="paymentlogo" src="../assets/elements/apple-pay.png" alt="apple-pay">
                <img class="paymentlogo" src="../assets/elements/union-pay.png" alt="union-pay">
            </div>
        </div>
    </footer>
</body>
</html>