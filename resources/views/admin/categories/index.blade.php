@extends('admin.layout')
@section('content')
    <div class="col-md-8">
        <div class="card border-0 shadow-lg">
            <div class="card-title">
                <div class="mt-2">
                    <span class="h4 ms-3 me-5">Categories</span>
                    <span class="ms-3">
                        <a href="{{ route('category_add') }}" class="link-dark h6">Add New Category</a>
                    </span>
                </div>
            </div>
            <div class="card-body">
                <table class="table w-50">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <a href="{{ route('category_edit', ['id' => $category->id ]) }}"
                                        class="link-dark"
                                    >
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                </td>
                                <td>
                                    <form method="post"
                                        action="{{ route('category_delete', ['id' => $category->id]) }}"
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="h6">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
