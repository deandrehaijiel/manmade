if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}

function selectedSize() {
    const sizeDropdown = document.getElementById('sizedropdown');
    const selectedSize = document.getElementById('selected_size');

    selectedSize.value = sizeDropdown.value;

    return selectedSize;
}

function addToCart(size) {
    if (!size) {
        alert('Please select a size');
        return;
    }

    const form = document.querySelector("form");
    form.submit();
}

function toShop() {
    window.location.href = '../shop/shop.php';
}