if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}

function displayDiscount() {
    const discountRow = document.getElementById('discountRow');
            
    if (!code || amount === 0) { 
        discountRow.style.display = 'none';
    } else {
        discountRow.style.display = 'table-row';
    }
}

window.onload = displayDiscount;

function toggleContact() {
    const contactTr = document.getElementById('contactTr');
    const updateContactTr = document.getElementById('updateContactTr');

    contactTr.style.display = contactTr.style.display === 'none' ? 'table-row' : 'none';

    updateContactTr.style.display = updateContactTr.style.display === 'none' ? 'table-row' : 'none';
}

function changeEmail() {
    const changeEmail = document.getElementById('changeEmail');
    const contactDetails = document.getElementById('contactDetails');
    const changeEmailInput = document.querySelector("input[name='changeemail']");

    const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    
    const emailValue = changeEmail.value.trim();
    
    if (emailRegex.test(emailValue)) {
        contactDetails.innerText = emailValue;
        changeEmailInput.value = emailValue;
        toggleContact();
    } else {
        alert('Please enter a valid email address');
    }
}

function toggleAddress() {
    const addressTr = document.getElementById('addressTr');
    const updateAddressTr = document.getElementById('updateAddressTr');

    addressTr.style.display = addressTr.style.display === 'none' ? 'table-row' : 'none';

    updateAddressTr.style.display = updateAddressTr.style.display === 'none' ? 'table-row' : 'none';
}

function changeAddress() {
    const addressDetails = document.getElementById('addressDetails');
    const changeAddress = document.getElementById('changeAddress');
    const changeApartmentNumber = document.getElementById('changeApartmentNumber');
    const changePostalCode = document.getElementById('changePostalCode');

    const changeAddressInput = document.querySelector("input[name='changeaddress']");
    const changeApartmentNumberInput = document.querySelector("input[name='changeapartmentnumber']");
    const changePostalCodeInput = document.querySelector("input[name='changepostalcode']");

    changeAddressInput.value = changeAddress.value;
    changeApartmentNumberInput.value = changeApartmentNumber.value;
    changePostalCodeInput.value = changePostalCode.value;

    if (!changeAddressInput.value || !changeApartmentNumberInput.value || !changePostalCodeInput.value) {
        alert('Please enter a valid shipping address');
        return;
    }

    addressDetails.innerText = changeAddress.value + ', ' + changeApartmentNumber.value + ', ' + changePostalCode.value;

    toggleAddress();
}

function shippingMethod(checkbox, subtotal) {
    const expressCheckbox = document.querySelector("input[data-value='express']");
    const standardCheckbox = document.querySelector("input[data-value='standard']");
    
    if (checkbox === expressCheckbox && checkbox.checked) {
        standardCheckbox.checked = false;
    } else if (checkbox === standardCheckbox && checkbox.checked) {
        expressCheckbox.checked = false;
    } else {
        if (!expressCheckbox.checked && !standardCheckbox.checked) {
            checkbox.checked = true;
        }
    }

    const value = expressCheckbox.checked ? 'express' : 'standard';

    const shippingMethod = document.getElementById('shippingMethod');

    const discountAmount = document.getElementById('discountAmount');
    let discountAmountValue = parseFloat(discountAmount.innerText.replace('−SG $', ''));

    var taxes = 0;
    const estimated = document.getElementById('estimatedTaxes');

    var total = 0;
    const price = document.getElementById('totalPrice');

    if (value === 'express') {
        shippingMethod.innerText = 'SG $22.00';

        taxes = (subtotal - discountAmountValue + 22) * 0.08;
        estimated.innerText = 'SG $' + taxes.toFixed(2);

        total = (subtotal - discountAmountValue + 22) + taxes;
        price.innerText = 'SG $' + total.toFixed(2);
    } else {
        shippingMethod.innerText = 'Free Local Shipping';

        taxes = (subtotal - discountAmountValue) * 0.08;
        estimated.innerText = 'SG $' + taxes.toFixed(2);

        total = (subtotal - discountAmountValue) + taxes;
        price.innerText = 'SG $' + total.toFixed(2);
    }
}

function applyDiscount(code, subtotal) {
    const discountInput = document.getElementById('Discount');
    const discountCode = document.getElementById('discountCode');
    const discountAmount = document.getElementById('discountAmount');
    const discountRow = document.getElementById('discountRow');
    const discountCodeInput = document.querySelector("input[name='discountcode']");

    const expressCheckbox = document.querySelector("input[data-value='express']");
    const value = expressCheckbox.checked ? 'express' : 'standard';

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

            if (value === 'express') {
                subtotal += 22;
            } 

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

function toPayment() {
    const expressCheckbox = document.querySelector("input[data-value='express']");
    const standardCheckbox = document.querySelector("input[data-value='standard']");
    
    if (!expressCheckbox.checked && !standardCheckbox.checked) {
        alert('Please select a shipping method');
        return;
    }  

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

    const shippingMethodInput = document.querySelector("input[name='shippingmethod']");

    const selectedShippingMethod = expressCheckbox.checked ? 'express' : 'standard';
    
    shippingMethodInput.value = selectedShippingMethod;

    const shippingFeeInput = document.querySelector("input[name='shippingfee']");

    if (shippingMethodInput.value === 'express') {
        shippingFeeInput.value = 22;
    } else {
        shippingFeeInput.value = 0;
    }

    const form = document.getElementById('shipping');
    form.submit();
}