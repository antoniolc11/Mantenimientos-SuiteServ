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
        Departamento::create(['nombre' => 'Electricidad']);
        Departamento::create(['nombre' => 'Fontanería']);
        Departamento::create(['nombre' => 'Carpintería']);
        Departamento::create(['nombre' => 'Frigorista']);
        Departamento::create(['nombre' => 'Jarinería']);
        Departamento::create(['nombre' => 'Limpieza']);
        Departamento::create(['nombre' => 'Pintura']);
        Departamento::create(['nombre' => 'Albañilería y Reparaciones Estructurales']);
        Departamento::create(['nombre' => 'Eventos']);
    }
}
