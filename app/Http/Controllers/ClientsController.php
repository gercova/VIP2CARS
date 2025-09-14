<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('clients.index');
    }

    public function list() {
        $results    = Client::all();
        $data       = $results->map(function ($item, $index) {

            return [
                $index + 1,
                $item->dni,
                $item->nombres,
                $item->email,
                $item->telefono,
                $item->created_at->format('Y-m-d H:i:s'),
                sprintf(
                    '<button type="button" class="btn btn-sm btn-warning update-row btn-md" value="%s">
                        <i class="bi bi-pencil-square"></i>
                    </button>&nbsp;
                    <button type="button" class="btn btn-sm btn-danger delete-client btn-md" value="%s">
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
            'dni'       => 'required|string|max:11|unique:clientes,dni,'.$request->id,
            'nombres'   => 'required|string|max:100',
            'email'     => 'required|email|max:100|unique:clientes,email,'.$request->id,
            'telefono'  => 'required|string|max:20|unique:clientes,telefono,'.$request->id,
        ]);

        DB::beginTransaction();
        try {
            $result = Client::updateOrCreate(['id' => $request->id], $validated);
            DB::commit();
            return response()->json([
                'status'    => true,
                'type'      => 'success',
                'message'   => $result->wasChanged() ? 'Cliente actualizado correctamente.' : 'Cliente guardado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'type'      => 'error',
                'message'   => $e->getMessage()
            ], 500);
        }

    }

    public function show(Client $client) {
        return $client;
    }

    public function destroy (Client $client) {
        try {
            $client->delete();
            return response()->json([
                'status'    => true,
                'type'      => 'success',
                'message'   => 'Cliente eliminado correctamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => false,
                'type'      => 'error',
                'message'   => $e->getMessage()
            ], 500);
        }
    }

}
