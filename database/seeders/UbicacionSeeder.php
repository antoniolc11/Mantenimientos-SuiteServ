<?php

namespace Database\Seeders;

use App\Models\Ubicacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UbicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ubicacion::create(['nombre' => 'Sala de reuniones']);
        Ubicacion::create(['nombre' => 'Despacho dirección']);
        Ubicacion::create(['nombre' => 'Recepción']);
        Ubicacion::create(['nombre' => 'Bar piscina']);
    }
}
