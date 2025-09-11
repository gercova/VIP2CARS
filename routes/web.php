<?php

use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rutas de autenticación
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

// Ruta principal redirige al dashboard si está autenticado, sino al login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

// API Routes for Vehicles
Route::prefix('api')->group(function () {
    Route::resource('vehicles', VehicleController::class)->middleware('auth:sanctum');
    
    // Ruta para estadísticas del dashboard
    Route::get('/dashboard/stats', function () {
        $vehiclesCount = \App\Models\Vehicle::count();
        $clientsCount = \App\Models\Client::count();
        $surveysCount = \App\Models\Survey::where('is_active', true)->count();
        
        // Respuestas de hoy
        $answersToday = \App\Models\Answer::whereDate('created_at', today())->count();
        
        return response()->json([
            'vehicles' => $vehiclesCount,
            'clients' => $clientsCount,
            'surveys' => $surveysCount,
            'answers_today' => $answersToday
        ]);
    })->middleware('auth:sanctum');
});