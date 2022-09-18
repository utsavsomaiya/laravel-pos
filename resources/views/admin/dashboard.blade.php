@extends('admin.layout')
@section('content')
    <div class="col-sm-9 ps-4">
        <div class="statistics-details d-flex align-items-center justify-content-between p-3">
            <div>
                <p class="mb-1 text-secondary">Total sales count</p>
                <h3>{{ $sales->count() }}</h3>
            </div>
            <div>
                <p class="mb-1 text-secondary">Total sales amount</p>
                <h3>{{ $sales->sum('total') }}</h3>
            </div>
            <div>
                <p class="mb-1 text-secondary">Total discount offered</p>
                <h3>{{ $sales->sum('total_discount') }}</h3>
            </div>
            <div class="d-none d-md-block">
                <p class="mb-1 text-secondary">Total tax collected</p>
                <h3>{{ $sales->sum('total_tax') }}</h3>
            </div>
        </div>
    </div>
@endsection
