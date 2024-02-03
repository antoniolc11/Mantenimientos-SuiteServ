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
        $depart_electricidad = Departamento::where('nombre', 'Electricidad')->first();
        $depart_fontaneria = Departamento::where('nombre', 'Fontanería')->first();



        //Usuarios del departamento de dirección.

        $usuario = User::create([
            'nombre' => 'Isabel',
            'primer_apellido' => 'Gómez',
            'segundo_apellido' => 'Molina',
            'nif' => '51237894L',
            'telefono' => 665432189,
            'email' => 'isabel.gomez@suiteserv.com',
            'password' => Hash::make('1234'),
            'status' => 1,
        ]);
        $usuario->departamentos()->attach($depart_direccion->id);

        //Usuarios del departamento de informática.

        $usuario = User::create([
            'nombre' => 'Antonio Fernando',
            'primer_apellido' => 'Román',
            'segundo_apellido' => 'Fernández',
            'nif' => '47344703P',
            'telefono' => 675523834,
            'email' => 'antoniolc11@hotmail.com',
            'password' => Hash::make('1234'),
            'status'    => 1,
        ]);

        $usuario->departamentos()->attach($depart_direccion->id);
        $usuario->departamentos()->attach($depart_informatica->id);

        $usuario = User::create([
            'nombre' => 'Mariano',
            'primer_apellido' => 'Cisneros',
            'segundo_apellido' => 'Marín',
            'nif' => '57841127W',
            'telefono' => 752444387,
            'email' => 'mariano@suiteserv.com',
            'password' => Hash::make('1234'),
            'status'    => 1,
        ]);

        $usuario->departamentos()->attach($depart_informatica->id);

        $usuario = User::create([
            'nombre' => 'Sergio',
            'primer_apellido' => 'Cisneros',
            'segundo_apellido' => 'Marín',
            'nif' => '57841124B',
            'telefono' => 752444334,
            'email' => 'sergio@suiteserv.com',
            'password' => Hash::make('1234'),
            'status'    => 1,
        ]);

        $usuario->departamentos()->attach($depart_informatica->id);

        //Usuarios del departamento de supervisión.

        $usuario = User::create([
            'nombre' => 'Roberto',
            'primer_apellido' => 'Sanchez',
            'segundo_apellido' => 'Triguero',
            'nif' => '47484226E',
            'telefono' => 752186347,
            'email' => 'roberto@suiteserv.com',
            'password' => Hash::make('1234'),
            'status'    => 1,
        ]);

        $usuario->departamentos()->attach($depart_supervision->id);

        $usuario = User::create([
            'nombre' => 'Carlos',
            'primer_apellido' => 'Martínez',
            'segundo_apellido' => 'Gómez',
            'nif' => '72893456W',
            'telefono' => 678456789,
            'email' => 'carlos.martinez@suiteserv.com',
            'password' => Hash::make('1234'),
            'status' => 1,
        ]);
        $usuario->departamentos()->attach($depart_supervision->id);

        $usuario = User::create([
            'nombre' => 'Laura',
            'primer_apellido' => 'Hernández',
            'segundo_apellido' => 'Sánchez',
            'nif' => '87451236L',
            'telefono' => 667123987,
            'email' => 'laura.hernandez@suiteserv.com',
            'password' => Hash::make('1234'),
            'status' => 1,
        ]);
        $usuario->departamentos()->attach($depart_supervision->id);


        //Usuarios del departamento de recursos humanos.

        $usuario = User::create([
            'nombre' => 'Cristina',
            'primer_apellido' => 'Márquez',
            'segundo_apellido' => 'Rizo',
            'nif' => '32475891L',
            'telefono' => 657914665,
            'email' => 'cristina@suiteserv.com',
            'password' => Hash::make('1234'),
            'status'    => 0,
        ]);

        $usuario->departamentos()->attach($depart_RRHH->id);

        $usuario = User::create([
            'nombre' => 'María',
            'primer_apellido' => 'González',
            'segundo_apellido' => 'López',
            'nif' => '58234621Q',
            'telefono' => 654789321,
            'email' => 'maria.gonzalez@suiteserv.com',
            'password' => Hash::make('1234'),
            'status' => 1,
        ]);

        $usuario->departamentos()->attach($depart_RRHH->id);

        $usuario = User::create([
            'nombre' => 'Javier',
            'primer_apellido' => 'Fernández',
            'segundo_apellido' => 'García',
            'nif' => '82193745N',
            'telefono' => 633987654,
            'email' => 'javier.fernandez@suiteserv.com',
            'password' => Hash::make('1234'),
            'status' => 1,
        ]);
        $usuario->departamentos()->attach($depart_RRHH->id);

        //Usuarios del departamento de telecomunicaciones.

        $usuario = User::create([
            'nombre' => 'Manuel',
            'primer_apellido' => 'Rodríguez',
            'segundo_apellido' => 'Verdejo',
            'nif' => '47521114R',
            'telefono' => 675523834,
            'email' => 'manuel@suiteserv.com',
            'password' => Hash::make('1234'),
            'status'    => 1,
        ]);

        $usuario->departamentos()->attach($depart_telecomunicaciones->id);

        $usuario = User::create([
            'nombre' => 'Sandra',
            'primer_apellido' => 'Rodríguez',
            'segundo_apellido' => 'López',
            'nif' => '69254871M',
            'telefono' => 612345678,
            'email' => 'sandra.rodriguez@suiteserv.com',
            'password' => Hash::make('1234'),
            'status' => 1,
        ]);
        $usuario->departamentos()->attach($depart_telecomunicaciones->id);

        $usuario = User::create([
            'nombre' => 'Alejandro',
            'primer_apellido' => 'Herrera',
            'segundo_apellido' => 'Soto',
            'nif' => '94567231K',
            'telefono' => 645789321,
            'email' => 'alejandro.herrera@suiteserv.com',
            'password' => Hash::make('1234'),
            'status' => 1,
        ]);
        $usuario->departamentos()->attach($depart_telecomunicaciones->id);

        //Usuarios del departamento de electricidad.

        // Usuario 2
        $usuario2 = User::create([
            'nombre' => 'María',
            'primer_apellido' => 'González',
            'segundo_apellido' => 'López',
            'nif' => '51896432S',
            'telefono' => 612345678,
            'email' => 'maria@suiteserv.com',
            'password' => Hash::make('1234'),
            'status' => 1,
        ]);

        $usuario2->departamentos()->attach($depart_electricidad->id);

        // Usuario 3
        $usuario3 = User::create([
            'nombre' => 'Carlos',
            'primer_apellido' => 'Pérez',
            'segundo_apellido' => 'Martínez',
            'nif' => '78965412T',
            'telefono' => 665432189,
            'email' => 'carlos@suiteserv.com',
            'password' => Hash::make('1234'),
            'status' => 1,
        ]);

        $usuario3->departamentos()->attach($depart_electricidad->id);

        // Usuario 4
        $usuario4 = User::create([
            'nombre' => 'Laura',
            'primer_apellido' => 'Fernández',
            'segundo_apellido' => 'Sánchez',
            'nif' => '36987451U',
            'telefono' => 699887766,
            'email' => 'laura@suiteserv.com',
            'password' => Hash::make('1234'),
            'status' => 1,
        ]);

        $usuario4->departamentos()->attach($depart_electricidad->id);

        //Usuarios del departamento de fontanería.

        // Usuario 5
        $usuario5 = User::create([
            'nombre' => 'Ana',
            'primer_apellido' => 'Martínez',
            'segundo_apellido' => 'López',
            'nif' => '25896314X',
            'telefono' => 611223344,
            'email' => 'ana@suiteserv.com',
            'password' => Hash::make('1234'),
            'status' => 1,
        ]);

        $usuario5->departamentos()->attach($depart_fontaneria->id);

        // Usuario 6
        $usuario6 = User::create([
            'nombre' => 'Javier',
            'primer_apellido' => 'Gómez',
            'segundo_apellido' => 'Fernández',
            'nif' => '14785236Y',
            'telefono' => 677889900,
            'email' => 'javier@suiteserv.com',
            'password' => Hash::make('1234'),
            'status' => 1,
        ]);

        $usuario6->departamentos()->attach($depart_fontaneria->id);

        // Usuario 7
        $usuario7 = User::create([
            'nombre' => 'Elena',
            'primer_apellido' => 'Pérez',
            'segundo_apellido' => 'González',
            'nif' => '36987415Z',
            'telefono' => 688877766,
            'email' => 'elena@suiteserv.com',
            'password' => Hash::make('1234'),
            'status' => 1,
        ]);

        $usuario7->departamentos()->attach($depart_fontaneria->id);
    }
}
