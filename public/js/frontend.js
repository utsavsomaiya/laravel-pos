const cart = [];
const discountCart = [];

$("#clean-container").click(function () {
    cart.length = 0;
    displayCart();
});

for (let i = 1; i <= productsCount; i++) {
    $("#products-list-" + i).click(function () {
        addTocart(i);
    })
}

function existsInArray(id,name) {
    if (name == null) {
        return cart.some(function (element) {
            return element.id === id;
        });
    }
    if (id == null) {
        return cart.some(function (element) {
            return element.name == name;
        });
    }
}

function addTocart(id) {
    if (parseInt($("#stock-" + id).html().trim()) > 0) {
        if (existsInArray(id, null)) {
            var index = cart.findIndex((obj => obj.id == id));
            if (parseInt($("#stock-" + id).html().trim()) > cart[index].quantity) {
                cart[index].quantity = parseInt(cart[index].quantity) + 1;
            } else {
                alert('Out of stock!!');
            }
            var price = parseFloat($("#price-" + id).html().trim());
            price *= cart[index].quantity;
            cart[index].price = price;
        } else {
            const product = {
                "id" : id,
                "product_id" : $("#id-" + id).html().trim(),
                "name" : $("#name-" + id).html().trim(),
                "img": $("#image-"+id).attr('src').trim(),
                "price" : parseFloat($("#price-" + id).html().trim()),
                "tax" : $("#tax-" + id).html().trim(),
                "stock" : parseInt($("#stock-" + id).html().trim()),
                "quantity" : 1
            };
            cart.push(product);
        }
        displayCart();
    }
}

var flag = 0;
var discountPrice = 0;
var discountTierId = null;
var discountProductPrice = 0;
var minimumSpendAmount = null;
var finalDiscountAmount = 0;
var discountProductName = null;
var discountId = null;
var totalDiscount = 0;
var totalTax = 0;
var index = null;

function appliedDiscount(count) {
    if ($('#discount-digit-' + count).html() == null) {
        discountProductPrice = $("#discount-product-price-" + count).html().trim();
        discountProductName = $("#discount-product-name-" + count).html().trim();
        if (!existsInArray(null, discountProductName)) {
            return alert('Please purchase this item for applied this discount.');
        }
    }
    if (check == 1) {
        check = 0;
    }
    for (i = 1; i <= discountsCount; i++){
        $("#apply-button-" + i).html('Apply');
        $("#apply-button-" + i).removeClass('bg-green-100').removeClass('text-green-500');
        $("#apply-button-" + i).removeAttr('disabled', true);
        $("#apply-button-" + i).addClass('bg-red-100').addClass('text-red-500');
    }
    $("#apply-button-" + count).html('Applied');
    $("#apply-button-" + count).addClass('bg-green-100').addClass('text-green-500');
    $("#apply-button-" + count).attr('disabled', true);
    minimumSpendAmount = parseFloat($("#minimum-spend-amount-" + count).html().trim());
    if (subTotal > minimumSpendAmount) {
        if ($('#discount-digit-' + count).html() != null) {
            discountId = $("#discount-id-" + count).html().trim();
            discountTierId = $("#discount-tier-id-" + count).html().trim();
            discountPrice = parseFloat($("#discount-digit-" + count).html().trim());
            index = count;
            if (discountProductPrice != 0) {
                const findItem = cart.find((obj => obj.name == discountCart[0].name));
                if (findItem == null) {
                    cart.push(discountCart[0]);
                } else {
                    findItem.quantity += 1;
                    findItem.price += parseFloat(discountProductPrice);
                    subTotal += findItem.price;
                }
                discountCart.splice(0, 1);
            }
            if (discountPrice > subTotal) {
                alert('Your discount Price is greater than the subtotal.');
                discountPrice = subTotal;
            }
            discountProductName = null;
            discountProductPrice = 0;
        } else {
            discountId = $("#discount-id-" + count).html().trim();
            discountTierId = $("#discount-tier-id-" + count).html().trim();
            discountProductPrice = $("#discount-product-price-" + count).html().trim();
            discountProductName = $("#discount-product-name-" + count).html().trim();
            discountPrice = 0;
            if (discountCart.length == 1 && discountProductPrice != discountCart[0].price) {
                const findItem = cart.find((obj => obj.name == discountCart[0].name));
                if (findItem == null) {
                    cart.push(discountCart[0]);
                } else {
                    findItem.quantity += 1;
                    findItem.price += parseFloat(discountCart[0].price);
                    subTotal += findItem.price;
                }
                discountCart.length = 0;
            }
        }
        flag = 1;
        displayCart();
    }
}

var check = 0;
var discountFinalPrice = [];

