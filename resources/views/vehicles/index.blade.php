@extends('layout.skelenton')
@section('content')
<div class="container">
        <div class="card">
            <h5 class="card-header">Clientes</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <button type="button" class="btn btn-outline btn-primary" id="btn-add-vehicle"><i class="bi bi-plus-circle"></i> Agregar vehículo</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-sm" id="vehicle_data">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Placa</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Año fabricación</th>
                                                <th>Cliente</th>
                                                <th>Fecha</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalVehicle" tabindex="-1" aria-modal="true" role="dialog" data-backdrop="static" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="vehicleForm" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="placa">Placa: </label>
                            <input type="text" class="form-control" id="placa" name="placa">
                        </div>
                        <div class="form-group">
                            <label for="marca">Marca: </label>
                            <input type="text" class="form-control" id="marca" name="marca">
                        </div>
                        <div class="form-group">
                            <label for="modelo">Modelo: </label>
                            <input type="text" class="form-control" id="modelo" name="modelo">
                        </div>
                        <div class="form-group">
                            <label for="anio_fabricacion">Año de fabricación: </label>
                            <input type="number" class="form-control" id="anio_fabricacion" name="anio_fabricacion">
                        </div>
                        <div class="form-group">
                            <label for="detalles">Detalles: </label>
                            <input type="text" class="form-control" id="detalles" name="detalles">
                        </div>
                        <div class="form-group">
                            <label for="clientId">Cliente: </label>
                            <select class="slim-select" id="clientId" name="clientId">
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->dni.' '.$client->nombres }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" name="vehicleId" id="vehicleId" value="">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Grabar datos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/vehicles.js') }}"></script>
@endsection
