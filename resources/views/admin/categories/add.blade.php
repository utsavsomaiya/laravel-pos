@extends('admin.layout')
@section('content')
    <div class="col-md-8">
        <div class="card border-0 shadow-lg">
            <div class="card-title">
                <div class="mt-2">
                    <span class="h4 ms-3 me-5">Add new Category</span>
                </div>
            </div>
            <div class="card-body">
                <form class="forms-sample w-50" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="pb-1">Category Name</label>
                        <input type=" text"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Category Name"
                            name="name"
                            value="@isset($category){{ $category->name }}@else{{ old('name') }}@endisset"
                            required
                        >
                        @error('name')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary me-2 mt-3" name="submit">
                        @isset($category)
                            Update
                        @else
                            Submit
                        @endisset
                    </button>
                    <a href="{{ route('categories_list') }}" class="btn btn-light mt-3">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
