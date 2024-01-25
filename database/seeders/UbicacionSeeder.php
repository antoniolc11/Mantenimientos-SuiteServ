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
        Ubicacion::create(['nombre' => 'Consergería']);
        Ubicacion::create(['nombre' => 'Salón de actos "Flor de Lis"']);
        Ubicacion::create(['nombre' => 'Salón de actos "de la Rosa"']);
        Ubicacion::create(['nombre' => 'Restaurante "Gourmet del Este"']);
        Ubicacion::create(['nombre' => 'Bar "El Refugio"']);
        Ubicacion::create(['nombre' => 'Bar piscina']);
        Ubicacion::create(['nombre' => 'Centro de Spa y Bienestar']);
        Ubicacion::create(['nombre' => 'Gimnasio "Vitalidad Total"']);
        Ubicacion::create(['nombre' => 'Centro de Negocios']);
        Ubicacion::create(['nombre' => 'Suite Presidencial']);
        Ubicacion::create(['nombre' => 'Área de Desayuno "Amanecer Delicioso"']);
        Ubicacion::create(['nombre' => 'Jardín Interior']);
        Ubicacion::create(['nombre' => 'Terraza Panorámica']);
        Ubicacion::create(['nombre' => 'Sala de Juegos "Diversión Nocturna"']);
        Ubicacion::create(['nombre' => 'Sala de Conciertos Privada']);
        Ubicacion::create(['nombre' => 'Tienda de Regalos "Recuerdos Únicos"']);
        Ubicacion::create(['nombre' => 'Centro de Entretenimiento Infantil "Pequeños Exploradores"']);
        Ubicacion::create(['nombre' => 'Otros']);
    }
}
