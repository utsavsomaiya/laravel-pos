@extends('admin.layout')
@section('content')
    <div class="col-md-8">
        <div class="card border-0 shadow-lg">
            <div class="card-title">
                <div class="mt-2">
                    <span class="h4 ms-3 me-5">Add New Discount</span>
                </div>
            </div>
            <div class="card-body">
                <form class="forms-sample"
                    method="post"
                    @empty($discount)
                        action="{{ route('discounts.store') }}"
                    @else
                        action="{{ route('discounts.update' , ['discount' => $discount->id ]) }}"
                    @endempty
                >
                    @isset($discount)
                        @method('PUT')
                    @endisset
                    @csrf
                    <div class="form-group pb-3">
                        <label class="pb-1">Discount Name</label>

                        <input type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Discount Name"
                            name="name"
                            value="{{ isset($discount) ? $discount->name : old('name') }}"
                            required
                        >

                        @error('name')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="form-group pb-3">
                        <label class="pb-1">Promotion Type</label>

                        <select class="form-control @error('promotion_type') is-invalid @enderror"
                            name="promotion_type"
                            required
                            id="promotion-type"
                        >
                            <option value="">--Select Promotion Type--</option>
                            @for($i = 1; $i <= count($promotionTypes); $i++)
                                <option value="{{ $i }}"
                                    {{ intval(old('promotion_type', isset($discount) ? ($discount->promotion_type) : '')) === $i ? 'selected' : '' }}
                                >
                                    {{ $promotionTypes[$i] }}
                                </option>
                            @endfor
                        </select>

                        @error('promotion_type')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>

                    <div id="minimum-spend-amount-template">
                        <!--Minimum Spend Amount Template render here!! -->
                    </div>

                    <div class="form-group pb-2">
                        <label class="pb-1">Discount Status</label>

                        <select class="form-control @error('status') is-invalid @enderror"
                            name="status"
                            required
                        >
                            <option value="">--Select Discount Status--</option>
                            @for($i = count($discountStatus)-1 ; $i >= 0; $i--)
                                <option value="{{ $i }}"
                                    {{ old('status', isset($discount) ? ($discount->status.'') : '') === $i.'' ? 'selected' : '' }}
                                >{{ $discountStatus[$i] }}</option>
                            @endfor
                        </select>
                        
                        @error('status')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary me-2 mt-3" name="submit">
                        {{ isset($discount) ? 'Update' : 'Submit' }}
                    </button>
                    <a href="{{ route('discounts') }}" class="btn btn-light mt-3">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        var minimumSpendAmounts = [];
        var digits = [];
        var products = [];
        var edit = '';
        var countOfProduct =  {{ Js::from(count($products)) }} ;
    </script>

    @empty ($discount)
        {{ view('admin.discounts.price_discount', compact('discountTypes')) }}
        {{ view('admin.discounts.gift_discount', compact('products')) }}
    @else
        @if ($errors->count() == 0)
            @if ($discount->promotion_type === $priceDiscount)
                {{ view('admin.discounts.price_discount', compact('discount', 'discountTypes')) }}
            @endif

            @if ($discount->promotion_type === $giftDiscount)
                {{ view('admin.discounts.gift_discount', compact('discount', 'products')) }}
            @endif

            <script src="{{ asset('js/discount.js') }}"></script>

            @if ($discount->promotion_type === $priceDiscount)
                @foreach ($discount->priceDiscounts as $key => $priceDiscount)
                    <script>
                        var key = '{{ Js::from($key) }}';
                        minimumSpendAmounts[key] = '{{ $priceDiscount->minimum_spend_amount }}';
                        digits[key] = '{{ $priceDiscount->digit }}';
                    </script>
                @endforeach
            @endif

            @if ($discount->promotion_type === $giftDiscount)
                @foreach ($discount->giftDiscounts as $key => $giftDiscount)
                    <script>
                        var key = '{{ Js::from($key) }}';
                        minimumSpendAmounts[key] = '{{ $giftDiscount->minimum_spend_amount }}';
                        products[key] = '{{ $giftDiscount->product->id }}';
                    </script>
                @endforeach
            @endif

            <script>editRenderMinimumSpendTemplate();</script>
        @endif
    @endempty

    @if ($errors->count() > 0)
        @isset ($discount)
            @if ($discount->promotion_type === $priceDiscount)
                {{ view('admin.discounts.price_discount', compact('discount', 'discountTypes')) }}
            @endif

            @if ($discount->promotion_type === $giftDiscount)
                {{ view('admin.discounts.gift_discount', compact('discount', 'products')) }}
            @endif
        @endisset

        @if (old('minimum_spend_amount'))
            <script src="{{ asset('js/discount.js') }}"></script>
            @for ($i = 0; $i < (count(old('minimum_spend_amount')) - 1) ; $i++)
                <script>minimumSpendContainer.push(1)</script>
            @endfor
            <script>checkPromotionType();</script>
            @foreach (old('minimum_spend_amount') as $key => $minimumSpendAmount)
                <script>
                    var i = {{ Js::from($key) }};
                    var minimumSpendAmount = {{ Js::from($minimumSpendAmount) }};
                    document.getElementsByClassName('minimum-spend-amount')[i].value = parseFloat(minimumSpendAmount);
                </script>

                @if (old('digit'))
                    <script>
                        var i = {{ Js::from($key) }};
                        var digit = {{ Js::from(old('digit.'.$key)) }};
                        document.getElementsByClassName('digit')[i].value = parseFloat(digit);
                    </script>
                @endif

                @if (old('product'))
                    <script>
                        var i = {{ Js::from($key) }};
                        var product = {{ Js::from(old('product.'.$key)) }};
                        var select = document.querySelectorAll('.product')[i].options;
                        [...select].forEach((element) => {
                            if(element.value == product)
                            element.setAttribute('selected', 'selected');
                        });
                    </script>
                @endif

                @if ($errors->getBags()['default']->has('minimum_spend_amount.*'))
                    @error('minimum_spend_amount.'.$key)
                        <script>
                            var i = {{ Js::from($key) }};
                            var message = {{ Js::from($message) }};
                            document.getElementsByClassName('minimum-spend-error')[i].innerHTML = message;
                        </script>
                    @enderror
                @endif

                @if ($errors->getBags()['default']->has('product.*'))
                    @error('product.'.$key)
                        <script>
                            var i = {{ Js::from($key) }};
                            var message = {{ Js::from($message) }};
                            document.getElementsByClassName('product-error')[i].innerHTML = message;
                        </script>
                    @enderror
                @endif

                @if ($errors->getBags()['default']->has('digit.*'))
                    @error('digit.'.$key)
                        <script>
                            var i = {{ Js::from($key) }};
                            var message = {{ Js::from($message) }};
                            document.getElementsByClassName('digit-error')[i].innerHTML = message;
                        </script>
                    @enderror
                @endif
            @endforeach
        @endif
    @endif
@endsection
