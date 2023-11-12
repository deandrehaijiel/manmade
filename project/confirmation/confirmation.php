<?php
    // require('/Applications/XAMPP/xamppfiles/htdocs/mail_patch.php');
    // use function mail_patch\mail;

    session_start();

    $firstCartProductPath = $_SESSION['first_cart_product_path'];
    $firstCartProductName = $_SESSION['first_cart_product_name'];
    $firstCartProductSize = $_SESSION['first_cart_product_size'];
    $firstCartProductPrice = $_SESSION['first_cart_product_price'];
    $firstCartProductQuantity = $_SESSION['first_cart_product_quantity'];

    $subtotal = $_SESSION['cart_subtotal'];

    $customerFirstName = $_SESSION['customer_first_name'];
    $customerPhoneNumber = $_SESSION['customer_phone_number'];
    
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
        $discountCode = $_POST['discountcode'];
        $discountAmount = $_POST['discountamount'];
        $estimatedTaxes = $_POST['estimatedtaxes'];
        $totalPrice = $_POST['totalprice'];
        $shippingMethod = $_POST['changeshippingmethod'];
        $shippingFee = $_POST['shippingfee'];
        $paymentMethod = $_POST['paymentmethod'];
        $billingAddress = $_POST['billingaddress'];
        $orderConfirmationDate = date("Y-m-d");

        $sqlUpdateCustomers = "UPDATE customers SET email = ?, address = ?, apartment_number = ?, postal_code = ? WHERE order_id = ?";
        $stmtUpdateCustomers = $conn->prepare($sqlUpdateCustomers);
        $stmtUpdateCustomers->bind_param("sssss", $email, $address, $apartmentNumber, $postalCode, $orderId);
        $stmtUpdateCustomers->execute();
        $stmtUpdateCustomers->close();

        $sqlUpdateOrders = "UPDATE orders SET discount_code = ?, discount_amount = ?, estimated_taxes = ?, total_price = ?, shipping_method = ?, shipping_fee = ?, payment_method = ?, billing_address = ?, order_confirmation_date = ? WHERE order_id = ?";
        $stmtUpdateOrders = $conn->prepare($sqlUpdateOrders);
        $stmtUpdateOrders->bind_param("sdddsdssss", $discountCode, $discountAmount, $estimatedTaxes, $totalPrice, $shippingMethod, $shippingFee, $paymentMethod, $billingAddress, $orderConfirmationDate, $orderId);
        $stmtUpdateOrders->execute();
        $stmtUpdateOrders->close();
    }

    $shipping = 'Standard 3-7 Business Day Delivery';
    $shippingText = 'Free Local Shipping';

    if ($shippingMethod == 'express') {
        $shipping = 'Express 2-3 Business Day Delivery';
        $shippingText = 'SG $22.00';
    }

    echo "<script>const paymentMethod = '$paymentMethod';</script>";

    if ($paymentMethod == 'credit') {
        $paymentMethodEmail = 'Credit Card';
    } else {
        $paymentMethodEmail = 'Paypal';
    }

    if ($discountCode && $discountAmount) {
        echo "<script>const code = '$discountCode'; const amount = '$discountAmount';</script>";
    } else {
        echo "<script>const code = ''; const amount = 0;</script>";
    }

    $sqlOrder = "SELECT name, price, size, quantity FROM orders WHERE tracking_id = ? AND order_id = ?";
    $stmtOrder = $conn->prepare($sqlOrder);
    $stmtOrder->bind_param("ss", $session_id, $orderId);
    $stmtOrder->execute();
    $resultOrder = $stmtOrder->get_result();

    $orderMessage = '';

    while ($product = $resultOrder->fetch_assoc()) {
        $orderMessage .= "\r\nShoe: " . $product['name'] . "\r\n";
        $orderMessage .= 'Price: SG $' . number_format($product['price'], 2) . "\r\n";
        $orderMessage .= 'Size: ' . $product['size'] . "\r\n";
        $orderMessage .= 'Quantity: ' . $product['quantity'] . "\r\n";
    }

    $stmtOrder->close();

    $to = 'f32ee@localhost';
    $subject = 'Your order with Order ID #' . $orderId . ' has been successfully confirmed!';
    if ($discountCode) {
        $message = 'Ciao ' . $customerFirstName . ',' . "\r\n\r\n\r\n" . 'Here are the details of your order:' . "\r\n\r\nOrder Confirmation Date: " . $orderConfirmationDate . "\r\n\r\nEmail: " . $email . "\r\n\r\nPayment Method: " . $paymentMethodEmail . "\r\n\r\nAddress: " . $address . ', ' . $apartmentNumber . ', ' . $postalCode . "\r\n\r\nPhone Number: " . $customerPhoneNumber . "\r\n\r\nShipping Method: " . $shipping . "\r\n\r\nBilling Address: " . $billingAddress . "\r\n" . $orderMessage . "\r\nSubtotal: SG $" . number_format($subtotal, 2) . "\r\nDiscount (" . $discountCode . '): SG $' . number_format($discountAmount, 2) . "\r\nShipping: SG $" . number_format($shippingFee, 2) . "\r\nEst. Taxes(8%): SG $" . number_format($estimatedTaxes, 2) . "\r\nTotal Price: SG $" . number_format($totalPrice, 2) . "\r\n\r\n\r\nGrazie," . "\r\nMANMADE";
    } else {
        $message = 'Ciao ' . $customerFirstName . ',' . "\r\n\r\n\r\n" . 'Here are the details of your order:' . "\r\n\r\nOrder Confirmation Date: " . $orderConfirmationDate . "\r\n\r\nEmail: " . $email . "\r\n\r\nPayment Method: " . $paymentMethodEmail . "\r\n\r\nAddress: " . $address . ', ' . $apartmentNumber . ', ' . $postalCode . "\r\n\r\nPhone Number: " . $customerPhoneNumber . "\r\n\r\nShipping Method: " . $shipping . "\r\n\r\nBilling Address: " . $billingAddress . "\r\n" . $orderMessage . "\r\nSubtotal: SG $" . number_format($subtotal, 2) . "\r\nShipping: SG $" . number_format($shippingFee, 2) . "\r\nEst. Taxes(8%): SG $" . number_format($estimatedTaxes, 2) . "\r\nTotal Price: SG $" . number_format($totalPrice, 2) . "\r\n\r\n\r\nGrazie," . "\r\nMANMADE";
    }
    $headers = 'From: f31ee@localhost' . "\r\n" .
    'Reply-To: f32ee@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers, '-ff32ee@localhost');

    $sqlDeleteCart = "DELETE FROM cart WHERE session = ?";
    $stmtDeleteCart = $conn->prepare($sqlDeleteCart);
    $stmtDeleteCart->bind_param("s", $session_id);
    $stmtDeleteCart->execute();
    $stmtDeleteCart->close();

    $conn->close();

    session_unset();

    session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title></title>
