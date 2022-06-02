<template id="discount-template">
    <div class="relative w-auto my-6 mx-auto max-w-sm">
        <div class="border-0 rounded-lg shadow-lg relative flex flex-col bg-white outline-none focus:outline-none" style="width:fit-content">
            <div class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-3xl font-semibold">
                    Discounts
                </h3>
                <button class="p-1 ml-auto bg-transparent border-0 text-black float-right text-3xl leading-none font-semibold outline-none focus:outline-none">
                    <span class="bg-transparent text-black h-6 w-6 text-2xl block outline-none focus:outline-none close-button">
                        ×
                    </span>
                </button>
            </div>
            <div class="relative p-6 flex-auto">
                <table class="table-fixed">
                    <thead>
                        <tr>
                            <th class="pr-5">Id</th>
                            <th class="pr-5">Name</th>
                            <th class="pr-5 w-5" colspan="2">Minimum Spend Amount</th>
                            <th class="pr-5 w-5">Discount (Price/Product)</th>
                            <th class="pr-5">Action</th>
                        </tr>
                    </thead>
                    <tbody id="discounts-table">
                        @php $count = 0; @endphp
                        @foreach($discounts as $key => $discount)
                            @if($discount->status == "0")
                                @if($discount->category == "0")
                                    @foreach($discount->priceDiscounts as $priceDiscount)
                                        @php $count++; @endphp
                                        <tr id="discounts-{{ $count }}" class="hidden">
                                            <td id="discount-id-{{ $count }}">{{ $discount->id }}</td>
                                            <label hidden id="discount-tier-id-{{ $count }}">
                                                {{ $priceDiscount->id }}
                                            </label>
                                            <td class="pr-3">{{ $discount->name }}</td>
                                            <td class="w-0.5">$</td>
                                            <td id="minimum-spend-amount-{{ $count }}">
                                                {{ $priceDiscount->minimum_spend_amount }}
                                            </td>
                                            <td class="flex pt-2" id="discounts-price-{{ $count }}">
                                                @if(!is_null($priceDiscount->type))
                                                    @if($priceDiscount->type == "0")
                                                        <div id="discount-digits-{{ $count }}">
                                                            {{ $priceDiscount->digit }}
                                                        </div>
                                                        <div id="discount-type-{{ $count }}">%</div>
                                                    @endif
                                                    @if($priceDiscount->type == "1")
                                                        <div id="discount-type-{{ $count }}">$</div>
                                                        <div id="discount-digit-{{ $count }}">
                                                            {{ $priceDiscount->digit }}
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                <button class="px-3 py-1 rounded-md bg-red-100 text-red-500"
                                                    id="apply-button-{{ $count }}"
                                                >
                                                    Apply
                                                    </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if($discount->category == "1")
                                    @foreach($discount->giftDiscounts as $giftDiscount)
                                        @php $count++; @endphp
                                        <tr id="discounts-{{ $count }}" class="hidden">
                                            <td id="discount-id-{{ $count }}">{{ $discount->id }}</td>
                                            <label hidden id="discount-tier-id-{{ $count }}">
                                                {{ $giftDiscount->id }}
                                            </label>
                                            <td class="pr-3">{{ $discount->name }}</td>
                                            <td class="w-0.5">$</td>
                                            <td id="minimum-spend-amount-{{ $count }}">
                                                {{ $giftDiscount->minimum_spend_amount }}
                                            </td>
                                            <td class="flex pt-2" id="discounts-price-{{ $count }}">
                                                <label hidden id="discount-product-price-{{ $count }}">
                                                    {{ $giftDiscount->products->price }}
                                                </label>
                                                <img class="w-11 h-11 object-cover rounded-md"
                                                    src="{{ $giftDiscount->products->path }}"
                                                >
                                            </td>
                                            <label hidden id="discount-product-name-{{ $count }}">
                                                {{ $giftDiscount->products->name }}
                                            </label>
                                            <td>
                                                <button class="px-3 py-1 rounded-md bg-red-100 text-red-500"
                                                    id="apply-button-{{ $count }}"
                                                >
                                                    Apply
                                                </button>
                                            </td>
                                        </labe>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
