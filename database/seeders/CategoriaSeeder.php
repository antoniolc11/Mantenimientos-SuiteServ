<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create(['nombre' => 'Avería']);
        Categoria::create(['nombre' => 'Mantenimiento']);
        Categoria::create(['nombre' => 'Reunión']);
        Categoria::create(['nombre' => 'Busqueda de personal']);

    }
}
