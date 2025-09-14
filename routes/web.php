<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ClientsController;
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
Route::get('/login',                            [AuthController::class, 'index'])->name('login');
Route::post('/login',                           [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout',                          [AuthController::class, 'logout'])->name('logout')->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::get('/home',                             [HomeController::class, 'index'])->name('home');
    Route::get('/home/stats',                       [HomeController::class, 'stats']);
    Route::get('/home/vehicles',                    [VehicleController::class, 'index'])->name('vehicles');
    Route::get('/home/vehicles/list',               [VehicleController::class, 'list']);
    Route::post('/home/vehicles',                   [VehicleController::class, 'store']);
    Route::get('/home/vehicles/{vehicle}',          [VehicleController::class, 'show']);
    Route::delete('/home/vehicles/{vehicle}',       [VehicleController::class, 'destroy']);

    Route::get('/home/clients',                     [ClientsController::class, 'index'])->name('clients');
    Route::get('/home/clients/list',                [ClientsController::class, 'list']);
    Route::post('/home/clients',                    [ClientsController::class, 'store']);
    Route::get('/home/clients/{client}',            [ClientsController::class, 'show']);
    Route::get('/home/clients/edit/{client}',       [ClientsController::class, 'edit']);
    Route::delete('/home/clients/destroy/{client}', [ClientsController::class, 'destroy']);

    Route::get('/home/surveys',                     [SurveyController::class, 'index'])->name('surveys');
    Route::get('/home/surveys/create',              [SurveyController::class, 'create']);
    Route::post('/home/surveys',                    [SurveyController::class, 'store']);
    Route::get('/home/surveys/{survey}',            [SurveyController::class, 'show']);
    Route::get('/home/surveys/{survey}/edit',       [SurveyController::class, 'edit']);
    Route::delete('/home/surveys/{survey}',         [SurveyController::class, 'destroy']);
});