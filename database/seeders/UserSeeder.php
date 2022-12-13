<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'a1@a1.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // password
            'remember_token' => Str::random(10),
        ])->assignRole('admin');

        User::create([
            'name' => 'luchofernandezapp',
            'email' => 'luchofernandezapp@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // password
            'remember_token' => Str::random(10),
        ])->assignRole('admin');

        User::create([
            'name' => 'usuario_prueba',
            'email' => 'p1@p1.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'), // password
            'remember_token' => Str::random(10),
        ])->assignRole('usuario');

        User::create([
            'name' => 'administrador_tienda',
            'email' => 't1@t1.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // password
            'remember_token' => Str::random(10),
        ])->assignRole('admin_tienda');

        User::create([
            'name' => 'editor_tienda',
            'email' => 't2@t2.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // password
            'remember_token' => Str::random(10),
        ])->assignRole('editor');
    }
}
