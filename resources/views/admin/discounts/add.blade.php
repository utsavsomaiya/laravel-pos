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
                >
                    @csrf
                    <div class="form-group pb-3">
                        <label class="pb-1">Discount Name</label>
                        <input type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Discount Name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="form-group pb-3">
                        <label class="pb-1">Discount Category</label>
                        @once
                            @push('scripts')
                                <script src="{{ asset('js/discount.js') }}"></script>
                            @endpush
                            <select class="form-control @error('category') is-invalid @enderror"
                                name="category"
                                required
                                id="discount-category"
                            >
                                <option value="">--Select Discount Category--</option>
                                <option value="0"
                                    @selected(old('category') == "0")
                                >
                                    Price Discount
                                </option>
                                <option value="1"
                                    @selected(old('category') == "1")
                                >
                                    Gift Discount
                                </option>
                            </select>
                        @endonce
                        @error('category')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div id="template-render">
                        <!-- Template render here!! -->
                    </div>
                    <div class="form-group pb-2">
                        <label class="pb-1">Discount Status</label>
                        <select class="form-control @error('status') is-invalid @enderror"
                            name="status"
                            required
                        >
                            <option value="">--Select Discount Status--</option>
                            <option value="0"
                                @selected(old('status') == "0")
                            >Active</option>
                            <option value="1"
                                @selected(old('status') == "1")
                            >Inactive</option>
                        </select>
                        @error('status')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary me-2 mt-3" name="submit">
                        Submit
                    </button>
                    <a href="{{ route('discounts-list') }}" class="btn btn-light mt-3">Cancel</a>
                </form>
            </div>
        </div>
    </div>
    {{ view('admin.discounts.price_discount') }}
    {{ view('admin.discounts.gift_discount',compact('products')) }}

    @if($errors->count() > 0)
        @if(old('minimum_spend_amount'))
            <script src="{{ asset('js/discount.js') }}"></script>
            @for($i = 0; $i < (count(old('minimum_spend_amount')) - 1) ; $i++)
                <script>minimumSpendContainer.push(1)</script>
            @endfor
            <script>checkDiscountCategory();</script>
            @for($i = 0; $i < count(old('minimum_spend_amount')) ; $i++)
                <script>
                    var i = {{ Js::from($i) }};
                    var minimumSpendAmount = {{ Js::from(old('minimum_spend_amount.'.$i)) }};
                    document.getElementsByClassName('minimum-spend-amount')[i].value = minimumSpendAmount;
                </script>
                @if(old('digit'))
                    <script>
                        var i = {{ Js::from($i) }};
                        var digit = {{ Js::from(old('digit.'.$i)) }};
                        document.getElementsByClassName('minimum-spend-amount')[i].value = digit;
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
    <script> minimumSpendContainer = [0]; </script>
@endsection
