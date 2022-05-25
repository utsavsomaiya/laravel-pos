@extends('admin.layout')
@section('content')
    <div class="col-md-8">
        <div class="card border-0 shadow-lg">
            <div class="card-title">
                <div class="mt-2">
                    <span class="h4 ms-3 me-5">Categories</span>
                    <span class="ms-3">
                        <a href="/admin/categories/add" class="link-dark h6">Add New Category</a>
                    </span>
                </div>
            </div>
            <div class="card-body">
                @if(count($categories) > 0)
                    <table class="table w-50">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <a href="/admin/categories/edit/{{ $category->id }}" class="link-dark"><i class="fa-solid fa-pencil"></i></a>
                                    </td>
                                    <td>
                                        <a class="link-dark" onclick="deleteConfirm('{{ $category->id }}','categories')"><i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <span class="h6">No categories found.</span>
                @endif
            </div>
        </div>
    </div>
@endsection
