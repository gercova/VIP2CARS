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
        <form id="loginForm">
            <h1 class="h3 mb-3 fw-normal">Ingrese sus datos</h1>
            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Contraseña</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Ingresar</button>
            <p class="mt-5 mb-3 text-muted">Demo &copy; {{ date('Y') }}</p>
        </form>
    </main>
    <script>
        $(document).ready(function(){
        //const API_BASE_URL = "{{ url('/') }}"; // Uso de Laravel para generar la URL base
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        $(document).on('submit', '#loginForm', async function (e) {
            e.preventDefault();

            $('.text-danger').remove();
            $('.form-control').removeClass('is-invalid is-valid');
            $('#loginForm').find('text-danger').remove();

            // Deshabilitar el botón de envío
            const submitButton = $('#loginButton'); // Asegúrate de que el botón tenga el id="loginButton"
            submitButton.prop('disabled', true); // Deshabilitar el botón
            submitButton.text('Cargando...'); // Cambiar el texto del botón

            try {
                // Obtener los valores del formulario
                let email       = $('#email').val();
                let password    = $('#password').val();
                // Configurar el cuerpo de la solicitud
                const data = { email, password };
                // Enviar la solicitud con Axios (usando async/await)
                const response = await axios.post(`${API_BASE_URL}/login`, data);
                // Procesar la respuesta
                if (response.status === 200 && response.data.status === true) {
                    $('#message').html(`<div class="alert alert-success alert-dismissible">${response.data.message}</div>`);
                    // Redirigir al usuario y guardar el token
                    localStorage.setItem('token', response.token);
                    window.location.href = response.data.redirect;
                } else if (response.data.status === false) {
                    $('#message').html(`<div class="alert alert-danger alert-dismissible">${response.data.message}</div>`);
                }
            } catch (error) {
                console.error('Error:', error);
                if (error.response && error.response.data.errors) {
                    $.each(error.response.data.errors, function(key, value) {
                        let inputElement = $(document).find(`[name="${key}"]`);
                        inputElement.after(`<span class="text-danger">${value[0]}</span>`).closest('.form-control').addClass('is-invalid');
                    });
                } else {
                    //alertNotify('error', 'Ocurrió un error al procesar la solicitud.');
                    $('#message').html('<div class="alert alert-danger alert-dismissible">Error en la solicitud. Inténtalo de nuevo.</div>');
                }
            } finally {
                // Habilitar el botón de envío nuevamente
                submitButton.prop('disabled', false);
                submitButton.text('Iniciar Sesión'); // Restaurar el texto original del botón
            }
        });
    });
    </script>
</body>
</html>
