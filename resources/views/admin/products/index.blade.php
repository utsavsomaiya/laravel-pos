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
                    <span class="ms-3 btn btn-warning" data-bs-toggle="modal" data-bs-target="#products-import-modal">
                        Import Products
                    </span>
                    <div class="modal fade" id="products-import-modal" tabindex="-1" aria-labelledby="products-import-modal-label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="products-import-modal-label">Import Products</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-inline-block">
                                    <div class="row">
                                        <div class="col-6">
                                            <form method="post" enctype="multipart/form-data"
                                                action="{{ route('products-import') }}"
                                            >
                                                @csrf
                                                <input class="form-control form-control-sm mb-4" id="formFileSm" type="file" name="import_file">
                                                @error('import_file')
                                                    <label class="text-danger mb-2">{{ $message }}</label><br>
                                                @enderror
                                                <button class="btn btn-warning text-white">
                                                    <i class="fa-solid fa-file-import me-1"></i>
                                                    Import Products
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-6 mt-5 pt-1">
                                            <a class="text-decoration-none text-white btn btn-warning" href="/storage/file/products.xlsx">
                                                <i class="fa-solid fa-download"></i>
                                                Sample Download
                                            </a>
                                        </div>
                                    </div>
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
                                    <img src="{{ $product->getFirstMediaUrl('product-images', 'preview') }}"></td>
                                <td class="d-flex">
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
    @error('import_file')
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            $(document).ready(function(){
                $("#products-import-modal").modal('show');
            });
        </script>
    @enderror
@endsection
