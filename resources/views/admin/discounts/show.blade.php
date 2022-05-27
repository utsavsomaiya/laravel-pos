@extends('admin.layout')
@section('content')
    <div class="col-md-8">
        <div class="card border-0 shadow-lg">
            <div class="card-title">
                <div class="mt-2">
                    <span class="h4 ms-3 me-5">Discounts</span>
                    <span class="ms-3">
                        <a href="{{ route('discount-add') }}" class="link-dark h6">Add New Discount</a>
                    </span>
                </div>
            </div>
            <div class="card-body">
                @if(count($discounts) > 0)
                    <table class="table w-50">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Category</th>
                                <th>Minimum Spend Amount</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($discounts as $discount)
                                <tr>
                                    <td>{{ $discount->id }}</td>
                                    <td>{{ $discount->name }}</td>
                                    <td>{{ $discount->status }}</td>
                                    <td>{{ $discount->category }}</td>
                                    <td>{{ $discount->minimum_spend_amount }}</td>
                                    <td>
                                        <a href="{{ route('category-edit', ['id' => $category->id ]) }}"
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
                                                action="{{ route('category-delete', ['id' => $category->id]) }}"
                                                id="delete-category"
                                            >
                                                @csrf
                                                <button type="button"
                                                    class="bg-light border-0"
                                                    onclick="deleteConfirm('categories')"
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
                    <span class="h6">No discounts found.</span>
                @endif
            </div>
        </div>
    </div>
@endsection
