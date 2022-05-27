<template id="gift-template">
    <div class="gift">
        <h6 class="pt-2"><u><b>Minimum Spends</b></u></h6>
        <div class="form-group pb-3">
            <div class="pb-2">
                <button type="button"
                    class="input-group-text bg-primary text-white"
                    id="add-row"
                    style="margin-left: 37rem!important;"
                >Add new</button>
            </div>
            <div id="gift-minimum-spend-container">
                <!-- Here added Minimum Spends Row using javascript -->
            </div>
        </div>
    </div>
</template>

<template id="gift-minimum-spend-template">
    <div class="row pb-3">
        <div class="col-lg-6">
            <label class="pb-1">Minimum Spend Amount</label>
            <input type="number"
                class="form-control minimum-spend-amount"
                placeholder="Minium Spend Amount"
                name="minimum_spend_amount[]"
                step = "0.01"
            >
            <label class="text-danger mb-1 minimum-spend-error"></label>
        </div>
        <div class="col-lg-6">
            <label class="pb-1">
                Discount Product
                <span class="gift-remove-minimum-spend"
                    style="margin-left: 11rem!important;"
                ></span>
            </label>
            <select class="form-control product"
                name="product[]"
            >
                <option value="">--Select Product--</option>
                @foreach($products as $product)
                    <option value="{{ $product->name }}">{{ $product->name }}</option>
                @endforeach
            </select>
            <label class="text-danger mb-1 product-error"></label>
        </div>
    </div>
</template>

<template class="gift-remove-minimum-spend-row">
    <i class="fa fa-trash-o"></i>
</template>
