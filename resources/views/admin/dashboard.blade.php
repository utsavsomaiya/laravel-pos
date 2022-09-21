@extends('admin.layout')
@section('content')
    <div class="col-sm-9 ps-4">
        <div class="statistics-details d-flex align-items-center justify-content-between p-3">
            <div>
                <p class="mb-1 text-secondary">Total Products</p>
                <h3>{{ App\Models\Product::all()->count() }}</h3>
            </div>
            <div>
                <p class="mb-1 text-secondary">Total Categories</p>
                <h3>{{ App\Models\Category::all()->count() }}</h3>
            </div>
            <div>
                <p class="mb-1 text-secondary">Total discount offered</p>
                <h3>0</h3>
            </div>
            <div>
                <p class="mb-1 text-secondary">Total Gift Discount</p>
                <h3>0</h3>
            </div>
            <div class="d-none d-md-block">
                <p class="mb-1 text-secondary">Total tax collected</p>
                <h3>0</h3>
            </div>
        </div>
    </div>
@endsection