function displayCart() {
    subTotal = 0;

    for (let i = 0; i < cart.length; i++) {
        subTotal += parseFloat(cart[i].price);
    }

    if (discountsCount > 0) {
        discountTemplateContainer = $("#discount-modal-id");
        if (discountTemplateContainer.html().trim() == "") {
            discountTemplate = $("#discount-template").html();
            discountTemplateContainer.html(discountTemplate);
        }
    }

    for (i = 1; i <= discountsCount ; i++) {
        if ($("#discount-type-"+i).html() != null) {
            discountType = $("#discount-type-" + i).html().trim();
            if (discountType == "%") {
                discountDigit = parseFloat($("#discount-digits-" + i).html().trim());
                discountFinalPrice[i-1] = (subTotal * discountDigit) / 100;
                $("#discounts-price-" + i).html('');
                discountPriceHTML = [
                    '<div>$</div>',
                    '<div id="discount-digit-' + i + '">' + discountFinalPrice[i-1].toFixed(2) + '</div>',
                    '<div id="discount-digits-' + i + '" class="hidden" >' + discountDigit + '</div>',
                    '<div id="discount-type-' + i + '" class="hidden" >%</div>',
                ].join("\n");
                $("#discounts-price-" + i).html(discountPriceHTML);
            }
        }
    }
    for (i = 0; i < discountFinalPrice.length; i++){
        if (flag == 1 && discountPrice != 0) {
            discountPrice = discountFinalPrice[index-1];
        }
    }

    for (i = 0; i < discountsCount; i++) {
        $("#discounts-" + (i + 1)).addClass('hidden');
        minimumSpendAmount = parseFloat($("#minimum-spend-amount-" + (i + 1)).html().trim());
        if (minimumSpendAmount < subTotal) {
            $("#discounts-" + (i + 1)).removeClass('hidden');
            $("#discount-img").removeClass('invisible');
            $("#apply-button-" + (i + 1)).attr('onclick','appliedDiscount('+ (i + 1) +')');
        }
    }

    if (flag == 0) {
        for (i = 1; i <= discountsCount; i++){
            minimumSpendAmount = parseFloat($("#minimum-spend-amount-" + i).html().trim());
            if (subTotal > minimumSpendAmount) {
                if ($("#discounts-price-" + i) != null) {
                    if ($("#discounts-price-" + i).children('img').attr('src') == null) {
                        discountId = $("#discount-id-" + i).html().trim();
                        discountTierId = $("#discount-tier-id-" + i).html().trim();
                        discountPrice = parseFloat($("#discount-digit-" + i).html().trim());
                        discountProductPrice = 0;
                        $("#apply-button-" + i).html('Applied');
                        $("#apply-button-" + i).addClass('bg-green-100').addClass('text-green-500');
                        $("#apply-button-" + i).attr('disabled', true);
                        if (discountPrice > subTotal) {
                            alert('Your discount Price is greater than the subtotal.');
                            discountPrice = subTotal;
                        }
                        break;
                    } else {
                        discountProductName = $("#discount-product-name-" + i).html().trim();
                        if (existsInArray(null, discountProductName) && discountCart.length == 0) {
                            discountId = $("#discount-id-" + i).html().trim();
                            discountTierId = $("#discount-tier-id-" + i).html().trim();
                            discountProductPrice = $("#discount-product-price-" + i).html().trim();
                            discountPrice = 0;
                            $("#apply-button-" + i).html('Applied');
                            $("#apply-button-" + i).addClass('bg-green-100').addClass('text-green-500');
                            $("#apply-button-" + i).attr('disabled', true);
                            var discountItemFetchFromCart = cart.find(
                                element => element.name == discountProductName
                            );
                            if (cart.length <= 1) {
                                discountCart.length = 0;
                                var discountItem = {
                                    'id': discountItemFetchFromCart.id,
                                    'img': discountItemFetchFromCart.img,
                                    'name': discountItemFetchFromCart.name,
                                    'price': discountProductPrice,
                                    'tax': discountItemFetchFromCart.tax,
                                    'discount': true,
                                    'quantity': 1
                                };
                                subTotal += parseFloat(discountProductPrice);
                                discountCart.push(discountItem);
                            }
                            break;
                        }
                    }
                }
            }
        }
    }

    if (check == 1) {
        for (i = 1; i <= discountsCount; i++) {
            $("#apply-button-" + i).html('Apply');
            $("#apply-button-" + i).removeClass('bg-green-100').removeClass('text-green-500');
            $("#apply-button-" + i).removeAttr('disabled', true);
            $("#apply-button-" + i).addClass('bg-red-100').addClass('text-red-500');
        }
    }

    for (let i = 0; i < cart.length; i++) {
        indexOfDiscountProduct = cart.findIndex(obj => obj.name == discountProductName);
        if (indexOfDiscountProduct == i && discountCart.length == 0 && check == 0) {
            var discountItemFetchFromCart = cart.find(element => element.name == discountProductName);
            discountCart.length = 0;
            if (cart[i].quantity == 1) {
                cart.splice(indexOfDiscountProduct, 1);
            } else if (cart[i].quantity > 1) {
                cart[i].quantity -= 1;
                cart[i].price -= parseFloat(discountProductPrice);
            }
            i--;
            var discountItem = {
                'id': discountItemFetchFromCart.id,
                'img': discountItemFetchFromCart.img,
                'name': discountItemFetchFromCart.name,
                'price': discountProductPrice,
                'tax': discountItemFetchFromCart.tax,
                'discount': true,
                'quantity': 1
            }
            discountCart.push(discountItem);
        }
    }

    $("#container").html('');
    $("#hidden-form").html('');

    for (let i = 0; i < cart.length; i++) {

        var template = $("#cart-item").html();
        var container = $("#container");
        container.append(template);

        var hiddenTemplate = $("#cart-hidden").html();
        var hiddenForm = $("#hidden-form");
        hiddenForm.append(hiddenTemplate);

        let hiddenIds = $(".product-id");
        hiddenIds.each(function (index) {
            $(this).val(cart[index].product_id);
        });

        let hiddenQuantities = $(".product-quantity");
        hiddenQuantities.each(function (index) {
            $(this).val(cart[index].quantity);
        });

        $(".w-10").each(function (index) {
            $(this).attr('src', cart[index].img);
            $(this).attr('alt', cart[index].name);
        });

        $(".ml-4").each(function (index) {
            $(this).html(cart[index].name);
        });

        let decreaseButtons = $(".decrease");
        decreaseButtons.each(function (index) {
            $(this).unbind().click(function () {
                changeQuantity(cart[index].id, "decrease");
            });
        });

        let quantities = $(".input-quantity");
        quantities.each(function (index) {
            $(this).val(cart[index].quantity);
            $(this).unbind().change(function () {
                inputQuantity(cart[index].id, index);
            });
            $(this).attr('id','input-id-'+index);
            $(this).attr('max',cart[index].stock);
        });

        let increaseButtons = $(".increase");
        increaseButtons.each(function (index) {
            $(this).unbind().click(function () {
                changeQuantity(cart[index].id, "increase");
            });
        });

        $(".currency-sign").each(function () {
            $(this).html("$");
        });

        $(".price").each(function (index) {
            $(this).html(cart[index].price.toFixed(2));
        });

        let removeButtons = $(".bg-red-300");
        removeButtons.each(function (index) {
            $(this).attr("role","button");
            $(this).unbind().click(function () {
                removeFromCart(cart[index].id);
            });
        });
    }

    var discountContainer = $("#discount-container");
    var discountContainerTemplate = $("#discount-cart-item").html();
    discountContainer.html('');
    for (i = 0; i < discountCart.length; i++) {
        discountContainer.append(discountContainerTemplate);
        $(".discount-img").attr('src', discountCart[i].img);
        $(".ml-2").html(discountCart[i].name + '<span class="bg-red-100 text-red-800 text-xs font-semibold ml-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Free</span>');
        $(".discount-item-price").html('$' + discountCart[i].price);
    }

    if (discountPrice !== 0) {
        finalDiscountAmount = (discountPrice).toFixed(2);
    }
    if (discountProductPrice !== 0) {
        finalDiscountAmount = (parseFloat(discountProductPrice)).toFixed(2);
    }
    if (discountPrice === 0 && discountProductPrice === 0) {
        finalDiscountAmount = 0;
    }

    totalDiscount = 0;
    totalTax = 0;

    var hiddenFormHTML = [
        '<input type="hidden" name="discounts_id" value="' + discountId + '">',
        '<input type="hidden" name="discounts_tier_id" value="' + discountTierId + '">'
    ].join("\n");
    $("#discount-form").html(hiddenFormHTML);

    for (let i = 0; i < cart.length; i++) {
        discount = (parseFloat(cart[i].price) * finalDiscountAmount) / subTotal;
        totalDiscount += discount;
        if (discountProductPrice !== 0) {
            discount = 0;
        }
        tax = ((parseFloat(cart[i].price) - discount) * parseFloat(cart[i].tax) / 100);
        totalTax += tax;
    }

    grandTotal = subTotal - finalDiscountAmount + totalTax;

    $("#subtotal").html("$" + (subTotal).toFixed(2));

    if ($("#discount-price") != null) {
        $("#discount-price").html("- $"+finalDiscountAmount);
    }
    $("#sales-tax").html("+ $"+(totalTax).toFixed(2));

    $("#total").html("$" + (grandTotal).toFixed(2));
}

