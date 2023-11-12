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

    $session_id = $conn->real_escape_string($_SESSION["session_id"]);

    $sqlRetrieveCart = $conn->prepare("SELECT id, path, name, price, size, quantity FROM cart WHERE session = ?");
    $sqlRetrieveCart->bind_param("s", $session_id);
    $sqlRetrieveCart->execute();
    $result = $sqlRetrieveCart->get_result();

    if (!$result) {
        die("Database query failed: " . $conn->error);
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title></title>
<link rel="stylesheet" href="cart.css">
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
            <div class="progressdiv">
                <div class="progress">
                    <p class="firstpstyle">1</p>
                    <p>My Cart</p>
                </div>
                <div class="line"></div>
                <div class="progress">
                    <p class="pstyle">2</p>
                    <p>Information</p>
                </div>
                <div class="line"></div>
                <div class="progress">
                    <p class="pstyle">3</p>
                    <p>Shipping</p>
                </div>
                <div class="line"></div>
                <div class="progress">
                    <p class="pstyle">4</p>
                    <p>Payment</p>
                </div>
            </div>
            <h3 style="font-weight: bolder;">SHOPPING BAG</h3>
                <?php if ($result->num_rows > 0) {
                    echo '<div id="inCart" class="incart">';
                    echo '<div class="leftdiv">';
                    echo '<form id="cart" method="post" action="../information/information.php">';
                    $totalPrice = 0;
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="productdiv">';
                        echo '<img src="' . $row['path'] . '" alt="' . $row['name'] . '">';
                        echo '<div class="productcol">';
                        echo '<div class="productinfo">';
                        echo '<h3 class="productinfostyle" style="font-weight: bolder;">' . $row['name'] . '</h3>';
                        echo '<p class="productinfostyle">Size: ' . $row['size'] . ' / Colour: Black</p>';
                        echo '<p class="productinfostyle">Save to Wishlist | Remove</p>';
                        echo '</div>';
                        echo '<div>';
                        echo '<input type="checkbox">';
                        echo '<label> This order is a gift</label>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div>';
                        $productPrice = $row['price'] * $row['quantity'];
                        echo '<h3 style="font-weight: bolder;" id="price_' . $row['id'] . '">SG $' . number_format($productPrice, 2) . '</h3>';
                        echo '<div style="display: flex; justify-content: space-between;">';
                        echo '<a onclick="updateQuantity(\'subtract\', ' . $row['id'] . ', ' . $row['price'] . ')"><p class="sign">−</p></a>';
                        echo '<p id="quantity_' . $row['id'] . '" style="padding-top: 3px;">' . $row['quantity'] . '</p>';
                        echo '<a onclick="updateQuantity(\'add\', ' . $row['id'] . ', ' . $row['price'] . ')"><p class="sign">+</p></a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="line"></div>';

                        $totalPrice += $productPrice;

                        echo '<input type="hidden" name="id_' . $row['id'] . '" value="' . $row['id'] . '">';
                        echo '<input type="hidden" name="quantity_' . $row['id'] . '" value="' . $row['quantity'] . '">';
                    }
                    echo '</form>';
                    echo '<a onclick="clearCart()" class="clearcart">Clear my cart</a>';
                    echo '<div>';
                    echo '<div style="margin-bottom: 150px;">';
                    echo '<h3 style="text-align: center; margin: 150px 0 50px 0; font-weight: bolder;">THE PERFECT ADDITION TO YOUR STYLE</h3>';
                    echo '<div class="productdiv">';
                    echo '<img src="../assets/elements/polish.png" alt="polish" style="margin-left: 20px; width: 300px; height: auto;">';
                    echo '<div class="productcol">';
                    echo '<div class="productinfo">';
                    echo '<h3 class="productinfostyle" style="font-weight: bolder;">Pomade Polish</h3>';
                    echo '<p class="productinfostyle">Pure Polish Wax | For Leather</p>';
                    echo '</div>';
                    echo '<div>';
                    echo '<h3 style="font-weight: bolder;">SG $54.00</h3>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div style="margin-right: -20px;">';
                    echo '<div style="display: flex; justify-content: space-between; justify-self: end;">';
                    echo '<p style="padding-top: 3px; margin-right: 10px;">Add to cart</p>';
                    echo '<a style="cursor: auto;"><p class="sign">+</p></a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    if ($result->num_rows > 1) {
                        echo '<div style="margin-bottom: 150px; margin-top: -80px;">';
                        echo '<div class="productdiv">';
                        echo '<img src="../assets/elements/belt.png" alt="belt" style="margin-left: 20px; width: 300px; height: auto;">';
                        echo '<div class="productcol">';
                        echo '<div class="productinfo">';
                        echo '<h3 class="productinfostyle" style="font-weight: bolder;">Revène</h3>';
                        echo '<p class="productinfostyle">Calf leather belt | Colour: Dark Blue</p>';
                        echo '<div style="display: flex; padding-right: 10px; align-items: center;">';
                        echo '<p class="sign" style="margin-right: 10px;">32</p>';
                        echo '<p class="sign" style="margin-right: 10px;">34</p>';
                        echo '<p class="sign" style="margin-right: 10px;">36</p>';
                        echo '<p class="sign" style="margin-right: 10px;">38</p>';
                        echo '<p class="sign" style="margin-right: 10px;">40</p>';
                        echo '<h6 style="font-weight: lighter; font-style: italic; margin-left: 20px;">what\'s my size?</h6>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div>';
                        echo '<h3 style="font-weight: bolder;">SG $67.00</h3>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div style="margin-right: -20px;">';
                        echo '<div style="display: flex; justify-content: space-between; justify-self: end;">';
                        echo '<p style="padding-top: 3px; margin-right: 10px;">Add to cart</p>';
                        echo '<a style="cursor: auto;"><p class="sign">+</p></a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '</div>';
                    }
                    echo '<div class="rightdiv">';
                    echo '<div class="ordersummarydiv">';
                    echo '<h3 style="margin-top: 0; font-weight: bolder;">ORDER SUMMARY</h3>';
                    echo '<table>';
                    echo '<tr>';
                    echo '<td>Subtotal</td>';
                    echo '<td id="subtotal" class="ordersummarystyle">SG $' . number_format($totalPrice, 2) . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Shipping</td>';
                    echo '<td class="ordersummarystyle">TBD</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Tax</td>';
                    echo '<td class="ordersummarystyle">TBD</td>';
                    echo '</tr>';
                    echo '</table>';
                    echo '<div class="line"></div>';
                    echo '<table>';
                    echo '<tr>';
                    echo '<td>';
                    echo '<h3 style="font-weight: bolder;">TOTAL</h3>';
                    echo '</td>';
                    echo '<td>';
                    echo '<h3 id="total" class="ordersummarystyle">SG $' . number_format($totalPrice, 2) . '</h3>';
                    echo '</td>';
                    echo '</tr>';
                    echo '</table>';
                    echo '<button class="buttonstyle" onclick="toInformation()">CHECKOUT</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    } else {
                        echo '<div id="inCart" class="incart" style="height: 40vh; margin-top: -20px;">';
                        echo '<div class="emptycart">';
                        echo '<h1>Cart is empty</h1>';
                        echo '</div>';
                        echo '</div>';
                    }
                ?>
        </div>
    </div>

    <form id="clearCart" method="post" action="clear_cart.php"></form>

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
<script src="cart.js"></script>
</body>
</html>