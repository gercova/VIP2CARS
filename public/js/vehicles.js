$(document).ready(function(){
    let slimSelect;
    const tables = {
        vehiclesTable: $("#vehicle_data").DataTable({ ajax: `${API_BASE_URL}/home/vehicles/list`, processing: true, order: [] })
    };

    //Eliminar un registro
    DeleteHandler.initButtons([
        {
            selector: '.delete-client',
            endpoint: 'home/vehicles',
            table: tables.vehiclesTable 
        } 
    ])
	//boton modal
	$('#btn-add-vehicle').click(function(e){
        e.preventDefault();
        if (slimSelect) slimSelect.destroy();
        slimSelect = new SlimSelect({
            select: '#clientId',
            placeholder: 'Seleccione un cliente',
            allowDeselect: true
        });
		$('.form-control').removeClass('is-valid is-invalid');
		$('#vehicleForm').trigger('reset');
        $('#vehicleForm').find('.text-danger').remove();
        $('#vehicleId').val('');
        $('#modalVehicle').modal('show');
        $('.modal-title').text('Agregar Vehiculo');
    });
	//form client
	$('#vehicleForm').submit(async function(e){
        e.preventDefault();
        $('.text-danger').remove();
        $('.form-control').removeClass('is-invalid is-valid');
        $('#vehicleForm').find('text-danger').remove();
        const submitButton = $(this).find('button[type="submit"]');
        const originalButtonText = submitButton.html(); // Guardar el texto original del botón
        submitButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Cargando...');
        const formData = {
            id                  : $('#vehicleId').val(),
            placa               : $('#placa').val(),
            marca               : $('#marca').val(),
            modelo              : $('#modelo').val(),
            anio_fabricacion    : $('#anio_fabricacion').val(),
            color               : $('#color').val(),
            detalles            : $('#detalles').val(),
            cliente_id          : $('#clientId').val(), 
        };
        try {
            const response = await axios.post(`${API_BASE_URL}/home/vehicles`, formData);
            if(response.status == 200 && response.data.status == true){
                $('#vehicleForm').trigger('reset');
                $('#modalVehicle').modal('hide');
                $('#vehicle_data').DataTable().ajax.reload();
                swal.fire({
                    title: 'Operación realizada',
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
        if (slimSelect) slimSelect.destroy();
        slimSelect = new SlimSelect({
            select: '#clientId',
            placeholder: 'Seleccione un cliente',
            allowDeselect: true
        });
        try {
            const response = await axios.get(`${API_BASE_URL}/home/vehicles/${id}`);
            if (response.status === 200) {
                $('.modal-title').text('Actualizar Vehiculo');
                $(".text-danger").remove();
                $('.form-control').removeClass('is-invalid is-valid');
                $("#placa").val(response.data.placa);
                $("#marca").val(response.data.marca);
                $("#modelo").val(response.data.modelo);
                $("#anio_fabricacion").val(response.data.anio_fabricacion);
                $("#detalles").val(response.data.detalles);
                slimSelect.set(response.data.cliente_id);
                //$('#clientId').val(response.data.cliente_id);  
                $('#vehicleId').val(response.data.id);
                $('#modalVehicle').modal('show');
            }
        } catch (err) {
            console.log(err);
        }
    });
});