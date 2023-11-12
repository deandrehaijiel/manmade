<?php
    session_start();

    if (!isset($_SESSION["session_id"])) {
        function generateSessionID($length = 16) {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            $sessionId = '';

            for ($i = 0; $i < $length; $i++) {
                $sessionId .= $characters[rand(0, strlen($characters) - 1)];
            }

            $sessionId .= date('YmdHis');

            return $sessionId;
        }

        $sessionID = generateSessionID(16);

        $_SESSION["session_id"] = $sessionID;

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "manmade";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sqlUpdateCartSession = "UPDATE cart SET session = ? WHERE session = ''";
        $stmtUpdateCartSession = $conn->prepare($sqlUpdateCartSession);
        $stmtUpdateCartSession->bind_param("s", $sessionID);
        $stmtUpdateCartSession->execute();
        $stmtUpdateCartSession->close();

        $conn->close();
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title></title>
<link rel="stylesheet" href="home.css">
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
                    <h1 class="headlinestyle">HEADLINE</h1>
                    <p style="margin: 40px 0;">Get the NEW MANMADE at a special price.<br>Limited for an Unlimited time.</p>
                    <button onclick="toShop()" class="buttonstyle">SHOP NOW</button>
                </div>
            </div>

            <div class="shippingdiv">
                <div class="leftdiv">
                    <img class="deliveryicons" src="../assets/elements/worldwide-shipping.png" alt="worldwide-shipping">
                    <div>
                        <p class="shippingfont">WORLDWIDE SHIPPING</p>
                        <p>Trackable & Reliable</p>
                    </div>
                </div>    
                <div class="middiv">
                    <img class="deliveryicons" src="../assets/elements/free-shipping.png" alt="free-shipping">
                    <div>
                        <p class="shippingfont">FREE LOCAL SHIPPING</p>
                        <p>Singapore</p>
                    </div>
                </div>   
                <div class="rightdiv">
                    <img class="deliveryicons" src="../assets/elements/free-returns.png" alt="free-returns">
                    <div>
                        <p class="shippingfont">FREE RETURNS</p>
                        <p>Within 20 days of delivery</p>
                    </div>
                </div>   
            </div>

            
            <h3 class="hstyle">ARTISANAL</h3>
            <div class="artisanaldiv">
                <div class="columndiv">
                    <img class="deliveryicons" src="../assets/elements/icons.png" alt="icons" width="230">
                    <button class="buttonstyle">ICONS</button>
                </div>
                <div class="columndiv">
                    <img class="deliveryicons" src="../assets/elements/classics.png" alt="classics" width="230">
                    <button class="buttonstyle">CLASSICS</button>
                </div>
                <div class="columndiv">
                    <img class="deliveryicons" src="../assets/elements/loafers.png" alt="loafers" width="230">
                    <button class="buttonstyle">LOAFERS</button>
                </div>
                <div class="columndiv">
                    <img class="deliveryicons" src="../assets/elements/collabs.png" alt="collabs" width="230">
                    <button class="buttonstyle">COLLABS</button>
                </div>
            </div>

            <h3 class="hstyle" style="margin: 100px 0 60px 0;">UPCOMING</h3>
            <div class="upcomingdiv">
                <div class="leftdiv">
                    <h3 style="margin-top: 0;">MANMADE X FYEROOL DARMA</h3>
                    <p>Exhibiting the diverse artistic perspective and the topic of cultural integration.</p>
                    <button class="buttonstyle">EXPLORE</button>
                </div>
                <div class="rightdiv">
                    <img class="deliveryicons" src="../assets/elements/upcoming.png" alt="upcoming" width="600">
                </div>
            </div>
            <div class="horizontaldiv">
                <img src="../assets/elements/horizontalsection.png" alt="horizontalsection" width="100%">
            </div>

            <h3 class="hstyle">WORN BY YOU</h3>

            <div class="wholediv">
                <img class="leftclick" src="../assets/elements/chevron-left.png" alt="left">
                <img src="../assets/elements/wornbyyou.png" alt="wornbyyou" width="90%">
                <img class="rightclick" src="../assets/elements/chevron-left.png" alt="right">
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
<script src="home.js"></script>
</body>
</html>