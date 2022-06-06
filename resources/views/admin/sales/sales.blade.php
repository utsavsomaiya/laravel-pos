@extends('admin.layout')
@section('content')
    <div class="col-md-12">
        <div class="card border-0 shadow-lg bg-light">
            <div class="card-title">
                <div class="mt-2">
                    <span class="h4 ms-3 me-5">Sales Details</span>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="sales">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Subtotal</th>
                            <th>Discount</th>
                            <th>Total tax</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $key => $sale)
                            <tr onclick=" window.location.href = '/admin/sales/{{ $sale->id }}' "
                                role="button"
                                style="--hover-color: gray"
                            >
                                <td>{{ $sale->id }}</td>
                                <td>{{ $sale->subtotal }}</td>
                                <td>{{ $sale->total_discount }}</td>
                                <td>{{ $sale->total_tax }}</td>
                                <td>{{ $sale->total }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="h6">No sales found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
