<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder {
    
    public function run(): void {
        User::create([
            'name' => 'Administrador VIP2CARS',
            'email' => 'admin@vip2cars.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Admin123.'), // Contraseña segura
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
