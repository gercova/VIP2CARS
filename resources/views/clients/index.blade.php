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
                                <button type="button" class="btn btn-outline btn-primary" id="btn-add-client"><i class="bi bi-plus-circle"></i> Agregar cliente</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-sm" id="client_data">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>DNI</th>
                                                <th>Nombres</th>
                                                <th>E-mail</th>
                                                <th>Teléfono</th>
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
    <div class="modal fade" id="modalClient" tabindex="-1" aria-modal="true" role="dialog" data-backdrop="static" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="clientForm" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="dni">DNI: </label>
                            <input type="text" class="form-control" id="dni" name="dni">
                        </div>
                        <div class="form-group">
                            <label for="nombres">Nombres: </label>
                            <input type="text" class="form-control" id="nombres" name="nombres">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail: </label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono: </label>
                            <input type="text" class="form-control" id="telefono" name="telefono">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" name="clientId" id="clientId" value="">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Grabar datos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/clients.js') }}"></script>
@endsection
