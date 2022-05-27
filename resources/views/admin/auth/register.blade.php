@extends('admin.auth.layout')
@section('content')
    <h4>Hello! let's get started</h4>
    <h6 class="fw-light">Sign up to continue.</h6>
    <div class="card-body">
        <form method="post">
            @csrf
            <div class="form-group mb-3">
                <input type="text"
                    class="form-control form-control-lg @error('username') is-invalid @enderror"
                    placeholder="Username"
                    name="username"
                    value="{{ old('username') }}"
                    required
                >
                @error('username')
                    <div class="mt-2 text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <input type="email"
                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                    placeholder="Email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                    <div class="mt-2 text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <input type="password"
                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                    placeholder="Password"
                    name="password"
                    required
                >
                @error('password')
                    <div class="mt-2 text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="password"
                    class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                    placeholder="Confirm Password"
                    name="password_confirmation"
                    required
                >
                @error('password_confirmation')
                    <div class="mt-2 text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mt-3">
                <input type="submit"
                    name="submit"
                    value="Sign up"
                    class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                >
            </div>
        </form>
    </div>
    <h5 class="fw-light">Have an account?</h5>
    <div>
        <a href="{{ route('login') }}" class="btn">Sign In</a>
    </div>
@endsection
