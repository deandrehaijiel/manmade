<?php
    session_start();

    $firstCartProductPath = $_SESSION['first_cart_product_path'];
    $firstCartProductName = $_SESSION['first_cart_product_name'];
    $firstCartProductSize = $_SESSION['first_cart_product_size'];
    $firstCartProductPrice = $_SESSION['first_cart_product_price'];
    $firstCartProductQuantity = $_SESSION['first_cart_product_quantity'];

    $subtotal = $_SESSION['cart_subtotal'];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "manmade";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $session_id = $conn->real_escape_string($_SESSION["session_id"]);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $orderId = $_POST['orderid'];
        $email = $_POST['changeemail'];
        $address = $_POST['changeaddress'];
        $apartmentNumber = $_POST['changeapartmentnumber'];
        $postalCode = $_POST['changepostalcode'];
        $shippingMethod = $_POST['shippingmethod'];
        $shippingFee = $_POST['shippingfee'];
        $discountCode = $_POST['discountcode'];
        $discountAmount = $_POST['discountamount'];
        $estimatedTaxes = $_POST['estimatedtaxes'];
        $totalPrice = $_POST['totalprice'];
    
        $sqlUpdateCustomers = "UPDATE customers SET email = ?, address = ?, apartment_number = ?, postal_code = ? WHERE order_id = ?";
        $stmtUpdateCustomers = $conn->prepare($sqlUpdateCustomers);
        $stmtUpdateCustomers->bind_param("sssss", $email, $address, $apartmentNumber, $postalCode, $orderId);
        $stmtUpdateCustomers->execute();
        $stmtUpdateCustomers->close();
    
        $sqlUpdateOrders = "UPDATE orders SET shipping_method = ?, shipping_fee = ?, discount_code = ?, discount_amount = ?, estimated_taxes = ?, total_price = ? WHERE order_id = ?";
        $stmtUpdateOrders = $conn->prepare($sqlUpdateOrders);
        $stmtUpdateOrders->bind_param("sssssss", $shippingMethod, $shippingFee, $discountCode, $discountAmount, $estimatedTaxes, $totalPrice, $orderId);
        $stmtUpdateOrders->execute();
        $stmtUpdateOrders->close();
    }

    $shipping = 'Standard 3-7 Business Day Delivery';
    $shippingText = 'Free Local Shipping';

    if ($shippingMethod == 'express') {
        $shipping = 'Express 2-3 Business Day Delivery';
        $shippingText = 'SG $22.00';
    }

    echo "<script>const shipping = '$shippingMethod'</script>";

    if ($discountCode && $discountAmount) {
        echo "<script>const code = '$discountCode'; const amount = '$discountAmount';</script>";
    } else {
        echo "<script>const code = ''; const amount = 0;</script>";
    }

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
<link rel="stylesheet" href="payment.css">
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
                    <p class="fourthpstyle">4</p>
                    <p>Payment</p>
                </div>
            </div>
            <div class="payment">
                <div class="leftdiv">
                    <h4 style="margin-bottom: -4px; font-weight: bolder;">Details</h4>
                    <table class="tablestyle">

                        <tr id="contactTr">
                            <td class="leftstyle" style="padding-top: 22px;">
                                <h4>Contact:</h4>
                            </td>
                            <td class="midstyle" style="padding-top: 22px;">
                                <h4 id="contactDetails"  style="font-weight: normal;"><?php echo $email; ?></h4>
                            </td>
                            <td class="rightstyle" style="padding-top: 22px;">
                                <h4 style="font-weight: normal;" onclick="toggleContact()" class="pstyle">Change</h4>
                            </td>
                        </tr>
                        <tr id="updateContactTr" style="display: none;">
                            <td class="leftstyle" style="padding-top: 22px;">
                                <h4>Contact:</h4>
                            </td>
                            <td class="midstyle" style="padding-top: 8px;">
                                <input type="email" name="changeEmail" id="changeEmail" autocomplete="on" class="inputstyle" placeholder="Change Email" value="<?php echo $email; ?>">
                            </td>
                            <td class="rightstyle" style="padding-top: 22px;">
                                <h4 style="font-weight: normal;" onclick="changeEmail()" class="pstyle">Update</h4>
                            </td>
                        </tr>

                        <tr id="addressTr">
                            <td class="leftstyle">
                                <h4>Address:</h4>
                            </td>
                            <td class="midstyle">
                                <h4 id="addressDetails" style="font-weight: normal;"><?php echo $address; ?>, <?php echo $apartmentNumber; ?>, <?php echo $postalCode; ?></h4>
                            </td>
                            <td class="rightstyle">
                                <h4 style="font-weight: normal;" onclick="toggleAddress()" class="pstyle">Change</h4>
                            </td>
                        </tr>
                        <tr id="updateAddressTr" style="display: none;">
                            <td class="leftstyle">
                                <h4>Address:</h4>
                            </td>
                            <td class="midstyle" style="padding-top: 10px; display: flex; gap: 10px;">
                                <input type="text" name="changeAddress" id="changeAddress" autocomplete="on" class="inputstyle" placeholder="Address" value="<?php echo $address; ?>">
                                <input type="text" name="changeApartmentNumber" id="changeApartmentNumber" autocomplete="on" class="inputstyle" placeholder="Apartment Number" value="<?php echo $apartmentNumber; ?>">
                                <input type="text" name="changePostalCode" id="changePostalCode" autocomplete="on" class="inputstyle" placeholder="Postal Code" value="<?php echo $postalCode; ?>">
                            </td>
                            <td class="rightstyle">
                                <h4 style="font-weight: normal;" onclick="changeAddress()" class="pstyle">Update</h4>
                            </td>
                        </tr>

                        <tr id="shippingMethodTr">
                            <td class="leftstyle">
                                <h4>Shipping<br>Method:</h4>
                            </td>
                            <td class="midstyle">
                                <h4 id="shippingMethodDetails"  style="font-weight: normal;"><?php echo $shipping; ?></h4>
                            </td>
                            <td class="rightstyle">
                                <h4 style="font-weight: normal;" onclick="toggleShippingMethod()" class="pstyle">Change</h4>
                            </td>
                        </tr>
                        <tr id="updateShippingMethodTr" style="display: none;">
                            <td class="leftstyle">
                                <h4>Shipping<br>Method:</h4>
                            </td>
                            <td class="midstyle" style="display: flex; padding-top: 20px; justify-content:space-around;">
                                <div style="margin-top: 2px;">
                                    <input onclick="changeShippingMethod(document.getElementById('Discount').value,  <?php echo $subtotal; ?>)" type="radio" id="express" name="changeShippingMethod" value="express">
                                    <label for="express">Express</label>
                                </div>
                                <div style="margin-top: 2px;">
                                    <input onclick="changeShippingMethod(document.getElementById('Discount').value,  <?php echo $subtotal; ?>)" type="radio" id="standard" name="changeShippingMethod" value="standard">
                                    <label for="standard">Standard</label>
                                </div>
                            </td>
                            <td class="rightstyle">
                                <h4 style="font-weight: normal;" onclick="toggleShippingMethod()" class="pstyle">Update</h4>
                            </td>
                        </tr>
                    </table>

                    <div class="line"></div>
                    <h4 style="margin-bottom: -10px; margin-top: 28px; font-weight: bolder;">Payment</h4>
                    <h5 style="font-style: italic;">All transactions are secured and encrypted.</h5>
                    <table style="margin-top: -8px;">
                        <tr>
                            <td>
                                <input type="checkbox" name="paymentOption" class="checkboxstyle" data-value="credit" onchange="paymentMethod(this)">
                            </td>
                            <td style="display: flex; align-items: center;">
                                <p style="margin-left: 10px;">Credit Card</p>
                                <div style="display: flex; margin-left: auto;">
                                    <img class="creditcard" src="../assets/elements/visa.png" alt="visa">
                                    <img class="creditcard" src="../assets/elements/mastercard.png" alt="mastercard">
                                    <img class="creditcard" src="../assets/elements/amex.png" alt="amex">
                                    <img class="creditcard" src="../assets/elements/union-pay.png" alt="union-pay">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">
                                <input type="checkbox" name="paymentOption" class="checkboxstyle" data-value="paypal" onchange="paymentMethod(this)">
                            </td>
                            <td>
                                <div style="margin: -4px 0 8px 10px;">
                                    <img style="margin: -22px 0 -30px 0;" src="../assets/elements/pp.png" alt="paypal" height="80">
                                    <p style="font-size: small;">After clicking 'Complete Order', you will be redirected to PayPal to confirm and complete your purchase securely.</p>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="line" style="margin-top: 20px; margin-bottom: 48px;"></div>
                    <h4 style="margin-bottom: -10px; font-weight: bolder;">Billing Address</h4>
                    <h5 style="font-style: italic;">Please select the address that matches with your card payment or payment method.</h5>
                    <table style="margin-top: -8px;">
                        <tr>
                            <td style="width: 0;">
                                <input type="checkbox" name="billingOption" class="checkboxstyle" data-value="same" onchange="billingMethod(this)">
                            </td>
                            <td>
                                <p style="margin-left: 10px;">Same as shipping address</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 0;">
                                <input style="margin-top: 26px;" type="checkbox" name="billingOption" class="checkboxstyle" data-value="different" onchange="billingMethod(this)">
                            </td>
                            <td style="padding-top: 0;">
                                <p style="margin-left: 10px; margin-top: 22px;">Use a different billing address</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input style="display: none;" type="text" name="billingAddress" id="billingAddress" autocomplete="on" class="inputstyle" placeholder="Billing Address">
                                <input style="display: none; margin: 10px 0;" type="text" name="billingApartmentNumber" id="billingApartmentNumber" autocomplete="on" class="inputstyle" placeholder="Billing Apartment Number">
                                <input style="display: none;" type="text" name="billingPostalCode" id="billingPostalCode" autocomplete="on" class="inputstyle" placeholder="Billing Postal Code">
                            </td>
                        </tr>
                    </table>
                    <div class="line" style="margin-top: 36px; margin-bottom: 50px;"></div>
                    <p style="margin-bottom: 40px;">By proceeding, I agree to the <span style="text-decoration: underline;">terms & conditions</span> stated and to receive periodic promotional emails.</p>
                    <div class="buttonrow">
                        <a href="../cart/cart.php">
                            <div class="returntocart">
                                <p>〈</p>
                                <p class="pstyle">return to cart</p>
                            </div>
                        </a>
                        <button onclick="toConfirmation()" class="continuetoconfirmation" style="padding: 0 30px;">Complete Order</button>
                    </div>
                </div>
                <div id="rightDiv" class="rightdiv">
                    <div class="firstcartproduct">
                        <img src="<?php echo $firstCartProductPath; ?>" alt="<?php echo $firstCartProductName; ?>" width="200" height="200" style="padding-right: 40px;">
                        <div>
                            <p style="font-weight: bolder;"><?php echo $firstCartProductName; ?></p>
                            <p>Size: <?php echo $firstCartProductSize; ?> / Colour: Black</p>
                            <p style="font-weight: bolder;">SG $<?php echo number_format($firstCartProductPrice, 2); ?></p>
                        </div>
                    </div>
                    <div class="inputdiscount"> 
                        <input type="text" name="Discount" id="Discount" autocomplete="off" class="inputstyle" placeholder="Discount code or Voucher">
                        <button onclick="applyDiscount(document.getElementById('Discount').value,  <?php echo $subtotal; ?>)" class="apply">APPLY</button>
                    </div>
                    <div class="line" style="margin-top: 50px;"></div>
                    <table style="margin-bottom: 2px;">
                        <tr>
                            <td>
                                <h4 class="lefttable">Subtotal</h4>
                            </td>
                            <td>
                                <h4 class="righttable">
                                SG $<?php echo number_format($subtotal, 2); ?>
                                </h4>
                            </td>
                        </tr>
                        <tr id="discountRow" style="display: none;">
                            <td>
                                <h4 id="discountCode" class="lefttable">Discount <?php echo '(' . $discountCode . ')'; ?>
                                </h4>
                            </td>
                            <td>
                                <h4 id="discountAmount" class="righttable">−SG $<?php echo number_format($discountAmount, 2); ?>
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 class="lefttable">Shipping</h4>
                            </td>
                            <td>
                                <h4 id="shippingMethod" class="righttable"><?php echo $shippingText; ?></h4>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 class="lefttable">Est. Taxes (8%)</h4>
                            </td>
                            <td>
                                <h4 id="estimatedTaxes" class="righttable">
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
                                <h3 id="totalPrice" class="righttable">
                                    SG $<?php echo number_format($totalPrice, 2); ?>
                                </h3>
                            </td>
                        </tr>
                    </table>
                </div>   
            </div>
        </div> 
    </div>

    <form id="payment" method="post" action="../confirmation/confirmation.php" style="display: none;">
        <input type="hidden" name="orderid" value="<?php echo $orderId; ?>">
        <input type="hidden" name="changeemail" value="<?php echo $email; ?>">
        <input type="hidden" name="changeaddress" value="<?php echo $address; ?>">
        <input type="hidden" name="changeapartmentnumber" value="<?php echo $apartmentNumber; ?>">
        <input type="hidden" name="changepostalcode" value="<?php echo $postalCode; ?>">
        <input type="hidden" name="changeshippingmethod" value="<?php echo $shippingMethod; ?>">
        <input type="hidden" name="shippingfee" value="<?php echo $shippingFee; ?>">
        <input type="hidden" name="paymentmethod" value="">
        <input type="hidden" name="billingaddress" value="">
        <input type="hidden" name="discountcode" value="<?php echo $discountCode; ?>">
        <input type="hidden" name="discountamount" value="<?php echo $discountAmount; ?>">
        <input type="hidden" name="estimatedtaxes" value="<?php echo $estimatedTaxes; ?>">
        <input type="hidden" name="totalprice" value="<?php echo $totalPrice; ?>">
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
<script src="payment.js"></script>
</body>
</html>