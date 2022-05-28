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
                    <table class="table w-75">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Category</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($discounts as $discount)
                                <tr>
                                    <td>{{ $discount->id }}</td>
                                    <td>{{ $discount->name }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input"
                                                type="checkbox"
                                                role="switch"
                                                id="flexSwitchCheckChecked"
                                                onclick="discountStatusChanged('{{ $discount->id }}','{{ $discount->status }}','{{ csrf_token() }}')"
                                                @checked($discount->status == 0)
                                            >
                                        </div>
                                    </td>
                                    <td>
                                        @if($discount->category == 0)
                                            <h6 class="badge bg-secondary mb-0">
                                                Price Discount
                                            </h6>
                                        @else
                                            <h6 class="badge bg-danger mb-0">
                                                Gift Discount
                                            </h6>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('discount-edit',['id' => $discount->id] ) }}"
                                            class="link-dark"
                                        >
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form method="post"
                                            id="delete-discount"
                                            action="{{ route('discount-delete',['id' => $discount->id]) }}"
                                        >
                                            @csrf
                                            <button type="button"
                                                class="bg-light border-0"
                                                onclick="deleteConfirm('discounts')"
                                            >
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
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
