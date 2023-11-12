if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}

function displayDiscountAndShipping() {
    const discountRow = document.getElementById('discountRow');
            
    if (!code || amount === 0) { 
        discountRow.style.display = 'none';
    } else {
        discountRow.style.display = 'table-row';
    }

    const expressRadio = document.getElementById('express');
    const standardRadio = document.getElementById('standard');

    if (shipping === 'express') {
        expressRadio.checked = true;
    } else {
        standardRadio.checked = true;
    }
}

window.onload = displayDiscountAndShipping;

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

function toggleShippingMethod() {
    const shippingMethodTr = document.getElementById('shippingMethodTr');
    const updateShippingMethodTr = document.getElementById('updateShippingMethodTr');

    shippingMethodTr.style.display = shippingMethodTr.style.display === 'none' ? 'table-row' : 'none';

    updateShippingMethodTr.style.display = updateShippingMethodTr.style.display === 'none' ? 'table-row' : 'none';
}

function changeShippingMethod(code, subtotal) {
    const shippingMethodDetails = document.getElementById('shippingMethodDetails');
    const expressRadio = document.getElementById('express');
    const standardRadio = document.getElementById('standard');
    
    const changeShippingInput = document.querySelector("input[name='changeshippingmethod']");

    const discountAmount = document.getElementById('discountAmount');
    let discountAmountValue = parseFloat(discountAmount.innerText.replace('−SG $', ''));

    var taxes = 0;
    const estimated = document.getElementById('estimatedTaxes');

    var total = 0;
    const price = document.getElementById('totalPrice');

    if (expressRadio.checked) {
        changeShippingInput.value = 'express';
        shippingMethodDetails.innerText = 'Express 2-3 Business Day Delivery';

        shippingMethod.innerText = 'SG $22.00';

        taxes = (subtotal - discountAmountValue + 22) * 0.08;
        estimated.innerText = 'SG $' + taxes.toFixed(2);

        total = (subtotal - discountAmountValue + 22) + taxes;
        price.innerText = 'SG $' + total.toFixed(2);
    } else {
        changeShippingInput.value = 'standard';
        shippingMethodDetails.innerText = 'Standard 3-7 Business Day Delivery';

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
    let discountAmountValue = parseFloat(discountAmount.innerText.replace('−SG $', ''));

    const discountRow = document.getElementById('discountRow');

    const discountCodeInput = document.querySelector("input[name='discountcode']");

    const shippingMethod = document.getElementById('shippingMethod');

    const expressRadio = document.getElementById('express');

    var taxes = 0;
    const estimated = document.getElementById('estimatedTaxes');

    var total = 0;
    const price = document.getElementById('totalPrice');

    if (code) {
        for (let i = 0; i < discountsArray.length; i++) {
            if (discountsArray[i].code === code) {
                discountCode.innerText = 'Discount (' + code + ')';
    
                var discount = 0;
                discount = subtotal * discountsArray[i].percentage;
                discountAmount.innerText = '−SG $' + discount.toFixed(2);
    
                discountRow.style.display = 'table-row';
    
                if (expressRadio.checked) {
                    shippingMethod.innerText = 'SG $22.00';
                    taxes = (subtotal - discount + 22) * 0.08;
                    total = (subtotal - discount + 22) * 1.08;
                } else {
                    shippingMethod.innerText = 'Free Local Shipping';
                    taxes = (subtotal - discount) * 0.08;
                    total = (subtotal - discount) * 1.08;
                }
    
                estimated.innerText = 'SG $' + taxes.toFixed(2);
    
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

        if (expressRadio.checked) {
            shippingMethod.innerText = 'SG $22.00';
            taxes = (subtotal + 22) * 0.08;
            total = (subtotal + 22) * 1.08;
        } else {
            shippingMethod.innerText = 'Free Local Shipping';
            taxes = subtotal * 0.08;
            total = subtotal * 1.08;
        }

        estimated.innerText = 'SG $' + taxes.toFixed(2);

        price.innerText = 'SG $' + total.toFixed(2);

        alert ('Invalid Discount Code or Voucher');

        return;
    } else {
        if (expressRadio.checked) {
            shippingMethod.innerText = 'SG $22.00';
            taxes = (subtotal - discountAmountValue + 22) * 0.08;
            total = (subtotal - discountAmountValue + 22) * 1.08;
        } else {
            shippingMethod.innerText = 'Free Local Shipping';
            taxes = (subtotal - discountAmountValue) * 0.08;
            total = (subtotal - discountAmountValue) * 1.08;
        }

        estimated.innerText = 'SG $' + taxes.toFixed(2);

        price.innerText = 'SG $' + total.toFixed(2);

        return;
    }
}

function paymentMethod(checkbox) {
    const creditCheckbox = document.querySelector("input[data-value='credit']");
    const paypalCheckbox = document.querySelector("input[data-value='paypal']");
    
    if (checkbox === creditCheckbox && checkbox.checked) {
        paypalCheckbox.checked = false;
    } else if (checkbox === paypalCheckbox && checkbox.checked) {
        creditCheckbox.checked = false;
    } else {
        if (!creditCheckbox.checked && !paypalCheckbox.checked) {
            checkbox.checked = true;
        }
    }
}

function billingMethod(checkbox) {
    const sameCheckbox = document.querySelector("input[data-value='same']");
    const differentCheckbox = document.querySelector("input[data-value='different']");
    
    if (checkbox === sameCheckbox && checkbox.checked) {
        differentCheckbox.checked = false;
    } else if (checkbox === differentCheckbox && checkbox.checked) {
        sameCheckbox.checked = false;
    } else {
        if (!sameCheckbox.checked && !differentCheckbox.checked) {
            checkbox.checked = true;
        }
    }

    const billingAddress = document.getElementById('billingAddress');
    const billingApartmentNumber = document.getElementById('billingApartmentNumber');
    const billingPostalCode = document.getElementById('billingPostalCode');
    
    if (checkbox === differentCheckbox && checkbox.checked) {
        billingAddress.style.display = 'flex';
        billingApartmentNumber.style.display = 'flex';
        billingPostalCode.style.display = 'flex';
    } else {
        billingAddress.style.display = 'none';
        billingApartmentNumber.style.display = 'none';
        billingPostalCode.style.display = 'none';
    }
}

function toConfirmation() {
    const creditCheckbox = document.querySelector("input[data-value='credit']");
    const paypalCheckbox = document.querySelector("input[data-value='paypal']");
    
    if (!creditCheckbox.checked && !paypalCheckbox.checked) {
        alert('Please select a payment method');
        return;
    }

    const sameCheckbox = document.querySelector("input[data-value='same']");
    const differentCheckbox = document.querySelector("input[data-value='different']");
    
    if (!sameCheckbox.checked && !differentCheckbox.checked) {
        alert('Please select a billing address');
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

    const changeShippingMethodInput = document.querySelector("input[name='changeshippingmethod']");

    const expressRadio = document.getElementById('express');

    const selectedShippingMethod = expressRadio.checked ? 'express' : 'standard';
    
    changeShippingMethodInput.value = selectedShippingMethod;

    const shippingFeeInput = document.querySelector("input[name='shippingfee']");

    if (changeShippingMethodInput.value === 'express') {
        shippingFeeInput.value = 22;
    } else {
        shippingFeeInput.value = 0;
    }

    const paymentMethodInput = document.querySelector("input[name='paymentmethod']");
    const selectedPayment = creditCheckbox.checked ? 'credit' : 'paypal';
    paymentMethodInput.value = selectedPayment;

    const billingAddressInput = document.querySelector("input[name='billingaddress']");
    const selectedBillingAddress = sameCheckbox.checked ? 'same' : 'different';

    const addressDetails = document.getElementById('addressDetails').innerText;

    const billingAddress = document.getElementById('billingAddress');
    const billingApartmentNumber = document.getElementById('billingApartmentNumber');
    const billingPostalCode = document.getElementById('billingPostalCode');

    if (selectedBillingAddress === 'different') {
        const billing = billingAddress.value + ', ' + billingApartmentNumber.value + ', ' + billingPostalCode.value;
        if (!billingAddress.value || !billingApartmentNumber.value || !billingPostalCode.value) {
            alert('Billing address is incomplete');
            return;
        }

        billingAddressInput.value = billing;
    } else {
        billingAddressInput.value = addressDetails;
    }

    const form = document.getElementById('payment');
    form.submit();
}