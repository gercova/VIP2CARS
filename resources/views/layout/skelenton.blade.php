
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    
    <meta name="generator" content="Hugo 0.84.0">
    <title>CAR2VIP</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        const API_BASE_URL = "{{ url('/') }}";
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css') }}">
    <link href="https://cdn.datatables.net/v/dt/dt-2.3.4/datatables.min.css" rel="stylesheet" integrity="sha384-pmGS6IIcXhAVIhcnh9X/mxffzZNHbuxboycGuQQoP3pAbb0SwlSUUHn2v22bOenI" crossorigin="anonymous">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slimselect.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/slimselect.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/funciones.js') }}"></script>
    <script src="{{ asset('js/deleteHandler.js') }}"></script>

    <script src="https://cdn.datatables.net/v/dt/dt-2.3.4/datatables.min.js" integrity="sha384-X2pTSfom8FUa+vGQ+DgTCSyBZYkC1RliOduHa0X96D060s7Q//fnOh3LcazRNHyo" crossorigin="anonymous"></script>

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
</head>
<body>
    <main>
        <h1 class="visually-hidden">Headers examples</h1>

        <div class="container">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                    <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
                    <span class="fs-4">VIP2CARS</span>
                </a>

                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" aria-current="page">Inicio</a></li>
                    <li class="nav-item"><a href="{{ route('vehicles') }}" class="nav-link {{ request()->routeIs('vehicles') ? 'active' : '' }}">Vehículos</a></li>
                    <li class="nav-item"><a href="{{ route('clients') }}" class="nav-link {{ request()->routeIs('clients') ? 'active' : '' }}">Clientes</a></li>
                    <li class="nav-item"><a href="{{ route('surveys') }}" class="nav-link {{ request()->routeIs('surveys') ? 'active' : '' }}">Encuestas</a></li>
                    <li class="nav-item"><a href="" class="nav-link exit-system">Salir</a></li>
                </ul>
            </header>
        </div>
        <div class="b-example-divider"></div>
        <div class="container">
            @yield('content')
        </div>
    </main>
</body>
</html>