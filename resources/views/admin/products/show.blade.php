@extends('admin.layout')
@section('content')
    <div class="col-md-8">
        <div class="card border-0 shadow-lg">
            <div class="card-title">
                <div class="mt-2">
                    <span class="h4 ms-3 me-5">Products</span>
                    <span class="ms-3">
                        <a href="{{ route('product-add') }}"
                            class="link-dark h6"
                        >
                            Add New Product
                        </a>
                    </span>
                </div>
            </div>
            <div class="card-body">
                @if(count($products) > 0)
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
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $key => $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ '$'.$product->price }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->tax.'%' }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <img src="{{ asset('storage/image').'/'.$product->image }}"></td>
                                <td>
                                    <a href="{{ route('product-edit',[ 'id' => $product->id ]) }}"
                                        class="link-dark"
                                    >
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                </td>
                                <td>
                                    @once
                                        @push('scripts')
                                            <script src="{{ asset('js/custom.js') }}"></script>
                                        @endpush
                                        <form method="post"
                                            action="{{ route('product-delete', ['id' => $product->id]) }}"
                                            id="delete-product"
                                        >
                                            @csrf
                                            <button type="button"
                                                class="bg-light border-0"
                                                onclick="deleteConfirm('products')"
                                            >
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @endonce
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <span class="h6">No products found.</span>
                @endif
            </div>
        </div>
    </div>
@endsection
