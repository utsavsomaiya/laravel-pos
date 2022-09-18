<template id="cart-item">
    <div class="flex flex-row justify-between items-center mb-4">
        <div class="flex flex-row items-center w-2/5">
            <img class="w-10 h-10 object-cover rounded-md">
            <span class="ml-4 font-semibold text-sm"></span>
        </div>
        <div class="w-32 flex justify-between">
            <button class="px-3 py-1 rounded-md bg-gray-300 decrease">-</button>
            <input class="mx-2 border text-center w-8 input-quantity" type="number">
            <button class="px-3 py-1 rounded-md bg-gray-300 increase">+</button>
        </div>
        <div class="flex pl-3 font-semibold text-lg w-16 text-center">
            <div class="currency-sign"></div>
            <div class="price"></div>
        </div>
        <span class="px-3 py-1 rounded-md bg-red-300 text-white">x</span>
    </div>
</template>

<template id="cart-hidden">
    <input type="hidden" name="id[]" class="product-id">
    <input type="hidden" name="quantity[]"class="product-quantity">
</template>

<template id="discount-cart-item">
    <div class="flex flex-row justify-between items-center mb-4">
        <div class="flex flex-row items-center w-2/5">
            <img class="w-11 h-10 object-cover rounded-md discount-img">
            <span class="ml-2 font-semibold text-sm"></span>
        </div>
        <div class="w-32 flex justify-between">
            <button class="px-3 py-1 rounded-md bg-gray-300" disabled>-</button>
            <input class="mx-2 border text-center w-8" type="number" disabled value="1">
            <button class="px-3 py-1 rounded-md bg-gray-300" disabled>+</button>
        </div>
        <div class="flex pl-3 font-semibold text-lg w-16 text-center">
            <div class="discount-item-price"></div>
        </div>
        <span class="px-3 py-1 rounded-md bg-purple-300 text-white">x</span>
    </div>
</template>
