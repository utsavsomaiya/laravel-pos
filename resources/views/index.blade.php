<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ asset('icon/retail-store-icon-18.png') }}" type="image/x-icon">
        <title>Retail Shop</title>
        <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.0.2/dist/tailwind.min.css">
        <link rel="stylesheet" href="{{ asset('css/alertify.min.css') }}">
        <style>
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
        </style>
    </head>
    <body class="bg-gray-200">
        <div class="container mx-auto px-5 bg-white">
            <div class="flex lg:flex-row flex-col-reverse shadow-lg">
                <div class="w-full lg:w-3/5 min-h-screen shadow-lg">
                    <div class="flex flex-row justify-between items-center px-5 mt-5">
                        <div class="text-gray-800">
                            <div class="font-bold text-xl">Utsav's Retail Shop</div>
                            <span class="text-xs">
                                "Aashirvad", 7-Nandhinagar, Nanavati Chowk, Rajkot-360007
                            </span>
                        </div>
                        @if(count($products) > 0)
                            <input type="text" placeholder="Search Products" class="w-full h-12 px-4 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg lg:w-20 xl:transition-all xl:duration-300 xl:w-36 xl:focus:w-44 lg:h-10 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-teal-500 dark:focus:border-teal-500 focus:outline-none focus:ring focus:ring-primary dark:placeholder-gray-400 focus:ring-opacity-40" id="searchbar">
                        @endif
                    </div>
                    <div class="grid grid-cols-3 gap-4 px-5 mt-5 overflow-y-auto h-3/4">
                        <div id="not-available" style="display: none;">
                            <h5 style="width: 400px;">
                                Sorry, the products has not been added yet...
                            </h5>
                        </div>
                        @forelse($products as $key => $product)
                            <div class="transform hover:scale-105 transition duration-300 px-3 py-3 flex flex-col border border-gray-200 rounded-md h-32 justify-between @if($product->stock <= 0) opacity-50 @endif"
                                id="products-list-{{ $key+1 }}"
                            >
                                <div>
                                    <label hidden id="id-{{ $key+1 }}">
                                        {{ $product->id }}
                                    </label>
                                    <label hidden id="stock-{{ $key+1 }}">
                                        {{ $product->stock }}
                                    </label>
                                    <div class="font-bold text-gray-800" id="name-{{ $key+1 }}">
                                        {{ $product->name }}
                                    </div>
                                    <span class="font-light text-sm text-gray-400" id="category-{{ $key+1 }}">
                                        {{ $product->category->name }}
                                    </span>
                                </div>
                                <div class="flex flex-row justify-between items-center">
                                    <div class="flex space-x-0 self-end font-bold text-lg text-yellow-500">
                                        <span>$</span>
                                        <span id="price-{{ $key+1 }}">
                                            {{ $product->price }}
                                        </span>
                                    </div>
                                    <div class="flex space-x-0 self-end font-bold text-lg text-red-500">
                                        <span id="tax-{{ $key+1 }}">
                                            {{ $product->tax }}
                                        </span>
                                        <span>%</span>
                                    </div>
                                    <img src="{{ $product->path }}" id="image-{{ $key+1 }}" class=" h-14 w-14 object-cover rounded-md" alt="Product Image">
                                </div>
                            </div>
                        @empty
                            <span class="h6">No products found.</span>
                        @endforelse
                    </div>
                </div>
                <div class="w-full lg:w-2/5">
                    <div class="flex flex-row items-center justify-between px-5 mt-5">
                        <div class="font-bold text-xl">Current Order</div>
                        <div class="font-semibold">
                            <span class="px-4 py-2 rounded-md bg-red-100 text-red-500"
                                id="clean-container"
                                role="button"
                            >
                                Clear All
                            </span>
                        </div>
                    </div>
                    <div class="px-5 py-4 mt-5 overflow-y-auto h-64">
                        <div id="container"></div>
                        <div id="discount-container"></div>
                    </div>
                    <div class="px-5 mt-5">
                        <div class="py-4 rounded-md shadow-lg">
                            <div class=" px-4 flex justify-between">
                                <span class="font-semibold text-sm">Subtotal</span>
                                <span class="font-bold" id="subtotal">$0.00</span>
                            </div>
                            <div class="px-4 flex justify-between">
                                @php $flag = 0; @endphp
                                @if(sizeof($discounts) > 0)
                                    @foreach($discounts as $key => $discount)
                                        @if($discount->status == "1")
                                            @php $flag = 1; @endphp
                                            @break;
                                        @endif
                                    @endforeach
                                @endif
                                @if($flag == 1)
                                    <span class="font-semibold text-sm">
                                        <span class="pr-2">Discount</span>
                                        <i class="fa-solid fa-tag invisible"
                                            id="discount-img" class="absolute mr-20">
                                        </i>
                                    </span>
                                    <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="discount-modal-id">
                                    </div>
                                    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="discount-modal-id-backdrop"></div>
                                    <span class="font-bold" id="discount-price">- $0.00</span>
                                @endif
                            </div>
                            <div class=" px-4 flex justify-between">
                                <span class="font-semibold text-sm">Sales Tax</span>
                                <span class="font-bold" id='sales-tax'>+ $0.00</span>
                            </div>
                            <div class="border-t-2 mt-3 py-2 px-4 flex items-center justify-between">
                                <span class="font-semibold text-2xl">Total</span>
                                <span class="font-bold text-2xl" id="total">$0.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="px-5 mt-5">
                        <form method="post">
                            @csrf
                            <div id='hidden-form'></div>
                            <div id="discount-form"></div>
                            <button name="submit" class="px-4 py-4 rounded-md shadow-lg text-center bg-yellow-500 text-white font-semibold" style="width: 500px;">Complete Sale</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{ view('cart_template') }}
        {{ view('discount',compact('discounts')) }}
        <script src="https://kit.fontawesome.com/40d870b470.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            var productsCount = '{{ sizeof($products) }}';
        </script>
        <script>
            var discountsCount = 0;
        </script>
        @isset($discounts)
            @foreach($discounts as $discount)
                @if($discount->status == "1")
                    @if(sizeof($discount->priceDiscounts) > 0)
                        <script> discountsCount += parseInt('{{ sizeof($discount->priceDiscounts) }}');  </script>
                    @endif
                    @if(sizeof($discount->giftDiscounts) > 0)
                        <script> discountsCount += parseInt('{{ sizeof($discount->giftDiscounts) }}');  </script>
                    @endif
                @endif
            @endforeach
        @endisset
        <script src="{{ asset('js/frontend.js') }}"></script>
        <script src="{{ asset('js/alertify.min.js') }}"></script>
        @error("id")
            <script> alertify.error("{{ $message }}"); </script>
        @enderror
        @if(session('success'))
            <script>
                alertify.success("{{ session('success') }}");
            </script>
        @endif
    </body>
</html>
