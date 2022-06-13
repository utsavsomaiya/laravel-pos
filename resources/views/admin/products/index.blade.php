@extends('admin.layout')
@section('content')
    <div class="col-md-8">
        <div class="card border-0 shadow-lg">
            <div class="card-title">
                <div class="mt-2">
                    <span class="h4 ms-3 me-5">Products</span>
                    <span class="ms-3">
                        <a href="{{ route('products.add') }}"
                            class="btn btn-dark"
                        >
                            Add New Product
                        </a>
                    </span>
                    <span class="ms-3 btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Import Products
                    </span>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Import Products</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <span class="btn btn-warning">
                                        <i class="fa-solid fa-file-import me-1"></i>
                                        Import Products
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="ms-3 btn btn-dark">
                        <a class="text-decoration-none text-white" href="{{ route('products-export') }}">
                            Export Products
                        </a>
                    </span>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
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
                                        class="link-dark text-decoration-none me-4"
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
