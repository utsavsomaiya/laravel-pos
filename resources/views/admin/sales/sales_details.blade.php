@extends('admin.layout')
@section('content')
    <div class="col-md-10">
        <div class="card border-0 shadow-lg">
            <div class="card-title">
                <div class="mt-2">
                    <span class="h4 ms-3 me-5">Products</span>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
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
                                    @if($salesDetail->discounts->category == "1" && $key == sizeof($salesDetails) - 1)
                                        {{ $salesDetail->products->name }}
                                        <span class="badge bg-warning">Free</td>
                                    @else
                                        {{ $salesDetail->products->name }}
                                    @endif
                                </td>
                                <td>
                                    <img src="{{ $salesDetail->products->image }}">
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
                        <tr>
                            <td colspan="11" class="mt-3">
                                <span class="badge bg-danger">Thank you!!</span>
                                <div style="margin-left: 34rem!important;">
                                    <span class="h6">Subtotal : - &nbsp;&nbsp;&nbsp;{{ "$".$salesDetails[0]->sales->subtotal }}</span><br>
                                    <span class="h6">Discount : - &nbsp;&nbsp; {{ "-$".$salesDetails[0]->sales->total_discount }}</span><br>
                                    <span class="h6"><span class="pe-5">Tax : -</span> {{ "+$".$salesDetails[0]->sales->total_tax }}</span><br>
                                    <span>=================</span><br>
                                    <span class="h6"><span class="pe-5">Total:-</span>{{ "$".$salesDetails[0]->sales->total}}</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
