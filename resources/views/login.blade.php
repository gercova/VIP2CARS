<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Signin</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <meta name="theme-color" content="#7952b3">
    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
        font-size: 3.5rem;
        }
    }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        const API_BASE_URL = "{{ url('/') }}";
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/signin.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
</head>
<body class="text-center">   
    <main class="form-signin">
        <form id="loginForm" method="POST">
            @csrf
            <h1 class="h3 mb-3 fw-normal">Ingrese sus datos</h1>
            <div id="message"></div>
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                <label for="email">Email</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <label for="password">Contraseña</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" id="loginButton" type="submit">Ingresar</button>
            <p class="mt-5 mb-3 text-muted">Demo &copy; {{ date('Y') }}</p>
        </form>
    </main>
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
