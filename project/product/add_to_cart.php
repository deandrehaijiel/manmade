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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $path = $_POST['path'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $size = $_POST['size'];

        $session_id = $conn->real_escape_string($_SESSION["session_id"]);

        $sqlCheckProduct = "SELECT id, quantity FROM cart WHERE path = ? AND name = ? AND price = ? AND size = ?";
        $stmtCheckProduct = $conn->prepare($sqlCheckProduct);
        $stmtCheckProduct->bind_param("ssds", $path, $name, $price, $size);
        $stmtCheckProduct->execute();
        $resultCheckProduct = $stmtCheckProduct->get_result();
        $stmtCheckProduct->close();

        if ($resultCheckProduct && $resultCheckProduct->num_rows > 0) {
            $row = $resultCheckProduct->fetch_assoc();
            $productId = $row['id'];
            $newQuantity = $row['quantity'] + 1;

            $sqlUpdateQuantity = "UPDATE cart SET quantity = ? WHERE id = ?";
            $stmtUpdateQuantity = $conn->prepare($sqlUpdateQuantity);
            $stmtUpdateQuantity->bind_param("ii", $newQuantity, $productId);
            $stmtUpdateQuantity->execute();
            $stmtUpdateQuantity->close();
        } else {
            $sqlInsertProduct = "INSERT INTO cart (session, path, name, price, size, quantity) VALUES (?, ?, ?, ?, ?, 1)";
            $stmtInsertProduct = $conn->prepare($sqlInsertProduct);
            $stmtInsertProduct->bind_param("sssds", $session_id, $path, $name, $price, $size);
            $stmtInsertProduct->execute();
            $stmtInsertProduct->close();
        }
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title></title>
<link rel="stylesheet" href="product.css">
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
            <div id="inCart" class="incart">
                <div class="carted">
                    <img src="<?php echo $path; ?>" alt="<?php echo $name; ?>" width="300" height="300">
                    <h2><?php echo $name; ?></h2>
                    <h2>SG $<?php echo number_format($price, 2); ?></h2>
                    <h2><?php echo $size; ?></h2>
                    <h3>has been successfully added to your cart.</h3>
                    <button onclick="toShop()" class="buttonstyle"><h4 class="shopmore">SHOP MORE</h4></button>
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
                    <th>Legal</th>
                    <th>Connect</th>
                </tr>
                <tr>
                    <td><a href="../home/home.php">Home</a></td>
                    <td>Privacy Policy</td>
                    <td>Instagram</td>
                </tr>
                <tr>
                    <td><a href="../shop/shop.php">Shop</a></td>
                    <td>Terms of Service</td>
                    <td>Facebook</td>
                </tr>
                <tr>
                    <td><a href="../services/services.php">Services</a></td>
                    <td>Returns & Exchanges</td>
                    <td>Twitter</td>
                </tr>
                <tr>
                    <td><a href="../about/about.php">About</a></td>
                    <td>Order & Delivery</td>
                </tr>
                <tr>
                    <td>FAQs</td>
                    <td>International Delivery</td>
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
<script src="product.js"></script>
</body>
</html>