<link rel="stylesheet" href="confirmation.css">
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
        </header>
       
        <div class="bodydiv">
            <div class="confirmation">
                <div class="leftdiv">
                    <div class="thankyourow">
                        <img class="confirmed" src="../assets/elements/confirm.gif" alt="confirm">
                        <div style="display: flex; flex-direction: column; margin-left: 20px;">
                            <p>Order #<?php echo $orderId; ?></p>
                            <h3 style="font-weight: bolder; margin-top: -10px;">THANK YOU <?php echo strtoupper($customerFirstName); ?>!</h3>
                        </div>
                        <p style="margin-left: auto;"><span style="font-weight: bolder;">Tracking Number:</span><br><br><?php echo $session_id; ?></p>
                    </div>
                    <img src="../assets/elements/map.png" alt="map" width="800px">
                    <div class="confirmedrow">
                        <h4 style="font-weight: bolder;">
                            Your order is confirmed
                        </h4>
                        <p>
                            We have accepted your order, and we're getting it ready. Come back to this page or your email on your shipment updates.
                        </p>
                    </div>
                    <h3 style="margin-bottom: 6px; font-weight: bold;">Order Details</h3>
                    <table class="tablestyle">
                        <tr id="contactTr">
                            <td class="leftstyle" style="padding-top: 20px;">
                                <h4>Contact:</h4>
                            </td>
                            <td class="midstyle" style="padding-top: 20px;">
                                <h4 id="contactDetails"  style="font-weight: normal;"><?php echo $email; ?></h4>
                            </td>
                            <td class="space"></td>
                            <td class="rightstyle" style="padding-top: 20px;">
                                <h4>Payment method:<br><p id="creditCardPaymentMethod" style="font-weight: normal;">Credit Card</p></h4><img id="paypalPaymentMethod" style="margin-top: -30px; display: none;" src="../assets/elements/pp.png" alt="paypal">
                            </td>
                        </tr>

                        <tr id="addressTr">
                            <td class="leftstyle">
                                <h4>Address:</h4>
                            </td>
                            <td class="midstyle">
                                <h4 id="addressDetails" style="font-weight: normal;"><?php echo $address; ?>,<br><?php echo $apartmentNumber; ?>,<br><?php echo $postalCode; ?>,<br><?php echo $customerPhoneNumber; ?></h4>
                            </td>
                            <td class="space"></td>
                            <td class="rightstyle">

                            </td>
                        </tr>

                        <tr id="shippingMethodTr">
                            <td class="leftstyle">
                                <h4>Shipping<br>Method:</h4>
                            </td>
                            <td class="midstyle" style="padding-top: -24px;">
                                <h4 id="shippingMethodDetails"  style="font-weight: normal;"><?php echo $shipping; ?></h4>
                            </td>
                            <td class="space"></td>
                            <td class="rightstyle">
                                <h4>Billing address:<br><br>
                                    <span style="font-weight: normal;">
                                        <?php
                                            $addressParts = explode(',', $billingAddress);
                                            foreach ($addressParts as $index => $part) {
                                                if ($index < count($addressParts) - 1) {
                                                    echo trim($part) . ",<br>";
                                                } else {
                                                    echo trim($part);
                                                }
                                            }
                                        ?>
                                    </span>
                                </h4>
                            </td>
                        </tr>
                    </table>

                    <div class="buttonrow">
                        <div class="contactus">
                            <p>Need help?</p>
                            <p class="pstyle">Contact Us</p>
                        </div>
                        <button onclick="toHome()" class="continueshopping" style="padding: 0 30px;">Continue Shopping</button>
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
                    <div class="line" style="margin-bottom: 25px;"></div>
                    <p class="points">You're earning points on this order with MANMADE</p>
                    <div class="line" style="margin-top: 25px;"></div>
                    <table style="margin-bottom: 2px;">
                        <tr>
                            <td style="padding-top: 24px;">
                                <h4 class="lefttable">Subtotal</h4>
                            </td>
                            <td style="padding-top: 24px;">
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

    <footer class="footerrow">
        <div class="toprow">
            <p>Privacy Policy</p>
            <p>Terms of Service</p>
            <p>Order & Delivery</p>
            <p> Returns & Exchanges</p>
        </div>
        <h6 style="font-style: italic; margin-left: 20px;">MANMADE. Copyright 2023. All rights reserved.</h6>
    </footer>
<script src="confirmation.js"></script>
</body>
</html>