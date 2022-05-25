@extends('admin.layout')
@section('content')
    <div class="col-sm-9 ps-4">
        <div class="statistics-details d-flex align-items-center justify-content-between p-3">
            <div>
                <p class="mb-1 text-secondary">Total sales count</p>
                <h3>6</h3>
            </div>
            <div>
                <p class="mb-1 text-secondary">Total sales amount</p>
                <h3>193244.93</h3>
            </div>
            <div>
                <p class="mb-1 text-secondary">Total discount offered</p>
                <h3>4128.01</h3>
            </div>
            <div>
                <p class="mb-1 text-secondary">Total Gift Discount</p>
                <h3>1</h3>
            </div>
            <div class="d-none d-md-block">
                <p class="mb-1 text-secondary">Total tax collected</p>
                <h3>21678.94</h3>
            </div>
        </div>
    </div>
@endsection
