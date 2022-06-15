<template id="price-template">
    <div class="price">
        <div class="form-group">
            <label class="pb-1">Discount Type</label>
            <select class="form-control @error('type') is-invalid @enderror"
                name="type"
                required
            >
                <option value="">--Discount Type--</option>
                @php $type = App\Models\PriceDiscount::TYPE; @endphp
                @for($i = 1; $i <= count($type); $i++)
                    <option value="{{ $i }}"
                        @isset($discount)
                            @selected($discount->priceDiscounts[0]->type == $i)
                        @else
                            @selected(old('type') == $i)
                        @endisset
                    >{{ $type[$i] }}</option>
                @endfor
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
                <span class="price-remove-minimum-spend"></span>
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
