<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('icon/retail-store-icon-18.png') }}" type="image/x-icon">
    <title>Retail Shop(Admin)</title>
    <link rel="stylesheet" href="{{ asset('css/alertify.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="{{ asset('js/alertify.js') }}"></script>
  </head>
  <body class="bg-light">
    <div class="pt-5">
        <div class="col-lg-4 mx-auto p-4 w-25 card shadow-lg" >
            <div class="mb-4 card-title">
                <a href="#">
                    <span class="fw-bold">Retail Store</span>
                </a>
            </div>
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  </body>
</html>
