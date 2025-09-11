<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIP2CARS - Gestión de Vehículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4">VIP2CARS - Gestión de Vehículos</h1>
                
                <!-- Formulario para agregar/editar vehículo -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 id="formTitle">Registrar Nuevo Vehículo</h5>
                    </div>
                    <div class="card-body">
                        <form id="vehicleForm">
                            @csrf
                            <input type="hidden" id="vehicleId" name="id">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Datos del Vehículo</h6>
                                    <div class="mb-3">
                                        <label for="plate" class="form-label">Placa *</label>
                                        <input type="text" class="form-control" id="plate" name="plate" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="brand" class="form-label">Marca *</label>
                                        <input type="text" class="form-control" id="brand" name="brand" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="model" class="form-label">Modelo *</label>
                                        <input type="text" class="form-control" id="model" name="model" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="manufacture_year" class="form-label">Año de Fabricación *</label>
                                        <input type="number" class="form-control" id="manufacture_year" name="manufacture_year" min="1900" max="{{ date('Y') + 1 }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6>Datos del Cliente</h6>
                                    <div class="mb-3">
                                        <label for="client_name" class="form-label">Nombre *</label>
                                        <input type="text" class="form-control" id="client_name" name="client_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="client_last_name" class="form-label">Apellidos *</label>
                                        <input type="text" class="form-control" id="client_last_name" name="client_last_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="client_document_number" class="form-label">Nro. de Documento *</label>
                                        <input type="text" class="form-control" id="client_document_number" name="client_document_number" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="client_email" class="form-label">Correo *</label>
                                        <input type="email" class="form-control" id="client_email" name="client_email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="client_phone" class="form-label">Teléfono *</label>
                                        <input type="text" class="form-control" id="client_phone" name="client_phone" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-secondary me-md-2" id="btnCancel" style="display: none;">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Tabla de vehículos -->
                <div class="card">
                    <div class="card-header">
                        <h5>Vehículos Registrados</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Placa</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Año</th>
                                        <th>Cliente</th>
                                        <th>Documento</th>
                                        <th>Contacto</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="vehiclesTable">
                                    <!-- Los datos se cargarán aquí mediante JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para confirmar eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea eliminar este vehículo?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // URL base de la API
        const API_URL = '/api/vehicles';
        let currentVehicleId = null;

        // Cargar vehículos al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            loadVehicles();
            
            // Manejar envío del formulario
            document.getElementById('vehicleForm').addEventListener('submit', function(e) {
                e.preventDefault();
                saveVehicle();
            });
            
            // Manejar cancelar edición
            document.getElementById('btnCancel').addEventListener('click', function() {
                resetForm();
            });
            
            // Manejar eliminación confirmada
            document.getElementById('confirmDelete').addEventListener('click', function() {
                if (currentVehicleId) {
                    deleteVehicle(currentVehicleId);
                }
            });
        });

        // Cargar todos los vehículos
        function loadVehicles() {
            axios.get(API_URL)
                .then(response => {
                    const vehicles = response.data;
                    const tableBody = document.getElementById('vehiclesTable');
                    tableBody.innerHTML = '';
                    
                    vehicles.forEach(vehicle => {
                        const client = vehicle.clients.length > 0 ? vehicle.clients[0] : {};
                        const row = `
                            <tr>
                                <td>${vehicle.plate}</td>
                                <td>${vehicle.brand}</td>
                                <td>${vehicle.model}</td>
                                <td>${vehicle.manufacture_year}</td>
                                <td>${client.name || ''} ${client.last_name || ''}</td>
                                <td>${client.document_number || ''}</td>
                                <td>
                                    ${client.email ? `${client.email}<br>` : ''}
                                    ${client.phone || ''}
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning me-1" onclick="editVehicle(${vehicle.id})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete(${vehicle.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        tableBody.innerHTML += row;
                    });
                })
                .catch(error => {
                    console.error('Error loading vehicles:', error);
                    alert('Error al cargar los vehículos');
                });
        }

        // Guardar o actualizar vehículo
        function saveVehicle() {
            const formData = new FormData(document.getElementById('vehicleForm'));
            const data = {
                plate: formData.get('plate'),
                brand: formData.get('brand'),
                model: formData.get('model'),
                manufacture_year: formData.get('manufacture_year'),
                client_name: formData.get('client_name'),
                client_last_name: formData.get('client_last_name'),
                client_document_number: formData.get('client_document_number'),
                client_email: formData.get('client_email'),
                client_phone: formData.get('client_phone')
            };
            
            const vehicleId = formData.get('id');
            let request;
            
            if (vehicleId) {
                request = axios.put(`${API_URL}/${vehicleId}`, data);
            } else {
                request = axios.post(API_URL, data);
            }
            
            request.then(response => {
                alert(response.data.message);
                resetForm();
                loadVehicles();
            })
            .catch(error => {
                console.error('Error saving vehicle:', error);
                alert('Error al guardar el vehículo: ' + (error.response?.data?.message || error.message));
            });
        }

        // Editar vehículo
        function editVehicle(id) {
            axios.get(`${API_URL}/${id}`)
                .then(response => {
                    const vehicle = response.data;
                    const client = vehicle.clients.length > 0 ? vehicle.clients[0] : {};
                    
                    document.getElementById('vehicleId').value = vehicle.id;
                    document.getElementById('plate').value = vehicle.plate;
                    document.getElementById('brand').value = vehicle.brand;
                    document.getElementById('model').value = vehicle.model;
                    document.getElementById('manufacture_year').value = vehicle.manufacture_year;
                    
                    document.getElementById('client_name').value = client.name || '';
                    document.getElementById('client_last_name').value = client.last_name || '';
                    document.getElementById('client_document_number').value = client.document_number || '';
                    document.getElementById('client_email').value = client.email || '';
                    document.getElementById('client_phone').value = client.phone || '';
                    
                    document.getElementById('formTitle').textContent = 'Editar Vehículo';
                    document.getElementById('btnCancel').style.display = 'block';
                    
                    // Scroll al formulario
                    document.getElementById('vehicleForm').scrollIntoView({ behavior: 'smooth' });
                })
                .catch(error => {
                    console.error('Error loading vehicle:', error);
                    alert('Error al cargar el vehículo para editar');
                });
        }

        // Confirmar eliminación
        function confirmDelete(id) {
            currentVehicleId = id;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Eliminar vehículo
        function deleteVehicle(id) {
            axios.delete(`${API_URL}/${id}`)
                .then(response => {
                    alert(response.data.message);
                    loadVehicles();
                    // Cerrar modal
                    const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                    deleteModal.hide();
                })
                .catch(error => {
                    console.error('Error deleting vehicle:', error);
                    alert('Error al eliminar el vehículo');
                });
        }

        // Resetear formulario
        function resetForm() {
            document.getElementById('vehicleForm').reset();
            document.getElementById('vehicleId').value = '';
            document.getElementById('formTitle').textContent = 'Registrar Nuevo Vehículo';
            document.getElementById('btnCancel').style.display = 'none';
        }
    </script>
</body>
</html>
