function discountStatusChanged(id, status, token) {
    status = parseInt(status);
    id = parseInt(id);
    if (status == 0)
        status = status + 1;
    else
        status = status - 1;
    $.ajax({
        url: "/admin/discounts",
        data: {
            id: id,
            _token: token,
            status: status
        },
        type: "POST",
    });
}

if (document.getElementById('discount-category') != null) {
    document.getElementById('discount-category').onchange = function () {
        checkDiscountCategory();
    }
}

var flag;

function checkDiscountCategory() {
    var category = document.getElementById('discount-category').value;
    document.getElementById('template-render').innerHTML = '';
    if (category === '0')
    {
        container = document.getElementById('template-render');
        priceTemplate = document.getElementById('price-template').innerHTML;
        container.innerHTML += priceTemplate;
        flag = 1;
    }
    if (category === '1')
    {
        container = document.getElementById('template-render');
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
    if (flag == 1)
        document.getElementById('price-minimum-spend-container').innerHTML = '';
    if (flag == 2)
        document.getElementById('gift-minimum-spend-container').innerHTML = '';
    for (const key in minimumSpendContainer) {
        if (flag == 1) {
            minimumSpendRowContainer = document.getElementById('price-minimum-spend-container');
            minimumSpendRowTemplate = document.getElementById('price-minimum-spend-template').innerHTML;
            minimumSpendRowContainer.innerHTML += minimumSpendRowTemplate;
            if (key === "0") {
                document.querySelector('.price-remove-minimum-spend').setAttribute('class', 'd-none');
            }
        }
        if (flag == 2) {
            minimumSpendRowContainer = document.getElementById('gift-minimum-spend-container');
            minimumSpendRowTemplate = document.getElementById('gift-minimum-spend-template').innerHTML;
            minimumSpendRowContainer.innerHTML += minimumSpendRowTemplate;
            if (key === "0") {
                document.querySelector('.gift-remove-minimum-spend').setAttribute('class', 'd-none');
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
    }
    if (flag == 2) {
        removeObject = document.getElementsByClassName('gift-remove-minimum-spend');
        removeTemplate = document.getElementsByClassName('gift-remove-minimum-spend-row')[0];
        [...removeObject].forEach((remove, i) => {
            remove.innerHTML += removeTemplate.innerHTML;
            document.querySelectorAll('.fa')[i].onclick = function () {
                removeMinimumSpendRow(i);
            }
        });
    }
    document.getElementById('add-row').onclick = function () {
        addMinimumSpendRow();
    }
}

function addMinimumSpendRow() {
    minimumSpendContainer.push(1);
    renderMinimumSpendTemplate();
}

function removeMinimumSpendRow(index) {
    if ((index + 1) > -1) {
        minimumSpendContainer.splice((index + 1), 1);
        renderMinimumSpendTemplate();
    }
}
