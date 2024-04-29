<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'admin@capytal.test',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'is_admin' => true,
            'is_active' => true,
            'settings' => null,
            'avatar_url' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Usuário Demonstração',
            'email' => 'usuario@capytal.test',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'is_admin' => false,
            'is_active' => true,
            'settings' => null,
            'avatar_url' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
