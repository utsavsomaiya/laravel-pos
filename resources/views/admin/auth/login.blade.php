@extends('admin.auth.layout')
@section('content')
    <h4>Hello! let's get started</h4>
    <h6 class="fw-light">Sign in to continue.</h6>
    @if(session('error'))
        <div class="alert alert-danger p-0 m-0">
            <ul class="mb-2">
                <li class="pt-2">{{ @session('error') }}</li>
            </ul>
        </div>
    @endif
    <div class="card-body">
        <form class="pt-3" method="post">
            @csrf
            <div class="form-group mb-3">
                <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" placeholder="Username" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="mt-2 text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Password" name="password" required>
                @error('password')
                    <div class="mt-2 text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mt-3">
                <input type="submit" name="submit" value="Sign in" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
            </div>
        </form>
    </div>
    <h5 class="fw-light">Don't have an account?</h5>
    <div>
        <a href="/admin/register" class="btn">Sign Up</a>
    </div>
    @if(session('success'))
        <script>
            alertify.success("{{ session('success') }}");
        </script>
    @endif
@endsection
