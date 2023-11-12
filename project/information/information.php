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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sqlMinId = "SELECT MIN(id) AS min_id FROM cart WHERE session = ?";
        $stmtMinId = $conn->prepare($sqlMinId);
        $stmtMinId->bind_param("s", $session_id);
        $stmtMinId->execute();
        $resultMinId = $stmtMinId->get_result();
        $minId = $resultMinId->fetch_assoc();
        $minimumId = $minId['min_id'];
        $stmtMinId->close();

        $sqlMaxId = "SELECT MAX(id) AS max_id FROM cart WHERE session = ?";
        $stmtMaxId = $conn->prepare($sqlMaxId);
        $stmtMaxId->bind_param("s", $session_id);
        $stmtMaxId->execute();
        $resultMaxId = $stmtMaxId->get_result();
        $maxId = $resultMaxId->fetch_assoc();
        $maximumId = $maxId['max_id'];
        $stmtMaxId->close();
    
        $sqlUpdateQuantity = "UPDATE cart SET quantity = ? WHERE id = ? AND session = ?";
        $stmtUpdateQuantity = $conn->prepare($sqlUpdateQuantity);
        $stmtUpdateQuantity->bind_param("iis", $quantity, $id, $session_id);
    
        for ($i = $minimumId; $i <= $maximumId; $i++) {
            $id = $_POST['id_' . $i];
            $quantity = $_POST['quantity_' . $i];
    
            if ($quantity != 0) {
                $stmtUpdateQuantity->execute();
            } else {
                $sqlDelete = "DELETE FROM cart WHERE id = ? AND session = ?";
                $stmtDelete = $conn->prepare($sqlDelete);
                $stmtDelete->bind_param("is", $id, $session_id);
                $stmtDelete->execute();
                $stmtDelete->close();
            }
        }

        $stmtUpdateQuantity->close();
    }    

    $sqlFirstProduct = "SELECT path, name, size, price, quantity FROM cart WHERE session = ? LIMIT 1";
    $stmtFirstProduct = $conn->prepare($sqlFirstProduct);
    $stmtFirstProduct->bind_param("s", $session_id);
    $stmtFirstProduct->execute();
    $resultFirstProduct = $stmtFirstProduct->get_result();
    $firstCartProduct = $resultFirstProduct->fetch_assoc();

    $_SESSION['first_cart_product_path'] = $firstCartProduct['path'];
    $_SESSION['first_cart_product_name'] = $firstCartProduct['name'];
    $_SESSION['first_cart_product_size'] = $firstCartProduct['size'];
    $_SESSION['first_cart_product_price'] = $firstCartProduct['price'];
    $_SESSION['first_cart_product_quantity'] = $firstCartProduct['quantity'];

    $sqlSubtotal = "SELECT SUM(price * quantity) AS subtotal FROM cart WHERE session = ?";
    $stmtSubtotal = $conn->prepare($sqlSubtotal);
    $stmtSubtotal->bind_param("s", $session_id);
    $stmtSubtotal->execute();
    $resultSubtotal = $stmtSubtotal->get_result();
    $rowSubtotal = $resultSubtotal->fetch_assoc();
    $subtotal = $rowSubtotal['subtotal'];

    $_SESSION['cart_subtotal'] = $subtotal;
    
    $estimatedTaxes = $subtotal * 0.08;
    $totalPrice = $subtotal + $estimatedTaxes;

    $sqlDiscount = "SELECT * FROM discount";
    $resultDiscount = $conn->query($sqlDiscount);

    $discounts = array();

    while ($rowDiscount = $resultDiscount->fetch_assoc()) {
        $discounts[] = array(
            'code' => $rowDiscount['code'],
            'percentage' => $rowDiscount['percentage']
        );
    }
    
    $discountsArray = '[';
    foreach ($discounts as $discount) {
        $discountsArray .= "{ 'code': '{$discount['code']}', 'percentage': {$discount['percentage']} },";
    }
    $discountsArray = rtrim($discountsArray, ',') . ']';
    
    echo "<script>// Easter Egg Alert! 🎉 You've discovered a hidden treasure: exclusive discount codes! Redeem any of these secret codes for fantastic discounts across our diverse product range! 🌟</script>";
    echo "<script>const discountsArray = {$discountsArray};</script>"; 

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title></title>
<link rel="stylesheet" href="information.css">
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
                    <p class="pstyle">1</p>
                    <p>My Cart</p>
                </div>
                <div class="line"></div>
                <div class="progress">
                    <p class="secondpstyle">2</p>
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
            <div class="information">
                <div class="leftdiv">
                    <p class="pstyle">Express Checkout</p>
                    <button style="background-color: #F8F5E2; border-radius: 6px; border-width: thin;"><img class="buttonstyle" src="../assets/elements/pp.png" alt="paypal"></button>
                    <h4>Shipping Address</h4>
                    <form method="post">
                        <div class="formstyle">
                            <label for="Email">Email Address</label>
                            <input type="email" name="Email" id="Email" autocomplete="on" class="inputstyle" required>
                            <label for="Country">Country/Region</label>
                            <input type="text" name="Country" id="Country" autocomplete="on" class="inputstyle" required>
                            <div style="display: flex; gap: 20px;">
                                <div class="formstyle" style="flex: 1;">
                                    <label for="FirstName">First Name</label>
                                    <input type="text" name="FirstName" id="FirstName" autocomplete="on" class="inputstyle" required>
                                </div>
                                <div class="formstyle" style="flex: 1;">
                                    <label for="LastName">Last Name</label>
                                    <input type="text" name="LastName" id="LastName" autocomplete="on" class="inputstyle" required>
                                </div>
                            </div>
                            <label for="Address">Address</label>
                            <input type="text" name="Address" id="Address" autocomplete="on" class="inputstyle" required>
                            <label for="Apartment">Apartment Name, Unit. No and Level, Company, etc.</label>
                            <input type="text" name="Apartment" id="Apartment" autocomplete="on" class="inputstyle" required>
                            <label for="Postal">Postal Code</label>
                            <input type="text" name="Postal" id="Postal" autocomplete="on" class="inputstyle"required >
                            <label for="Phone">Phone Number</label>
                            <input type="number" name="Phone" id="Phone" autocomplete="on" class="inputstyle" required>
                        </div>
                    </form>
                    <div style="display: flex; justify-content: space-between;">
                        <a href="../cart/cart.php"><div class="returntocart">
                            <p>〈</p>
                            <p class="pstyle">return to cart</p>
                        </div></a>
                        <button onclick="toShipping()" class="continuetoshipping">Continue to Shipping</button>
                    </div>
                </div>
                <div id="rightDiv" class="rightdiv">
                    <div style="display: flex;">
                        <img src="<?php echo $firstCartProduct['path']; ?>" alt="<?php echo $firstCartProduct['name']; ?>" width="200" height="200" style="padding-right: 40px;">
                        <div>
                            <p style="font-weight: bolder;"><?php echo $firstCartProduct['name']; ?></p>
                            <p>Size: <?php echo $firstCartProduct['size']; ?> / Colour: Black</p>
                            <p style="font-weight: bolder;">SG $<?php echo number_format($firstCartProduct['price'], 2); ?></p>
                        </div>
                    </div>
                    <div style="display: flex; margin-top: 80px;"> 
                        <input type="text" name="Discount" id="Discount" autocomplete="off" class="inputstyle" placeholder="Discount code or Voucher">
                        <button onclick="applyDiscount(document.getElementById('Discount').value, <?php echo $subtotal; ?>)" class="apply">APPLY</button>
                    </div>
                    <div class="line" style="margin-top: 50px;"></div>
                    <table style="margin-bottom: 2px;">
                        <tr>
                            <td>
                                <h4 style="font-style: italic; font-weight: lighter;">Subtotal</h4>
                            </td>
                            <td>
                                <h4 style="font-weight: bolder; text-align: end;">
                                    SG $<?php echo number_format($subtotal, 2); ?>
                                </h4>
                            </td>
                        </tr>
                        <tr id="discountRow" style="display: none;">
                            <td>
                                <h4 id="discountCode" style="font-style: italic; font-weight: lighter;"></h4>
                            </td>
                            <td>
                                <h4 id="discountAmount" style="font-weight: bolder; text-align: end;"><h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 style="font-style: italic; font-weight: lighter">Shipping</h4>
                            </td>
                            <td>
                                <h4 style="font-weight: normal; text-align: end;">
                                    CALCULATED NEXT
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 style="font-style: italic; font-weight: lighter;">Est. Taxes (8%)</h4>
                            </td>
                            <td>
                                <h4 id="estimatedTaxes" style="font-weight: bolder; text-align: end;">
                                    SG $<?php echo number_format($estimatedTaxes, 2); ?>
                                </h4>
                            </td>
                        </tr>
                    </table>
                    <div class="line"></div>
                    <table>
                        <tr>
                            <td>
                                <h3 style="font-weight: bolder; font-style: italic;">TOTAL</h3>
                            </td>
                            <td>
                                <h3 id="totalPrice" style="font-weight: bolder; text-align: end;">
                                    SG $<?php echo number_format($totalPrice, 2); ?>
                                </h3>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <form id="information" method="post" action="../shipping/shipping.php" style="display: none;">
        <input type="hidden" name="orderid" value="">
        <input type="hidden" name="email" value="">
        <input type="hidden" name="country" value="">
        <input type="hidden" name="firstname" value="">
        <input type="hidden" name="lastname" value="">
        <input type="hidden" name="address" value="">
        <input type="hidden" name="apartmentnumber" value="">
        <input type="hidden" name="postalcode" value="">
        <input type="hidden" name="phonenumber" value="">
        <input type="hidden" name="discountcode" value="">
        <input type="hidden" name="discountamount" value="">
        <input type="hidden" name="estimatedtaxes" value="<?php echo $estimatedTaxes ?>">
        <input type="hidden" name="totalprice" value="<?php echo $totalPrice ?>">
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
<script src="information.js"></script>
</body>
</html>