function changeQuantity(productId, checked) {
    var indexOfProduct = cart.findIndex((obj => obj.id == productId));
    cart[indexOfProduct].quantity = isNaN(cart[indexOfProduct].quantity) ? 0 : cart[indexOfProduct].quantity;
    if (checked == "increase") {
        if (parseInt($("#stock-" + productId).html().trim()) > parseInt(cart[indexOfProduct].quantity)) {
            cart[indexOfProduct].quantity = parseInt(cart[indexOfProduct].quantity) + 1;
        } else {
            alert('Out of stock!!');
        }
        price = parseFloat($("#price-" + productId).html().trim()) * cart[indexOfProduct].quantity;
        cart[indexOfProduct].price = price;
        displayCart();
    }
    if (checked == "decrease") {
        cart[indexOfProduct].quantity = isNaN(cart[indexOfProduct].quantity) ? 0 : cart[indexOfProduct].quantity;
        if (cart[indexOfProduct].quantity > 1) {
            cart[indexOfProduct].quantity = parseInt(cart[indexOfProduct].quantity) - 1;
            price = parseFloat($("#price-" + productId).html().trim()) * cart[indexOfProduct].quantity;
            cart[indexOfProduct].price = price;
            subTotal -= price;
            if (minimumSpendAmount > subTotal) {
                discountCart.length = 0;
                check = 1;
                discountProductPrice = 0;
                discountPrice = 0;
            }
            displayCart();
        } else {
            removeFromCart(productId);
        }
    }
}

