function discountStatusChanged(id, status, token) {
    status = parseInt(status);
    id = parseInt(id);
    if (status == 0) {
        status = status + 1;
    } else {
        status = status - 1;
    }
    $.ajax({
        type: "POST",
        url: "/admin/discounts/edit/"+id,
        data: {
            id: id,
            _token: token,
            status: status
        },
        error: function (response) {
            if (response.status === 422) {
                alertify.error(response.responseJSON.message);
            }
        }
    });
}

if (document.getElementById('promotion-type') != null) {
    document.getElementById('promotion-type').onchange = function () {
        checkPromotionType();
    }
}

var flag;

function checkPromotionType() {
    var promotionType = document.getElementById('promotion-type').value;
    document.getElementById('minimum-spend-amount-template').innerHTML = '';
    if (promotionType === '1'){
        container = document.getElementById('minimum-spend-amount-template');
        priceTemplate = document.getElementById('price-template').innerHTML;
        container.innerHTML += priceTemplate;
        flag = 1;
    }
    if (promotionType === '2'){
        container = document.getElementById('minimum-spend-amount-template');
        giftTemplate = document.getElementById('gift-template').innerHTML;
        container.innerHTML += giftTemplate;
        flag = 2;
    }
    renderMinimumSpendTemplate();
}

if (typeof minimumSpendContainer === 'undefined') {
    minimumSpendContainer = [0];
}

function renderMinimumSpendTemplate() {
    if (flag == 1) {
        document.getElementById('price-minimum-spend-container').innerHTML = '';
    } else {
        document.getElementById('gift-minimum-spend-container').innerHTML = '';
    }
    for (const key in minimumSpendContainer) {
        if (flag == 1) {
            minimumSpendRowContainer = document.getElementById('price-minimum-spend-container');
            minimumSpendRowTemplate = document.getElementById('price-minimum-spend-template').innerHTML;
            minimumSpendRowContainer.innerHTML += minimumSpendRowTemplate;
            if (key === "0") {
                document.querySelector('.price-remove-minimum-spend').classList.add('d-none');
            }
        } else {
            minimumSpendRowContainer = document.getElementById('gift-minimum-spend-container');
            minimumSpendRowTemplate = document.getElementById('gift-minimum-spend-template').innerHTML;
            minimumSpendRowContainer.innerHTML += minimumSpendRowTemplate;
            if (key === "0") {
                document.querySelector('.gift-remove-minimum-spend').classList.add('d-none');
            }
        }
    }
    if (flag == 1) {
        removeObject = document.getElementsByClassName('price-remove-minimum-spend');
        removeTemplate = document.getElementsByClassName('price-remove-minimum-spend-row')[0];
        [...removeObject].forEach((remove, i) => {
            remove.innerHTML += removeTemplate.innerHTML;
            document.querySelectorAll('.fa')[i].onclick = function () {
                removeMinimumSpendRow(i);
            }
        });
    } else {
        removeObject = document.getElementsByClassName('gift-remove-minimum-spend');
        removeTemplate = document.getElementsByClassName('gift-remove-minimum-spend-row')[0];
        [...removeObject].forEach((remove, i) => {
            remove.innerHTML += removeTemplate.innerHTML;
            document.querySelectorAll('.fa')[i].onclick = function () {
                removeMinimumSpendRow(i);
            }
        });
    }
    if (minimumSpendAmounts.length > 0) {
        for (i = 0; i < minimumSpendAmounts.length; i++) {
            document.getElementsByClassName('minimum-spend-amount')[i].value = parseFloat(minimumSpendAmounts[i]);
            if (digits.length > 0) {
                document.getElementsByClassName('digit')[i].value = parseFloat(digits[i]);
            }
            if (products.length > 0) {
                var select = document.querySelectorAll('.product')[i].options;
                [...select].forEach((element) => {
                    if (element.value == products[i]+'')
                        element.setAttribute('selected', 'selected');
                });
            }
        }
    }
    document.getElementById('add-row').onclick = function () {
        addMinimumSpendRow();
    }
}

function editRenderMinimumSpendTemplate() {
    if (minimumSpendAmounts.length > 0) {
        for (i = 1; i < minimumSpendAmounts.length ; i++){
            minimumSpendContainer.push(1);
        }
    }
    var select = document.getElementById('promotion-type').options;
    [...select].forEach(function (element) {
        if (element.selected == false) {
            element.setAttribute('disabled',true);
        }
    });
    checkPromotionType();
}

function addMinimumSpendRow() {
    if (flag == 2) {
        if (countOfProduct == minimumSpendContainer.length) {
            return alert('We have only '+countOfProduct+' Products');
        }
    }
    minimumSpendContainer.push(1);
    renderMinimumSpendTemplate();
}

function removeMinimumSpendRow(index) {
    if ((index) > -1) {
        minimumSpendContainer.splice((index), 1);
        if (minimumSpendAmounts.length > 0) {
            minimumSpendAmounts.splice((index), 1);
            if (digits.length > 0) {
                digits.splice((index), 1);
            }
            if (products.length > 0) {
                products.splice((index), 1);
            }
        }
        renderMinimumSpendTemplate();
    }
}
