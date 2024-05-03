<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuario = [
            "name" => "Admin",
            "email" => "admin@admin.com",
            "password" => bcrypt(123123),
            "permission" => "admin"
        ];

        DB::table('users')->insert($usuario);
    }
}
