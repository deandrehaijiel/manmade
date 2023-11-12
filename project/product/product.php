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
    
    if (isset($_GET['id'])) {
        $productId = $_GET['id'];
    }
    
    $sqlProduct = "SELECT path, city, name, price FROM shoes WHERE id = ?";
    $stmtProduct = $conn->prepare($sqlProduct);
    $stmtProduct->bind_param("i", $productId);
    $stmtProduct->execute();
    $resultProduct = $stmtProduct->get_result();
    $productDetails = $resultProduct->fetch_assoc();
    $stmtProduct->close();
    
    $sqlSizes = "SELECT DISTINCT size FROM shoes";
    $resultSizes = $conn->query($sqlSizes);
    
    if (!$resultSizes) {
        die("Database query failed: " . $conn->error);
    }
    
    if ($resultSizes) {
        $sizesArray = array();

        $sizesArray[] = '';
    
        while ($rowSize = $resultSizes->fetch_assoc()) {
            $sizeWithEU = 'EU ' . $rowSize['size']; 
            $sizesArray[] = $sizeWithEU;
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
            <a href="../shop/shop.php"><div class="backtopage">
                <p>〈</p>
                <p class="pstyle">Back to page</p>
            </div></a>
            <div class="productdiv">
                <div class="leftdiv">
                    <img src="<?php echo $productDetails['path'] ?>" alt="<?php echo $productDetails['name']; ?>">
                    <div class="productimgrowdiv">
                        <div class="circle"></div>
                        <div class="circle"></div>
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="rightdiv">
                    <div id="product">
                        <h3 class="city"><?php echo $productDetails['city']; ?></h3>
                        <p style="font-weight: bolder;"><?php echo $productDetails['name']; ?></p>
                        <div class="pricediv">
                            <p style="font-weight: bolder;">$<?php echo number_format($productDetails['price'], 2); ?></p>
                            <a onclick="addToCart(selectedSize().value)"><p class="plus">+</p></a>
                        </div>
                    </div>
                    <div class="sizediv">
                        <p style="font-weight: bolder;">Choose your size:</p>
                        <p class="pstyle">Size Guide</p>
                    </div>

                    <select id="sizedropdown" class="sizedropdownmenu">
                        <?php
                            foreach ($sizesArray as $size) {
                                echo '<option value="' . $size . '">' . $size . '</option>';
                            }
                        ?>
                    </select>

                    <p class="firstpstyle">Assistant Size</p>
                    <p class="pstyle">Product Details</p>
                    <p class="pstyle">Delivery & Returns</p>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="add_to_cart.php" style="display: none;">
        <input type="hidden" name="path" value="<?php echo $productDetails['path']; ?>">
        <input type="hidden" name="name" value="<?php echo $productDetails['name']; ?>">
        <input type="hidden" name="price" value="<?php echo $productDetails['price']; ?>">
        <input type="hidden" name="size" id="selected_size" value="">
    </form>

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
<script src="product.js"></script>
</body>
</html>