@extends('admin.layout')
@section('content')
    <div class="col-md-8">
        <div class="card border-0 shadow-lg">
            <div class="card-title">
                <div class="mt-2">
                    <span class="h4 ms-3 me-5">Discounts</span>
                    <span class="ms-3">
                        <a href="{{ route('discounts.add') }}" class="link-dark h6">Add New Discount</a>
                    </span>
                </div>
            </div>
            <div class="card-body">
                <table class="table w-75">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($discounts as $discount)
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
                                    <a href="{{ route('discounts.edit', ['discount' => $discount->id ]) }}"
                                        class="link-dark text-decoration-none me-4"
                                    >
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <form method="post"
                                        action="{{ route('discounts.delete', ['discount' => $discount->id]) }}"
                                        id="delete-discount-{{ $discount->id }}"
                                        class="d-inline-block"
                                    >
                                        @csrf
                                        <button type="button"
                                            class="bg-light border-0"
                                            onclick="deleteConfirm('discount','{{ $discount->id }}')"
                                        >
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="h6">No discounts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
