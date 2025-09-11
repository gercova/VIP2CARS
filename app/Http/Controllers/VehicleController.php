<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    public function index() {
        $vehicles = Vehicle::with('clients')->get();
        return response()->json($vehicles);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'plate' => 'required|unique:vehicles|string|max:10',
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'manufacture_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'client_name' => 'required|string|max:100',
            'client_last_name' => 'required|string|max:100',
            'client_document_number' => 'required|string|max:20',
            'client_email' => 'required|email|max:100',
            'client_phone' => 'required|string|max:20'
        ]);

        try {
            DB::beginTransaction();

            // Crear o actualizar cliente
            $client = Client::updateOrCreate(
                ['document_number' => $validated['client_document_number']],
                [
                    'name' => $validated['client_name'],
                    'last_name' => $validated['client_last_name'],
                    'email' => $validated['client_email'],
                    'phone' => $validated['client_phone']
                ]
            );

            // Crear vehículo
            $vehicle = Vehicle::create([
                'plate' => $validated['plate'],
                'brand' => $validated['brand'],
                'model' => $validated['model'],
                'manufacture_year' => $validated['manufacture_year']
            ]);

            // Asociar cliente con vehículo
            $vehicle->clients()->attach($client->id);

            DB::commit();

            return response()->json([
                'message' => 'Vehículo y cliente registrados correctamente',
                'data' => $vehicle->load('clients')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al registrar el vehículo y cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $vehicle = Vehicle::with('clients')->findOrFail($id);
        return response()->json($vehicle);
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::with('clients')->findOrFail($id);
        
        $validated = $request->validate([
            'plate' => 'required|string|max:10|unique:vehicles,plate,' . $id,
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'manufacture_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'client_name' => 'required|string|max:100',
            'client_last_name' => 'required|string|max:100',
            'client_document_number' => 'required|string|max:20',
            'client_email' => 'required|email|max:100',
            'client_phone' => 'required|string|max:20'
        ]);

        try {
            DB::beginTransaction();

            // Actualizar vehículo
            $vehicle->update([
                'plate' => $validated['plate'],
                'brand' => $validated['brand'],
                'model' => $validated['model'],
                'manufacture_year' => $validated['manufacture_year']
            ]);

            // Crear o actualizar cliente
            $client = Client::updateOrCreate(
                ['document_number' => $validated['client_document_number']],
                [
                    'name' => $validated['client_name'],
                    'last_name' => $validated['client_last_name'],
                    'email' => $validated['client_email'],
                    'phone' => $validated['client_phone']
                ]
            );

            // Sincronizar relación (eliminar anteriores y agregar nueva)
            $vehicle->clients()->sync([$client->id]);

            DB::commit();

            return response()->json([
                'message' => 'Vehículo y cliente actualizados correctamente',
                'data' => $vehicle->load('clients')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al actualizar el vehículo y cliente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        
        try {
            DB::beginTransaction();
            
            // Eliminar relaciones primero
            $vehicle->clients()->detach();
            
            // Eliminar vehículo
            $vehicle->delete();
            
            DB::commit();
            
            return response()->json([
                'message' => 'Vehículo eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al eliminar el vehículo',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
