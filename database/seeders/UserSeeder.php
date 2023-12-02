<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Obtener Departamentos existentes
         $depart_direccion = Departamento::where('nombre', 'Dirección')->first();
         $depart_supervision = Departamento::where('nombre', 'Supervisión')->first();
         $depart_RRHH = Departamento::where('nombre', 'Recursos humanos')->first();
         $depart_informatica = Departamento::where('nombre', 'Informática')->first();
         $depart_telecomunicaciones = Departamento::where('nombre', 'Telecomunicaciones')->first();



        $usuario1 = User::create([
            'nombre' => 'Antonio Fernando',
            'primer_apellido' => 'Román',
            'segundo_apellido' => 'Fernández',
            'nif' => '47344703P',
            'telefono' => 675523834,
            'email' => 'antoniolc11@hotmail.com',
            'password' => Hash::make('1234'),
            'status'    => 1,
        ]);

        $usuario1->departamentos()->attach($depart_direccion->id);
        $usuario1->departamentos()->attach($depart_informatica->id);

        $usuario2 = User::create([
            'nombre' => 'Roberto',
            'primer_apellido' => 'Sanchez',
            'segundo_apellido' => 'Triguero',
            'nif' => '47484226E',
            'telefono' => 752186347,
            'email' => 'roberto@suiteserv.com',
            'password' => Hash::make('1234'),
            'status'    => 1,
        ]);

        $usuario2->departamentos()->attach($depart_supervision->id);

        $usuario3 = User::create([
            'nombre' => 'Cristina',
            'primer_apellido' => 'Márquez',
            'segundo_apellido' => 'Rizo',
            'nif' => '32475891L',
            'telefono' => 657914665,
            'email' => 'cristina@suiteserv.com',
            'password' => Hash::make('1234'),
            'status'    => 0,
        ]);

        $usuario3->departamentos()->attach($depart_RRHH->id);

        $usuario4 = User::create([
            'nombre' => 'Mariano',
            'primer_apellido' => 'Cisneros',
            'segundo_apellido' => 'Marín',
            'nif' => '57841127W',
            'telefono' => 752444387,
            'email' => 'mariano@suiteserv.com',
            'password' => Hash::make('1234'),
            'status'    => 1,
        ]);

        $usuario5 = User::create([
            'nombre' => 'Sergio',
            'primer_apellido' => 'Cisneros',
            'segundo_apellido' => 'Marín',
            'nif' => '57841124B',
            'telefono' => 752444334,
            'email' => 'sergio@suiteserv.com',
            'password' => Hash::make('1234'),
            'status'    => 1,
        ]);

        $usuario4->departamentos()->attach($depart_informatica->id);
        $usuario5->departamentos()->attach($depart_informatica->id);

        $usuario6 = User::create([
            'nombre' => 'Manuel',
            'primer_apellido' => 'Rodríguez',
            'segundo_apellido' => 'Verdejo',
            'nif' => '47521114R',
            'telefono' => 675523834,
            'email' => 'manuel@suiteserv.com',
            'password' => Hash::make('1234'),
            'status'    => 1,
        ]);

        $usuario6->departamentos()->attach($depart_telecomunicaciones->id);
    }
}
