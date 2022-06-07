@extends('admin.layout')
@section('content')
    <div class="col-md-12">
        <div class="card border-0 shadow-lg bg-light">
            <div class="card-title">
                <div class="mt-2">
                    <span class="h4 ms-3 me-5">Products</span>
                    <span class="ms-3">
                        <a href="{{ route('products.add') }}"
                            class="link-dark h6"
                        >
                            Add New Product
                        </a>
                    </span>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="products">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Tax</th>
                            <th>Stock</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ '$'.$product->price }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->tax.'%' }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <img src="{{ $product->path }}"></td>
                                <td>
                                    <a href="{{ route('products.edit', ['product' => $product->id ]) }}"
                                        class="link-dark text-decoration-none"
                                    >
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <form method="post"
                                        action="{{ route('products.delete', ['product' => $product->id]) }}"
                                        id="delete-product-{{ $product->id }}"
                                        class="d-inline-block"
                                    >
                                        @csrf
                                        <button type="button"
                                            class="bg-light border-0"
                                            onclick="deleteConfirm('product','{{ $product->id }}')"
                                        >
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="h6">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
