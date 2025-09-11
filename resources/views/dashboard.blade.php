<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIP2CARS - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #4e73df;
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 1rem;
        }
        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link.active {
            color: white;
            font-weight: bold;
        }
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .main-content {
            background: #f8f9fc;
            min-height: 100vh;
        }
        .card-dashboard {
            border-left: 4px solid #4e73df;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-4">
                    <h4 class="text-center mb-4">
                        <i class="fas fa-car me-2"></i>VIP2CARS
                    </h4>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-home me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/vehicles">
                                <i class="fas fa-car-side me-2"></i>Vehículos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-clipboard-list me-2"></i>Encuestas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-users me-2"></i>Clientes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cog me-2"></i>Configuración
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content p-0">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">
                        <button class="btn btn-link" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        
                        <div class="d-flex align-items-center">
                            <span class="me-3" id="userWelcome">Bienvenido, <span id="userName"></span></span>
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-1"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Perfil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Configuración</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#" id="logoutBtn"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                
                <!-- Page Content -->
                <div class="container-fluid p-4">
                    <h2 class="mb-4">Dashboard</h2>
                    
                    <div class="row">
                        <!-- Estadísticas -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card card-dashboard h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Vehículos Registrados</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="vehiclesCount">0</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-car fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card card-dashboard h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Clientes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="clientsCount">0</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card card-dashboard h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Encuestas Activas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="surveysCount">0</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card card-dashboard h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Respuestas Hoy</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="answersCount">0</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-8 mb-4">
                            <div class="card shadow h-100">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Vehículos Recientes</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Placa</th>
                                                    <th>Marca</th>
                                                    <th>Modelo</th>
                                                    <th>Año</th>
                                                    <th>Cliente</th>
                                                </tr>
                                            </thead>
                                            <tbody id="recentVehicles">
                                                <!-- Los vehículos se cargarán aquí -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 mb-4">
                            <div class="card shadow h-100">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Acciones Rápidas</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="/vehicles" class="btn btn-primary mb-2">
                                            <i class="fas fa-car me-2"></i>Gestionar Vehículos
                                        </a>
                                        <button class="btn btn-success mb-2">
                                            <i class="fas fa-clipboard-list me-2"></i>Crear Encuesta
                                        </button>
                                        <button class="btn btn-info mb-2">
                                            <i class="fas fa-chart-bar me-2"></i>Ver Reportes
                                        </button>
                                        <button class="btn btn-warning mb-2">
                                            <i class="fas fa-cog me-2"></i>Configuración
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function() {
            const authToken = localStorage.getItem('authToken');
            const user = JSON.parse(localStorage.getItem('user') || '{}');
            
            // Si no hay token, redirigir al login
            if (!authToken) {
                window.location.href = '/login';
                return;
            }
            
            // Mostrar nombre de usuario
            $('#userName').text(user.name || 'Usuario');
            
            // Configurar axios para incluir el token en todas las peticiones
            axios.defaults.headers.common['Authorization'] = `Bearer ${authToken}`;
            axios.defaults.headers.common['Accept'] = 'application/json';
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            
            // Cargar datos del dashboard
            loadDashboardData();
            
            // Manejar cierre de sesión
            $('#logoutBtn').click(function(e) {
                e.preventDefault();
                
                axios.post('/api/auth/logout')
                    .then(() => {
                        localStorage.removeItem('authToken');
                        localStorage.removeItem('user');
                        window.location.href = '/login';
                    })
                    .catch(error => {
                        console.error('Error al cerrar sesión:', error);
                        // Forzar cierre de sesión incluso si hay error
                        localStorage.removeItem('authToken');
                        localStorage.removeItem('user');
                        window.location.href = '/login';
                    });
            });
            
            // Toggle sidebar en móviles
            $('#sidebarToggle').click(function() {
                $('.sidebar').toggle();
            });
            
            // Función para cargar datos del dashboard
            function loadDashboardData() {
                // Cargar estadísticas
                axios.get('/api/dashboard/stats')
                    .then(response => {
                        const stats = response.data;
                        $('#vehiclesCount').text(stats.vehicles || 0);
                        $('#clientsCount').text(stats.clients || 0);
                        $('#surveysCount').text(stats.surveys || 0);
                        $('#answersCount').text(stats.answers_today || 0);
                    })
                    .catch(error => {
                        console.error('Error cargando estadísticas:', error);
                    });
                
                // Cargar vehículos recientes
                axios.get('/api/vehicles?limit=5')
                    .then(response => {
                        const vehicles = response.data;
                        const tableBody = $('#recentVehicles');
                        tableBody.empty();
                        
                        if (vehicles.length === 0) {
                            tableBody.append('<tr><td colspan="5" class="text-center">No hay vehículos registrados</td></tr>');
                            return;
                        }
                        
                        vehicles.forEach(vehicle => {
                            const client = vehicle.clients && vehicle.clients.length > 0 ? vehicle.clients[0] : {};
                            const row = `
                                <tr>
                                    <td>${vehicle.plate}</td>
                                    <td>${vehicle.brand}</td>
                                    <td>${vehicle.model}</td>
                                    <td>${vehicle.manufacture_year}</td>
                                    <td>${client.name || ''} ${client.last_name || ''}</td>
                                </tr>
                            `;
                            tableBody.append(row);
                        });
                    })
                    .catch(error => {
                        console.error('Error cargando vehículos recientes:', error);
                    });
            }
            
            // Manejar errores de autenticación
            axios.interceptors.response.use(
                response => response,
                error => {
                    if (error.response && error.response.status === 401) {
                        // Token inválido o expirado
                        localStorage.removeItem('authToken');
                        localStorage.removeItem('user');
                        window.location.href = '/login';
                    }
                    return Promise.reject(error);
                }
            );
        });
    </script>
</body>
</html>