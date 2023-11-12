if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}

function updateQuantity(action, id, pricePerProduct) {
    const quantityElement = document.getElementById('quantity_' + id);
    let currentQuantity = parseInt(quantityElement.innerText);

    if (action === 'subtract' && currentQuantity > 0) {
        currentQuantity -= 1;
    } else if (action === 'add') {
        currentQuantity += 1;
    }

    quantityElement.innerText = currentQuantity;

    const updatedProductPrice = pricePerProduct * currentQuantity;

    const priceElement = document.getElementById('price_' + id);
    priceElement.innerText = 'SG $' + updatedProductPrice.toFixed(2);

    const checkoutQuantityElement = document.querySelector("input[name='quantity_" + id + "']");
    checkoutQuantityElement.value = currentQuantity;

    let totalPrice = 0;
    const products = document.querySelectorAll('[id^="price_"]');
    products.forEach(product => {
        totalPrice += parseFloat(product.innerText.replace('SG $', ''));
    });

    const subtotalElement = document.getElementById('subtotal');
    subtotalElement.innerText = 'SG $' + totalPrice.toFixed(2);

    const totalElement = document.getElementById('total');
    totalElement.innerText = 'SG $' + totalPrice.toFixed(2);
}

function clearCart() {
    const form = document.getElementById('clearCart');
    form.submit();
}

function toInformation() {
    const totalElement = document.getElementById('total').innerText;

    if (totalElement === "SG $0.00") {
        alert('Cart cannot be empty');
        return;
    }

    const form = document.getElementById('cart');
    form.submit();
}