<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index() {
        $clients = Client::all();
        return view('vehicles.index', compact('clients'));
    }

    public function list () {
        $results = Vehicle::join('clientes', 'vehiculos.cliente_id', '=', 'clientes.id')
            ->select('vehiculos.placa', 'vehiculos.marca', 'vehiculos.modelo', 'vehiculos.anio_fabricacion', 'clientes.dni', 'clientes.nombres as cliente', 'vehiculos.created_at', 'vehiculos.id')
            ->get();

        $data = $results->map(function ($item, $index) {
            return [
                $index + 1,
                $item->placa,
                $item->marca,
                $item->modelo,
                $item->anio_fabricacion,
                $item->dni.' '.$item->cliente,
                $item->created_at->format('Y-m-d H:i:s'),
                sprintf(
                    '<button type="button" class="btn btn-sm btn-warning update-row btn-md" value="%s">
                        <i class="bi bi-pencil-square"></i>
                    </button>&nbsp;
                    <button type="button" class="btn btn-sm btn-danger delete-vehicle btn-md" value="%s">
                        <i class="bi bi-trash"></i>
                    </button>',
                    htmlspecialchars($item->id, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($item->id, ENT_QUOTES, 'UTF-8'),
                ),
            ];
        });

      	return response()->json([
 			"sEcho"					    => 1,
 			"iTotalRecords"			    => $data->count(),
 			"iTotalDisplayRecords"	    => $data->count(),
 			"aaData"				    => $data,
 		]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'placa'             => 'required|string|max:10|unique:vehiculos,placa,'.$request->id,
            'marca'             => 'required|string|max:50',
            'modelo'            => 'required|string|max:50',
            'anio_fabricacion'  => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'detalles'          => 'required|string|max:100',
            'cliente_id'        => 'required',
        ]);

        DB::beginTransaction();
        try {
            // Crear o actualizar vehículo
            $result = Vehicle::updateOrCreate(['id' => $request->id], $validated);
            DB::commit();

            return response()->json([
                'status'    => true,
                'type'      => 'success',
                'message'   => $result->wasChanged() ? 'Datos de vehículo actualizados correctamente' : 'Vehículo registrado correctamente',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al registrar el vehículo y cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function searchClient (Request $request) {
        $client = Client::where('dni', 'like', '%'.$request->q.'%')->orWhere('name', 'like', '%'.$request->q.'%')->where('email', 'like', '%'.$request->q.'%')->get()->toArray();
        if (!$client) {
            return response()->json([
                'message' => 'Cliente no encontrado'
            ], 404);
        }
        return response()->json($client);
    }

    public function show(Vehicle $vehicle) {
        return $vehicle;
    }

    public function destroy($id) {
        $vehicle = Vehicle::findOrFail($id);
        DB::beginTransaction();
        
        try {
            $vehicle->delete();
            DB::commit();
            
            return response()->json([
                'message' => 'Vehículo eliminado correctamente'
            ])->noContent();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al eliminar el vehículo',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
