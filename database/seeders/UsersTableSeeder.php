<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Ejecuta la siembra de la base de datos.
     *
     * @return void
     */
    public function run()
    {
        // Crear el usuario administrador
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin',
            'password' => Hash::make('12345678'),
        ]);

        // Crear 10 usuarios aleatorios
        \App\Models\User::factory(10)->create()->each(function ($user) {
            $user->password = Hash::make('123456789');
            $user->save();
        });
    }
}
