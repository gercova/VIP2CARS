<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Client;
use App\Models\Survey;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class HomeController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('home.index');
    }

    public function stats () {
        $vehiclesCount  = Vehicle::count();
        $clientsCount   = Client::count();
        $surveysCount   = Survey::where('is_active', true)->count();
        
        // Respuestas de hoy
        $answersToday = Answer::whereDate('created_at', today())->count();
        
        return response()->json([
            'vehicles'      => $vehiclesCount,
            'clients'       => $clientsCount,
            'surveys'       => $surveysCount,
            'answers_today' => $answersToday
        ]);
    }
}