function inputQuantity(productId, id) {
    var indexOfProduct = cart.findIndex((obj => obj.id == productId));
    if (parseInt($("#stock-"+productId).html().trim()) > parseInt($("#input-id-"+id).val())) {
        cart[indexOfProduct].quantity = $("#input-id-"+id).val();
    } else {
        alert('Available stock is --> ' + $("#stock-" + productId).html().trim());
        $("#input-id-" + id).val($("#stock-" + productId).html().trim());
        cart[indexOfProduct].quantity = $("#input-id-" + id).val();
    }
    price = parseInt($("#price-" + productId).html().trim()) * cart[indexOfProduct].quantity;
    cart[indexOfProduct].price = price;
    displayCart();
}

$(document).on('keyup', function (e) {
    if (e.key == "Escape")
        $("#discount-img").click();
});

$("#discount-img").click(function () {
    $(".close-button").click(function () {
        displayApplicableDiscountsModal();
    });
    displayApplicableDiscountsModal();
});


function displayApplicableDiscountsModal() {
    $("#discount-modal-id").toggleClass('hidden');
    $("#discount-modal-id-backdrop").toggleClass('hidden');
    $("#discount-modal-id").toggleClass('flex');
    $("#discount-modal-id-backdrop").toggleClass('flex');
}

function removeFromCart(productId) {
    var findProduct = cart.find((obj => obj.id == productId));
    subTotal -= findProduct.price;
    if (minimumSpendAmount > subTotal) {
        discountCart.length = 0;
        check = 1;
        discountProductPrice = 0;
        discountPrice = 0;
    }
    var indexOfProduct = cart.findIndex((obj => obj.id == productId));
    var indexOfDiscountProduct = discountCart.findIndex((obj => obj.id == productId));
    if (indexOfDiscountProduct > -1) {
        discountCart.splice(0, 1);
        discountProductPrice = 0;
        discountPrice = 0;
    }
    if (indexOfProduct > -1) {
        cart.splice(indexOfProduct, 1);
    }
    if (discountCart.length == 1 && cart.length == 0) {
        discountCart.splice(0, 1);
        discountProductPrice = 0;
        discountPrice = 0;
    }
    displayCart();
}

$("#searchbar").keyup(function () {
    searchProducts($(this).val().toLowerCase());
});

function searchProducts(value) {
    var hasResults = false;
    for (i = 1; i <= productsCount; i++) {
        var name = $("#name-" + i).html().trim();
        var price = $("#price-" + i).html().trim();
        var category = $("#category-" + i).html().trim();
        $("#products-list-" + i).css('display', 'none');
        if (name.toLowerCase().includes(value) || category.toLowerCase().includes(value) || price.toLowerCase().includes(value)) {
            $("#products-list-" + i).css('display', 'block');
            hasResults = true;
        }
    }
    hasResults ? $("#not-available").css('display','none') : $("#not-available").css('display','block') ;
}
