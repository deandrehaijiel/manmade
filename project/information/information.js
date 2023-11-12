if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}

function validateForm() {
    const emailValue = document.getElementById('Email').value;
    const countryValue = document.getElementById('Country').value;
    const firstNameValue = document.getElementById('FirstName').value;
    const lastNameValue = document.getElementById('LastName').value;
    const addressValue = document.getElementById('Address').value;
    const apartmentValue = document.getElementById('Apartment').value;
    const postalValue = document.getElementById('Postal').value;
    const phoneValue = document.getElementById('Phone').value;

    const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (!emailValue || !emailRegex.test(emailValue)) {
        alert('Please enter a valid email address');
        return false;
    }

    if (!emailValue || !countryValue || !firstNameValue || !lastNameValue || !addressValue || !apartmentValue || !postalValue || !phoneValue) {
        alert('All information must be filled');
        return false;
    }

    return true;
}

function applyDiscount(code, subtotal) {
    const discountInput = document.getElementById('Discount');
    const discountCode = document.getElementById('discountCode');
    const discountAmount = document.getElementById('discountAmount');
    const discountRow = document.getElementById('discountRow');
    const discountCodeInput = document.querySelector("input[name='discountcode']");

    var taxes = 0;
    const estimated = document.getElementById('estimatedTaxes');

    var total = 0;
    const price = document.getElementById('totalPrice');

    for (let i = 0; i < discountsArray.length; i++) {
        if (discountsArray[i].code === code) {
            discountCode.innerText = 'Discount (' + code + ')';

            var discount = 0;
            discount = subtotal * discountsArray[i].percentage;
            discountAmount.innerText = '−SG $' + discount.toFixed(2);

            discountRow.style.display = 'table-row';

            taxes = (subtotal - discount) * 0.08;
            estimated.innerText = 'SG $' + taxes.toFixed(2);

            total = (subtotal - discount) * 1.08;
            price.innerText = 'SG $' + total.toFixed(2);

            alert('Discount Applied');

            discountCodeInput.value = code;

            discountInput.value = '';

            return;
        }
    }

    discountRow.style.display = 'none';
    discountInput.value = '';
    discountCode.value = '';
    discountAmount.value = '';
    discountCodeInput.value = '';

    taxes = subtotal * 0.08;
    estimated.innerText = 'SG $' + taxes.toFixed(2);

    total = subtotal * 1.08;
    price.innerText = 'SG $' + total.toFixed(2);
    
    alert('Invalid Discount Code or Voucher');
}

function padZero(num, length = 2) {
    return String(num).padStart(length, '0');
}

function generateOrderId(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    const charactersLength = characters.length;

    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }

    const now = new Date();
    const dateTimeString = `${now.getFullYear()}${padZero(now.getMonth() + 1)}${padZero(now.getDate())}${padZero(now.getHours())}${padZero(now.getMinutes())}${padZero(now.getSeconds())}${padZero(now.getMilliseconds(), 3)}`;
    result += dateTimeString;

    return result;
}

function toShipping() {
    const isValid = validateForm();

    if (isValid) {
        const orderId = generateOrderId(16);
        const emailValue = document.getElementById('Email').value;
        const countryValue = document.getElementById('Country').value;
        const firstNameValue = document.getElementById('FirstName').value;
        const lastNameValue = document.getElementById('LastName').value;
        const addressValue = document.getElementById('Address').value;
        const apartmentValue = document.getElementById('Apartment').value;
        const postalValue = document.getElementById('Postal').value;
        const phoneValue = document.getElementById('Phone').value;

        const order = document.querySelector("input[name='orderid']");
        const emailInput = document.querySelector("input[name='email']");
        const countryInput = document.querySelector("input[name='country']");
        const firstNameInput = document.querySelector("input[name='firstname']");
        const lastNameInput = document.querySelector("input[name='lastname']");
        const addressInput = document.querySelector("input[name='address']");
        const apartmentInput = document.querySelector("input[name='apartmentnumber']");
        const postalInput = document.querySelector("input[name='postalcode']");
        const phoneInput = document.querySelector("input[name='phonenumber']");

        order.value = orderId;
        emailInput.value = emailValue;
        countryInput.value = countryValue;
        firstNameInput.value = firstNameValue;
        lastNameInput.value = lastNameValue;
        addressInput.value = addressValue;
        apartmentInput.value = apartmentValue;
        postalInput.value = postalValue;
        phoneInput.value = phoneValue;

        const discountAmount = document.getElementById('discountAmount');
        const estimatedTaxes = document.getElementById('estimatedTaxes');
        const totalPrice = document.getElementById('totalPrice');

        const discountAmountInput = document.querySelector("input[name='discountamount']");
        const estimatedTaxesInput = document.querySelector("input[name='estimatedtaxes']");
        const totalPriceInput = document.querySelector("input[name='totalprice']");

        let discountAmountValue = parseFloat(discountAmount.innerText.replace('−SG $', ''));
        if (isNaN(discountAmountValue) || !isFinite(discountAmountValue)) {
            discountAmountValue = 0.00;
        }
        discountAmountInput.value = discountAmountValue.toFixed(2);

        const estimatedTaxesValue = parseFloat(estimatedTaxes.innerText.replace('SG $', ''));
        const totalPriceValue = parseFloat(totalPrice.innerText.replace('SG $', ''));
        
        estimatedTaxesInput.value = estimatedTaxesValue.toFixed(2);
        totalPriceInput.value = totalPriceValue.toFixed(2);

        const form = document.getElementById('information');
        form.submit();
    }
}