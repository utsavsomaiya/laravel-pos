<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="{{ asset('icon/retail-store-icon-18.png') }}" type="image/x-icon">
        <title>Retail Shop(Admin)</title>
        <link rel="stylesheet" href="{{ asset('css/alertify.min.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor"
            crossorigin="anonymous"
        >
        <link rel="stylesheet" href="{{ asset('css/admin/custom.css') }}">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-2 bg-dark height text-light">
                    <h5 class="text-decoration-underline text-center pt-5 pb-3">
                        <span class="fw-semibold">
                            Retail
                            <b>
                                Store
                            </b>
                        </span>
                    </h5>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item m-2">
                            <a class="nav-link text-light" href="{{ route('dashboard') }}">
                                <i class="fa-solid fa-chart-line pe-2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <span class="nav-category mt-2 mb-2 ms-2">Products</span>
                        <hr class="mt-0 mb-2">
                        <li class="nav-item m-2">
                            <a class="nav-link text-light" href="{{ route('products-list') }}">
                                <i class="fa-solid fa-list pe-2"></i>
                                <span>Products</span>
                            </a>
                        </li>
                        <li class="nav-item m-2">
                            <a class="nav-link text-light" href="{{ route('categories-list') }}">
                                <i class="fa-solid fa-list-ol pe-2"></i>
                                <span>Categories</span>
                            </a>
                        </li>
                        <span class="nav-category mt-2 mb-2 ms-2">Discounts</span>
                        <hr class="mt-0 mb-2">
                        <li class="nav-item m-2">
                            <a class="nav-link text-light" href="{{ route('discounts-list') }}">
                                <i class="fa-solid fa-percent pe-2"></i>
                                <span>Discounts</span>
                            </a>
                        </li>
                        <span class="nav-category mt-2 mb-2 ms-2">Sales Details</span>
                        <hr class="mt-0 mb-2">
                        <li class="nav-item m-2">
                            <a class="nav-link text-light" href="#">
                                <i class="fa-solid fa-cart-plus pe-2"></i>
                                <span>Sales</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-10">
                    <div class="row p-4">
                        <div class="col-10">
                            <h2 class="pt-2">
                                <span class="text-secondary">Good Morning,</span>
                                {{ auth()->user()->username }}
                            </h2>
                        </div>
                        <div class="col-2 mt-2">
                            <span type="button"
                                id="dropdownMenuButton1"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <img src="{{ asset('image/admin/face5.jpg') }}" class="rounded-circle ms-5">
                            </span>
                            <ul class="dropdown-menu dropdown-menu-end"
                                aria-labelledby="dropdownMenuButton1"
                            >
                                <span class="text-center ms-2 fw-bold">
                                    {{ auth()->user()->username }}
                                </span>
                                <hr class="mt-1 mb-1">
                                <li>
                                    <a class="dropdown-item" href="/admin/logout">
                                        <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>
                                        Sign out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"
    ></script>
    <script src="{{ asset('js/alertify.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/discount.js') }}"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src="https://kit.fontawesome.com/40d870b470.js" crossorigin="anonymous"></script>
    @if(session('success'))
        <script>
            alertify.success("{{ session('success') }}");
        </script>
    @endif
    @if(session('error'))
        <script>
            alertify.error("{{ session('error') }}");
        </script>
    @endif
</body>
</html>
