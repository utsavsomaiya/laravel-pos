@extends('admin.layout')
@section('content')
    <div class="col-md-8">
        <div class="card border-0 shadow-lg">
            <div class="card-title">
                <div class="mt-2">
                    <span class="h4 ms-3 me-5">Add new Product</span>
                </div>
            </div>
            <div class="card-body">
                <form class="forms-sample"
                    method="post"
                    enctype="multipart/form-data"
                    @empty($product) action="{{ route('products.store') }}" @endempty
                >
                    @csrf
                    @isset($product)
                        @method('PUT')
                    @endisset
                    <div class="form-group mb-2">
                        <label class="pb-1">Product Name</label>
                        <input type=" text"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Product Name"
                            name="name"
                            value="@isset($product){{ $product->name }}@else{{ old('name') }}@endisset"
                            required
                        >
                        @error('name')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label class="pb-1">Product Price</label>
                        <input type="number"
                            class="form-control @error('price') is-invalid @enderror"
                            placeholder="Product Price"
                            name="price"
                            value="@isset($product){{ $product->price }}@else{{ old('price') }}@endisset"
                            required
                        >
                        @error('price')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label class="pb-1">Select Category</label>
                        <select class="form-control @error('category_id') is-invalid @enderror"
                            name="category_id"
                            required
                        >
                            <option value="">--Select Category--</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    @isset($product)
                                        @selected($product->category_id == $category->id)
                                    @else
                                        @selected(old('category_id') == $category->id)
                                    @endisset
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label class="pb-1">Tax of the Product</label>
                        <select class="form-control @error('tax') is-invalid @enderror"
                            name="tax"
                            required
                        >
                            <option value="">--Select Tax--</option>
                            <option value="5"
                                @isset($product)
                                    @selected($product->tax == "5")
                                @else
                                    @selected(old('tax') == "5")
                                @endisset
                            >5%</option>
                            <option value="10"
                                @isset($product)
                                    @selected($product->tax == "10")
                                @else
                                    @selected(old('tax') == "10")
                                @endisset
                            >10%</option>
                            <option value="15"
                                @isset($product)
                                    @selected($product->tax == "15")
                                @else
                                    @selected(old('tax') == "15")
                                @endisset
                            >15%</option>
                            <option value="20"
                                @isset($product)
                                    @selected($product->tax == "20")
                                @else
                                    @selected(old('tax') == "20")
                                @endisset
                            >20%</option>
                            <option value="25"
                                @isset($product)
                                    @selected($product->tax == "25")
                                @else
                                    @selected(old('tax') == "25")
                                @endisset
                            >25%</option>
                        </select>
                        @error('tax')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label class="pb-1">Product Stock</label>
                        <input type="number"
                            class="form-control @error('stock') is-invalid @enderror"
                            placeholder="Product Stock"
                            name="stock"
                            value="@isset($product){{ $product->stock }}@else{{ old('stock') }}@endisset"
                            required
                        >
                        @error('stock')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    @isset($product)
                        <img class="m-2" src="{{ asset('storage/image').'/'.$product->image }}">
                    @endisset
                    <div class="form-group mb-2">
                        <label class="pb-1">Product Image</label>
                        <input type="file"
                            class="form-control @error('image') is-invalid @enderror"
                            accept="image/png, image/gif, image/jpeg, image/jpg"
                            name="image"
                            @empty($product)
                                required
                            @endempty
                        >
                        @error('image')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary me-2" name="submit">
                        {{ isset($product) ? 'Update' : 'Submit' }}
                    </button>
                    <a href="{{ route('products') }}" class="btn btn-light">
                        Cancel
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
