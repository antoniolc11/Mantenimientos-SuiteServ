<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departamento::create(['nombre' => 'Dirección']);
        Departamento::create(['nombre' => 'Supervisión']);
        Departamento::create(['nombre' => 'Recursos humanos']);
        Departamento::create(['nombre' => 'Informática']);
        Departamento::create(['nombre' => 'Telecomunicaciones']);
    }
}
