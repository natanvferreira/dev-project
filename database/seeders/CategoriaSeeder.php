<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['titulo' => 'Tecnologia'],
            ['titulo' => 'Esportes'],
            ['titulo' => 'Moda'],
            ['titulo' => 'Viagens'],
        ];

        // Insere as categorias na tabela de categorias
        DB::table('categorias')->insert($categorias);
    }
}
