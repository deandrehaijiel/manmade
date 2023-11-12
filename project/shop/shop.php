<?php
    session_start();
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "manmade";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

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

        $sqlUpdateCartSession = "UPDATE cart SET session = ? WHERE session = ''";
        $stmtUpdateCartSession = $conn->prepare($sqlUpdateCartSession);
        $stmtUpdateCartSession->bind_param("s", $sessionID);
        $stmtUpdateCartSession->execute();
        $stmtUpdateCartSession->close();
    }    

    $sqlShoes = "SELECT id, path, city, name, price FROM shoes";
    $stmtShoes = $conn->prepare($sqlShoes);
    $stmtShoes->execute();
    $resultShoes = $stmtShoes->get_result();
    $stmtShoes->close();
    
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title></title>
<link rel="stylesheet" href="shop.css">
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
            <div class="introduction">
                <div class="leftdiv">
                    <img src="../assets/elements/introducingtext.png" alt="introducing" width="150">
                    <h2 class="icons">The Icons</h2>
                    <p>Quintessentially English, timeless and perfect for smart occasions.</p>
                </div>
                <img class="rightdiv" src="../assets/elements/shopheadline.png" alt="shop" width="600">
            </div>

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
            
            <div id="shopContainer">
                <?php
                    $shoeCount = 0;
                    while ($row = $resultShoes->fetch_assoc()) {
                        if ($shoeCount < 9) {
                            if ($shoeCount % 3 == 0) {
                                echo '<div class="shopdiv">';
                                echo '<div class="firstshop">';
                            } else {
                                echo '<div class="shop">';
                            }

                            echo '<div style="display: flex; justify-content: center;">';
                            echo '<a href="../product/product.php?id=' . $row['id'] . '"><img src="' . $row['path'] . '" alt="' . $row['name'] . '" width="300" height="300"></a>';
                            echo '</div>';
                            echo '<h3 style="text-align: center; margin-bottom: -10px; font-family: Times New Roman, Times, serif;">' . $row['city'] . '</h3>';
                            echo '<p style="text-align: center;">' . $row['name'] . '</p>';
                            echo '<div class="pricediv">';
                            echo '<p style="font-weight: bolder;">$' . $row['price'] . '.00</p>';
                            echo '<a href="../product/product.php?id=' . $row['id'] . '"><p class="plus">+</p></a>';
                            echo '</div>';
                            echo '</div>';

                            if ($shoeCount % 3 == 2) {
                                echo '</div>'; 
                            }
                        } else {
                            if ($shoeCount % 3 == 0) {
                                echo '<div class="shopdiv hidden-shoes" style="display: none;">';
                                echo '<div class="firstshop">';
                            } else {
                                echo '<div class="shop">';
                            }

                            echo '<div style="display: flex; justify-content: center;">';
                            echo '<a href="../product/product.php?id=' . $row['id'] . '"><img src="' . $row['path'] . '" alt="' . $row['name'] . '" width="300" height="300"></a>';
                            echo '</div>';
                            echo '<h3 style="text-align: center; margin-bottom: -10px; font-family: Times New Roman, Times, serif;">' . $row['city'] . '</h3>';
                            echo '<p style="text-align: center;">' . $row['name'] . '</p>';
                            echo '<div class="pricediv">';
                            echo '<p style="font-weight: bolder;">$' . $row['price'] . '.00</p>';
                            echo '<a href="../product/product.php?id=' . $row['id'] . '"><p class="plus">+</p></a>';
                            echo '</div>';
                            echo '</div>';

                            if ($shoeCount % 3 == 2) {
                                echo '</div>'; 
                            }
                        }

                        $shoeCount++;
                    }
                ?>
            </div>            

            <button onclick="loadMore()" id="loadmorebutton" class="loadmorebuttonstyle">LOAD MORE</button>
            <img id="loadmoregif" style="display: none; margin: auto;" src="../assets/elements/logo.gif" alt="manmade" width="150">
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
<script src="shop.js"></script>
</body>
</html>