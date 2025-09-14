<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {

    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function index () {
        return view('login');
    }

    public function login(Request $request) {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status'    => false,
                'message'   => 'Credenciales inválidas.'
            ], 401);
        }

        $request->session()->regenerate();
        // Generar token CSRF para protección en formularios
        $csrfToken = csrf_token();
        return response()->json([
            'status'        => true,
            'message'       => 'Inicio de sesión exitoso.',
            'redirect'      => route('home'),
            'csrf_token'    => $csrfToken
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json([
            'status'    => true,
            'redirect'  => route('login')
        ], 200);
    }

    public function user(Request $request) {
        return response()->json($request->user());
    }
}