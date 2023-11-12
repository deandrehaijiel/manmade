<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title></title>
<link rel="stylesheet" href="services.css">
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
            <img class="headlinediv" src="../assets/elements/servicesheadline.png" alt="services">
            <div class="wearthemcarethem">
                <h3 style="font-style: bolder;">WEAR THEM. CARE THEM.</h3>
                <p>We are pleased on how you love to wear them out just as much as we take pride in making them. Just as much as you love the way they look, in return, we have created a product line to help you maintain, polish and shine its look for the world to see.</p>
            </div>
            <table class="tablediv">
                <tr>
                    <td style="border: solid 1px black; padding: 10px 10px;"><img src="../assets/elements/luminosity.png" alt="luminosity" width="100%"></td>
                    <td>
                        <div class="tdstyle">
                            <img src="../assets/elements/awordofadvicefortext.png" alt="awordofadvicefor" width="200px">
                            <h2>Luminosity</h2>
                            <p>If you want to get that perfect look, then you're probably interested in partaking in the art of 'luminosity'.</p>
                            <button class="buttonstyle">Learn more</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="tdstyle">
                            <img src="../assets/elements/awordofadvicefortext.png" alt="awordofadvicefor" width="200px">
                            <h2>Furbishing</h2>
                            <p>If you want to get that polished look, then you're probably interested in partaking in the art of 'furbishing'.</p>
                            <button class="buttonstyle">Learn more</button>
                        </div>
                    </td>
                    <td style="border: solid 1px black; padding: 10px 10px;"><img src="../assets/elements/furbishing.png" alt="furbishing" width="100%"></td>
                </tr>
            </table>
            <div class="filter">
                <div class="leftdiv">
                    <p style="padding-right: 40px;">FILTER BY:</p>
                    <p style="padding-right: 20px;">Style</p>
                    <p style="padding-right: 40px;">▼</p>
                    <p style="padding-right: 20px;">Colour</p>
                    <p>▼</p>
                </div>
                <div class="rightdiv">
                    <p style="padding-right: 40px;">SORT BY:</p>
                    <p style="padding-right: 20px;">Relevance</p>
                    <p>▼</p>
                </div>
            </div>
            <div class="line"></div>
            
            <div class="servicesdiv" id="serviceContainer">
                <div class="firstservice">
                    <img src="../assets/elements/shoetree.png" alt="shoetree" height="370">
                    <p>Full-Toe Premium Cedar-Wood Shoe Tree</p>
                    <div class="pricediv">
                        <p>$56.00</p>
                        <p class="plus">+</p>
                    </div>
                </div>

                <div class="service">
                    <img src="../assets/elements/bristlebrush.png" alt="bristlebrush" height="370">
                    <p>Au Natural Horsehair Bristle Brush</p>
                    <div class="pricediv">
                        <p>$48.00</p>
                        <p class="plus">+</p>
                    </div>
                </div>

                <div class="service">
                    <img src="../assets/elements/bickmoretravelkit.png" alt="bickmoretravelkit" height="370">
                    <p>Bickmore Leather Care Travel Kit</p>
                    <div class="pricediv">
                        <p>$88.00</p>
                        <p class="plus">+</p>
                    </div>
                </div>
            </div>

            <div class="servicesdiv" id="serviceContainer">
                <div class="firstservice">
                    <img src="../assets/elements/brushset.png" alt="brushset" height="370">
                    <p>Jär Re-Nourish Brush Set | Natural & Leather</p>
                    <div class="pricediv">
                        <p>$78.00</p>
                        <p class="plus">+</p>
                    </div>
                </div>

                <div class="service">
                    <img src="../assets/elements/shoepolish.png" alt="shoepolish" height="370">
                    <p>Carnega Shoe Polish Neutral for Smooth Finish</p>
                    <div class="pricediv">
                        <p>$48.00</p>
                        <p class="plus">+</p>
                    </div>
                </div>

                <div class="service">
                    <img src="../assets/elements/shoecarekit.png" alt="shoecarekit" height="370">
                    <p>Mancesgo Shoe Care Kit Neutral | Suede</p>
                    <div class="pricediv">
                        <p>$150.00</p>
                        <p class="plus">+</p>
                    </div>
                </div>
            </div>

            <button class="loadmorebuttonstyle">LOAD MORE</button>
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