$(document).ready(function(){
    //const API_BASE_URL = "{{ url('/') }}"; // Uso de Laravel para generar la URL base
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $(document).on('submit', '#loginForm', async function (e) {
        e.preventDefault();

        $('.text-danger').remove();
        $('.form-control').removeClass('is-invalid is-valid');
        $('#loginForm').find('text-danger').remove();

        // Deshabilitar el botón de envío
        const submitButton = $('#loginButton'); 
        submitButton.prop('disabled', true);
        submitButton.text('Cargando...');

        try {
            
            let email       = $('#email').val();
            let password    = $('#password').val();
            const data      = { email, password };
            
            const response = await axios.post(`${API_BASE_URL}/login`, data);
            if (response.status === 200 && response.data.status === true) {
                console.log(response);
                console.log(response.data);
                
                $('#message').html(`<div class="alert alert-success alert-dismissible">${response.data.message}</div>`);    
                // Guardar token en localStorage
                localStorage.setItem('authToken', response.data.access_token);
                    
                // Redirigir al dashboard
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
                $('#message').html('<div class="alert alert-danger alert-dismissible">Error en la solicitud. Inténtalo de nuevo.</div>');
            }
        } finally {
            // Habilitar el botón de envío nuevamente
            submitButton.prop('disabled', false);
            submitButton.text('Iniciar Sesión'); // Restaurar el texto original del botón
        }
    });
});