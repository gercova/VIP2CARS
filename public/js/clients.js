$(document).ready(function(){
    const tables = {
        clientsTable: $("#client_data").DataTable({ ajax: `${API_BASE_URL}/home/clients/list`, processing: true, order: [] })
    };

    //Eliminar un registro
    DeleteHandler.initButtons([
        {
            selector: '.delete-client',
            endpoint: 'home/clients',
            table: tables.clientsTable 
        } 
    ])
	//boton modal
	$('#btn-add-client').click(function(e){
        e.preventDefault();
		$('.form-control').removeClass('is-valid is-invalid');
		$('#clientForm').trigger('reset');
        $('#clientForm').find('.text-danger').remove();
        $('#clientId').val('');
        $('#modalClient').modal('show');
        $('.modal-title').text('Agregar Cliente');
    });
	//form client
	$('#clientForm').submit(async function(e){
        e.preventDefault();
        $('.text-danger').remove();
        $('.form-control').removeClass('is-invalid is-valid');
        $('#clientForm').find('text-danger').remove();
        const submitButton = $(this).find('button[type="submit"]');
        const originalButtonText = submitButton.html(); // Guardar el texto original del botón
        submitButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Cargando...');
        const formData = {
            dni         : $('#dni').val(),
            nombres     : $('#nombres').val(),
            email       : $('#email').val(),
            telefono    : $('#telefono').val(),
            id          : $('#clientId').val(),
        };
        try {
            const response = await axios.post(`${API_BASE_URL}/home/clients`, formData);
            if(response.status == 200 && response.data.status == true){
                $('#clientForm').trigger('reset');
                $('#modalClient').modal('hide');
                $('#client_data').DataTable().ajax.reload();
                swal.fire({
                    title: 'Success',
                    text: response.data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            }else if(response.data.status == false){
                swal.fire({
                    title: 'Error',
                    text: response.data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        } catch (error) {
            if (error.response && error.response.data.errors) {
                $.each(error.response.data.errors, function(key, value) {
                    let inputElement = $(document).find(`[name="${key}"]`);
                    inputElement.after(`<span class="text-danger">${value[0]}</span>`).closest('.form-control').addClass('is-invalid');
                });
            } else {
                swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error al procesar la solicitud.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        } finally {
            submitButton.prop('disabled', false).html(originalButtonText);
        }
    });
	//function get category by id
    $(document).on('click', '.update-row', async function(e) {
        e.preventDefault();
        const id = $(this).attr('value');
        try {
            const response = await axios.get(`${API_BASE_URL}/home/clients/${id}`);
            if (response.status === 200) {
                $('.modal-title').text('Actualizar Categoría');
                $(".text-danger").remove();
                $('.form-control').removeClass('is-invalid is-valid');
                $("#dni").val(response.data.dni);
                $("#nombres").val(response.data.nombres);
                $("#email").val(response.data.email);
                $("#telefono").val(response.data.telefono);
                $('#clientId').val(response.data.id);      
                $('#modalClient').modal('show');
            }
        } catch (error) {
            console.log(err);
        }
    });
});