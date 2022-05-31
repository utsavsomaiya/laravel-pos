<template id="price-template">
    <div class="price">
        <div class="form-group">
            <label class="pb-1">Discount Type</label>
            <select class="form-control @error('type') is-invalid @enderror"
                name="type"
                required
            >
                <option value="">--Discount Type--</option>
                <option value="0"
                    @isset($discount)
                        @selected($discount->priceDiscounts[0]->type == "0")
                    @else
                        @selected(old('type') == "0")
                    @endisset
                >Percentage Discount</option>
                <option value="1"
                     @isset($discount)
                        @selected($discount->priceDiscounts[0]->type == "1")
                    @else
                        @selected(old('type') == "1")
                    @endisset
                >Price Discount</option>
            </select>
            @error('type')
                <label class="text-danger">{{ $message }}</label>
            @enderror
        </div>
        <h6 class="pt-4"><u><b>Minimum Spends</b></u></h6>
        <div class="form-group pb-3">
            <div class="pb-2">
                <button type="button"
                    class="input-group-text bg-primary text-white"
                    style="margin-left: 37rem!important;"
                    id="add-row"
                >Add new</button>
            </div>
            <div id="price-minimum-spend-container">
                <!-- Here added Minimum Spends Row using javascript -->
            </div>
        </div>
    </div>
</template>

<template id="price-minimum-spend-template">
    <div class="row pb-3">
        <div class="col-lg-6 pe-1">
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
                Discount digit
                <span class="price-remove-minimum-spend"
                    style="margin-left: 13rem!important;"
                ></span>
            </label>
            <input type="number"
                class="form-control digit"
                placeholder="Discount digit"
                name="digit[]"
                step = "0.01"
            >
            <label class="text-danger mb-1 digit-error"></label>
        </div>
    </div>
</template>

<template class="price-remove-minimum-spend-row">
    <i class="fa fa-trash-o"></i>
</template>
