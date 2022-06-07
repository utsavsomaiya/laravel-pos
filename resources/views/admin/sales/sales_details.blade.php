@extends('admin.layout')
@section('content')
    <div class="col-md-12">
        <div class="card border-0 shadow-lg bg-light">
            <div class="card-title">
                <div class="mt-2">
                    <span class="h4 ms-3 me-5">Products</span>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="sales-details">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total price</th>
                            <th>Discount</th>
                            <th>Taxable Price</th>
                            <th>Tax Percentage</th>
                            <th>Total Tax</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($salesDetails as $key => $salesDetail)
                            <tr>
                                <td>{{ $salesDetail->products->id }}</td>
                                <td>
                                    {{ $salesDetail->products->name }}
                                </td>
                                <td>
                                    <img src="{{ $salesDetail->products->path }}">
                                </td>
                                <td>{{ '$'.$salesDetail->products->price }}</td>
                                <td>{{ $salesDetail->product_quantity }}</td>
                                <td>{{ '$'.($salesDetail->products->price * $salesDetail->product_quantity) }}</td>
                                <td>{{ '$'.$salesDetail->product_discount }}</td>
                                <td>{{ '$'.(($salesDetail->products->price * $salesDetail->product_quantity)- ($salesDetail->product_discount)) }}</td>
                                <td>{{ $salesDetail->products->tax."%" }}</td>
                                <td>{{ '$'.((((($salesDetail->products->price * $salesDetail->product_quantity)- ($salesDetail->product_discount)) * $salesDetail->products->tax))/100) }}</td>
                                <td>
                                    {{ '$'.((($salesDetail->products->price * $salesDetail->product_quantity)- ($salesDetail->product_discount)) + ((((($salesDetail->products->price * $salesDetail->product_quantity)- ($salesDetail->product_discount)) * $salesDetail->products->tax))/100))  }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="h6">No sales found.</td>
                            </tr>
                        @endforelse
                        @php $salesDetail = $salesDetails->first(); @endphp
                        @if(!is_null($salesDetail->sales->discounts))
                            @if($salesDetail->sales->discounts->promotion_type == 2)
                                <tr>
                                    <td>{{ $salesDetail->sales->discounts->giftDiscounts->find($salesDetail->product_discount_id)->product->id }}</td>
                                    <td>
                                        {{ $salesDetail->sales->discounts->giftDiscounts->find($salesDetail->product_discount_id)->product->name }}
                                        <span class="badge bg-warning ">Free</span>
                                    </td>
                                    <td>
                                        <img src="{{ $salesDetail->sales->discounts->giftDiscounts->find($salesDetail->product_discount_id)->product->path }}">
                                    </td>
                                    <td>
                                        {{ '$'.$salesDetail->sales->discounts->giftDiscounts->find($salesDetail->product_discount_id)->product->price }}
                                    </td>
                                    <td>1</td>
                                    <td>
                                        {{ '$'.($salesDetail->sales->discounts->giftDiscounts->find($salesDetail->product_discount_id)->product->price * 1) }}
                                    </td>
                                    <td>{{ '$'.$salesDetail->sales->total_discount }}</td>
                                    <td>0</td>
                                    <td>{{ $salesDetail->sales->discounts->giftDiscounts->find($salesDetail->product_discount_id)->product->tax.'%' }}</td>
                                    <td>$0</td>
                                    <td>$0</td>
                                </tr>
                            @endif
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        var subtotal = parseFloat('{{ $salesDetails[0]->sales->subtotal }}');
        var discount = parseFloat('{{ $salesDetails[0]->sales->total_discount }}');
        var tax = parseFloat('{{ $salesDetails[0]->sales->total_tax }}');
        var total = parseFloat('{{ $salesDetails[0]->sales->total }}');
    </script>
@endsection
