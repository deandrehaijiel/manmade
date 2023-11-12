function displayDetails() {
    const discountRow = document.getElementById('discountRow');
            
    if (!code || amount === 0) { 
        discountRow.style.display = 'none';
    } else {
        discountRow.style.display = 'table-row';
    }

    const creditCardPaymentMethod = document.getElementById('creditCardPaymentMethod');
    const paypalPaymentMethod = document.getElementById('paypalPaymentMethod');

    if (paymentMethod === 'credit') {
        creditCardPaymentMethod.style.display = 'block';
        paypalPaymentMethod.style.display = 'none';
    } else {
        creditCardPaymentMethod.style.display = 'none';
        paypalPaymentMethod.style.display = 'inline';
    }
}

window.onload = displayDetails;

function toHome() {
    window.location.href = '../home/home.php';
}