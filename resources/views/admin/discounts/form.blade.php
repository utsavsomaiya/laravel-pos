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
                            value="@isset($discount){{ $discount->name }}@else{{ old('name') }}@endisset"
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
                            @php $type = App\Models\Discount::PROMOTION_TYPE @endphp
                            @for($i = 1; $i <= count($type); $i++)
                                <option value="{{ $i }}"
                                    @isset($discount)
                                        @selected($discount->promotion_type == $i)
                                    @else
                                        @selected(old('promotion_type') == $i)
                                    @endisset
                                >
                                    {{ $type[$i] }}
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
                            @php $status = App\Models\Discount::STATUS; @endphp
                            @for($i = count($status)-1 ; $i >= 0; $i--)
                                <option value="{{ $i }}"
                                    @isset($discount)
                                        @selected($discount->status == $i)
                                    @else
                                        @if(old('status'))
                                            @selected(old('status') == $i)
                                        @endif
                                    @endisset
                                >{{ $status[$i] }}</option>
                            @endfor
                        </select>
                        @error('status')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary me-2 mt-3" name="submit">
                        @isset($discount)
                            Update
                        @else
                            Submit
                        @endisset
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
        var countOfProduct =  {{ Js::from(sizeof($products)) }} ;
    </script>
    @empty($discount)
        {{ view('admin.discounts.price_discount') }}
        {{ view('admin.discounts.gift_discount',compact('products')) }}
    @else
        @if($errors->count() == 0)
            @if($discount->promotion_type == "1")
                {{ view('admin.discounts.price_discount',compact('discount','products')) }}
            @endif
            @if($discount->promotion_type == "2")
                {{ view('admin.discounts.gift_discount',compact('discount','products')) }}
            @endif
            <script src="{{ asset('js/discount.js') }}"></script>
            @if($discount->promotion_type == "1")
                @foreach($discount->priceDiscounts as $key=>$priceDiscount)
                    <script>
                        var key = '{{ Js::from($key) }}';
                        minimumSpendAmounts[key] = '{{ $priceDiscount->minimum_spend_amount }}';
                        digits[key] = '{{ $priceDiscount->digit }}';
                    </script>
                @endforeach
            @endif
            @if($discount->promotion_type == "2")
                @foreach($discount->giftDiscounts as $key=>$giftDiscount)
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

    @if($errors->count() > 0)
        @isset($discount)
            @if($discount->promotion_type == "1")
                {{ view('admin.discounts.price_discount',compact('discount','products')) }}
            @endif
            @if($discount->promotion_type == "2")
                {{ view('admin.discounts.gift_discount',compact('discount','products')) }}
            @endif
        @endisset
        @if(old('minimum_spend_amount'))
            <script src="{{ asset('js/discount.js') }}"></script>
            @for($i = 0; $i < (count(old('minimum_spend_amount')) - 1) ; $i++)
                <script>minimumSpendContainer.push(1)</script>
            @endfor
            <script>checkPromotionType();</script>
            @for($i = 0; $i < count(old('minimum_spend_amount')) ; $i++)
                <script>
                    var i = {{ Js::from($i) }};
                    var minimumSpendAmount = {{ Js::from(old('minimum_spend_amount.'.$i)) }};
                    document.getElementsByClassName('minimum-spend-amount')[i].value = parseFloat(minimumSpendAmount);
                </script>
                @if(old('digit'))
                    <script>
                        var i = {{ Js::from($i) }};
                        var digit = {{ Js::from(old('digit.'.$i)) }};
                        document.getElementsByClassName('digit')[i].value = parseFloat(digit);
                    </script>
                @endif
                @if(old('product'))
                    <script>
                        var i = {{ Js::from($i) }};
                        var product = {{ Js::from(old('product.'.$i)) }};
                        var select = document.querySelectorAll('.product')[i].options;
                        [...select].forEach((element) => {
                            if(element.value == product)
                            element.setAttribute('selected','selected');
                        });
                    </script>
                @endif
                @if($errors->getBags()['default']->has('minimum_spend_amount.*'))
                    @error('minimum_spend_amount.'.$i)
                        <script>
                            var i = {{ Js::from($i) }};
                            var message = {{ Js::from($message) }};
                            document.getElementsByClassName('minimum-spend-error')[i].innerHTML = message;
                        </script>
                    @enderror
                @endif
                @if($errors->getBags()['default']->has('product.*'))
                    @error('product.'.$i)
                        <script>
                            var i = {{ Js::from($i) }};
                            var message = {{ Js::from($message) }};
                            document.getElementsByClassName('product-error')[i].innerHTML = message;
                        </script>
                    @enderror
                @endif
                @if($errors->getBags()['default']->has('digit.*'))
                    @error('digit.'.$i)
                        <script>
                            var i = {{ Js::from($i) }};
                            var message = {{ Js::from($message) }};
                            document.getElementsByClassName('digit-error')[i].innerHTML = message;
                        </script>
                    @enderror
                @endif
            @endfor
        @endif
    @endif
@endsection
