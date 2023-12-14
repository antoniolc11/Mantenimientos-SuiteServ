<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncidenciaRequest;
use App\Http\Requests\UpdateIncidenciaRequest;
use App\Models\Incidencia;
use App\Models\Categoria;
use App\Models\Departamento;
use App\Models\Estado;
use App\Models\Historial;
use App\Models\Ubicacion;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StoreIncidenciaRequest $request)
    {
        $user = User::find(auth()->user()->id);
        $estados = Estado::all();
        $categorias = Categoria::all();
        $departamentosall = Departamento::all();

        return view('home', compact(['estados', 'categorias', 'departamentosall']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departamentos = Departamento::all();
        $estados = Estado::all();
        $ubicaciones = Ubicacion::all();
        $categorias = Categoria::all();
        return view('incidencias.create', [
            'departamentos' => $departamentos,
            'estados' => $estados,
            'ubicaciones' => $ubicaciones,
            'categorias' => $categorias
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIncidenciaRequest $request)
    {
        $incidencia = Incidencia::create($request->all());

        // Crear un registro en la tabla de historial
        Historial::create([
            'incidencia_id' => $incidencia->id,
            'user_id'  => $incidencia->usuario_asignado,
            'trabajo_realizado' => null,
            'estado_id' => $incidencia->estado_id,
            'hora_inicio' => Carbon::now(),
            'fecha_actualizacion' => Carbon::now(),
        ]);

        return redirect()->route('incidencias.show', $incidencia)->with('success', 'Incidencia generada con exito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Incidencia $incidencia)
    {
        $historiales = Historial::where('incidencia_id', $incidencia->id)->get();
          // Aplicar saltos de línea cada 80 caracteres a la descripción
        $incidencia->descripcion = wordwrap($incidencia->descripcion, 80, "\n", true);
        
        return view('incidencias.show', ['incidencia' => $incidencia, 'historiales' => $historiales]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incidencia $incidencia)
    {
        if ($incidencia->estado->id != 1) {
            return redirect()->route('incidencias.show', $incidencia)->with('error', 'Incidencia ya iniciada, debes de generar una nueva.');
        }
        $departamentos = Departamento::all();
        $estados = Estado::all();
        $ubicaciones = Ubicacion::all();
        $categorias = Categoria::all();
        return view('incidencias.edit', [
            'departamentos' => $departamentos,
            'estados' => $estados,
            'ubicaciones' => $ubicaciones,
            'categorias' => $categorias,
            'incidencia' => $incidencia,
        ])->with('success', 'Incidencia modificada con exito.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIncidenciaRequest $request, Incidencia $incidencia)
    {
        $incidencia->update($request->all());

        return redirect()->route('incidencias.show', $incidencia)->with('success', 'Incidencia modificada con exito.');
    }


    //Cierra la incidencia sin necesidad de iniciarla en el caso de que se creara por error.
    public function cerrarInc(Incidencia $incidencia)
    {
        $estado = Estado::where('nombre', 'Finalizado')->first();
        $incidencia->estado_id = $estado->id;
        $incidencia->save();

        // Crear un registro en la tabla de historial
        Historial::create([
            'incidencia_id' => $incidencia->id,
            'user_id'  => $incidencia->usuario_asignado,
            'trabajo_realizado' => "La incidencia no requiere intervención",
            'estado_id' => $incidencia->estado_id,
            'fecha_actualizacion' => Carbon::now(),
        ]);


        return redirect()->route('incidencias.show', $incidencia)->with('success', 'La Incidencia fue cerrada directamente.');
    }

    //Reabrir la incidencia.
    public function reabrirInc(Incidencia $incidencia)
    {
        $estadoEnCurso = Estado::where('nombre', 'Reabierta')->first();
        $incidencia->estado_id = $estadoEnCurso->id;
        $incidencia->save();

        // Crear un registro en la tabla de historial

        Historial::create([
            'incidencia_id' => $incidencia->id,
            'user_id'  => $incidencia->usuario_asignado,
            'trabajo_realizado' => "La incidencia ha sido reabierta.",
            'estado_id' => $incidencia->estado_id,
            'fecha_actualizacion' => Carbon::now(),
            'hora_inicio' => Carbon::now(),
        ]);

        return redirect()->route('incidencias.show', $incidencia)->with('success', 'La Incidencia fue reabierta.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incidencia $incidencia)
    {
        //
    }

    /* Cambia de estado cada vez que se actualiza el formulario del show de incidencias */
    public function cambiarEstado(StoreIncidenciaRequest $request, Incidencia $incidencia)
    {
        $nombreEstado = $incidencia->estado->nombre;

        if ($nombreEstado == 'Pendiente') {
            $estado = Estado::where('nombre', 'En curso')->first();
            $incidencia->estado_id = $estado->id;
            $incidencia->save();
            $mensaje = "Estado de la incidencia cambiado a {$estado->nombre}";
        }

        if ($nombreEstado == 'En curso' || $nombreEstado == 'Reabierta') {
            $estado = Estado::where('nombre', 'Finalizado')->first();
            $incidencia->estado_id = $estado->id;
            $incidencia->save();
            $mensaje = "La incidencia ha sido cerrada.";
        }

        // Crea un nuevo registro en la tabla de historial
        Historial::create([
            'incidencia_id' => $incidencia->id,
            'user_id'  => $incidencia->usuario_asignado,
            'trabajo_realizado' => $nombreEstado == 'Pendiente' ? $incidencia->descripcion : $request->descripcion,
            'estado_id' => $incidencia->estado_id,
            'hora_inicio' => $nombreEstado == 'Pendiente' ? Carbon::now() : null,
            'hora_fin' => $nombreEstado == 'En curso' || $nombreEstado == 'Reabierta' ? Carbon::now() : null,
            'fecha_actualizacion' => Carbon::now(),
        ]);

        return redirect()->route('incidencias.show', $incidencia)->with('success', $mensaje);
    }

    /* Reasigna una incidencia a un user  */
    public function reasignarIncidencia($incidenciaId, StoreIncidenciaRequest $request)
    {
        $user = $request->usuario;
        $incidencia = Incidencia::find($incidenciaId);
        $user = User::find($user);


        if ($incidencia && $user) {
            $incidencia->usuario_asignado = $user->id;
            $incidencia->save();
            return redirect()->route('incidencias.show', $incidencia)->with('success', 'Incidencia reasignada correctamente a ' . $user->nombre);
        } else {
            return redirect()->route('incidencias.show', $incidencia)->with('error', 'No se pudo reasignar la incidencia.');
        }
    }

    /*
        Metodo que realiza la logíca del formulario de busqueda de la pagina /home, donde se podrá filtrar los resultados por
        varios campos
    */
    public function buscarIncidencia(Request $request)
    {
        //Recoge los datos del formulario de busqueda.
        $numero = $request->input('search');
        $estado = $request->input('estado');
        $prioridad = $request->input('prioridad');
        $categoria = $request->input('categoria');
        $departamento = $request->input('departamento');


        //$resultados = Incidencia::where('numero', 'like', '%' . $numero . '%');


        $user = User::find(auth()->user()->id); //Realiza una consulta que obtiene el id del usuario logado.
        $departamentos = $user->departamentos; //Realiza la busqueda de los departamentos a los que pertenece el usuario.


        //$esDepartamentoDireccion = $user->departamentos->contains('nombre', 'Dirección');

        if ($user->esDepartamentoDireccion() || $user->esDepartamentoSupervision()) {
            //Consulta base para aplicar a los filtros de busqueda a los usuarios que son de dirección ni supervisión.
            $query = Incidencia::query()->where('numero', 'like', '%' . $numero . '%')->orderBy('categoria_id')->get();
        }

        if (!$user->esDepartamentoDireccion() && !$user->esDepartamentoSupervision()) {
            //Consulta base para aplicar a los filtros de busqueda a los usuarios que no son de dirección ni supervisión.
            $query = Incidencia::query()->whereIn('departamento_id', $departamentos->pluck('id'))
                ->with(['creador', 'asignado'])
                ->where('numero', 'like', '%' . $numero . '%')
                ->orderBy('categoria_id')
                ->get();
        }



        if ($estado !== null && $estado !== '' && $prioridad !== null && $prioridad !== '' && $categoria !== null && $categoria !== '' && $departamento !== null && $departamento !== '') {
            $resultados = $query->where('estado_id', $estado)->where('prioridad', $prioridad)->where('categoria_id', $categoria)->where('departamento_id', $departamento);
        } elseif ($estado !== null && $estado !== '' && $prioridad !== null && $prioridad !== '' && $categoria !== null && $categoria !== '') {
            $resultados = $query->where('estado_id', $estado)->where('prioridad', $prioridad)->where('categoria_id', $categoria);
        } elseif ($prioridad !== null && $prioridad !== '' && $categoria !== null && $categoria !== '' && $departamento !== null && $departamento !== '') {
            $resultados = $query->where('prioridad', $prioridad)->where('categoria_id', $categoria)->where('departamento_id', $departamento);
        } elseif ($estado !== null && $estado !== '' && $categoria !== null && $categoria !== '' && $departamento !== null && $departamento !== '') {
            $resultados = $query->where('estado_id', $estado)->where('categoria_id', $categoria)->where('departamento_id', $departamento);
        } elseif ($prioridad !== null && $prioridad !== '' && $estado !== null && $estado !== '' && $departamento !== null && $departamento !== '') {
            $resultados = $query->where('estado_id', $estado)->where('prioridad', $prioridad)->where('departamento_id', $departamento);
        } elseif ($prioridad !== null && $prioridad !== '' && $departamento !== '' && $departamento !== null) {
            $resultados = $query->where('prioridad', $prioridad)->where('departamento_id', $departamento);
        } elseif ($categoria !== null && $categoria !== '' && $departamento !== null && $departamento !== '') {
            $resultados = $query->where('categoria_id', $categoria)->where('departamento_id', $departamento);
        } elseif ($estado !== null && $estado !== '' && $departamento !== null && $departamento !== '') {
            $resultados = $query->where('estado_id', $estado)->where('departamento_id', $departamento);
        } elseif ($estado !== null && $estado !== '' && $prioridad !== null && $prioridad !== '') {
            $resultados = $query->where('estado_id', $estado)->where('prioridad', $prioridad);
        } elseif ($estado !== null && $estado !== ''  && $categoria !== null && $categoria !== '') {
            $resultados = $query->where('estado_id', $estado)->where('categoria_id', $categoria);
        } elseif ($prioridad !== null && $prioridad !== ''  && $categoria !== null && $categoria !== '') {
            $resultados = $query->where('prioridad', $prioridad)->where('categoria_id', $categoria);
        } elseif ($estado !== null && $estado !== '') {
            $resultados = $query->where('estado_id', $estado);
        } elseif ($prioridad !== null && $prioridad !== '') {
            $resultados = $query->where('prioridad', $prioridad);
        } elseif ($categoria !== null && $categoria !== '') {
            $resultados = $query->where('categoria_id', $categoria);
        } elseif ($departamento !== null && $departamento !== '') {
            $resultados = $query->where('departamento_id', $departamento);
        } else {
            if ($numero == null && $numero == '') {
                $resultados = $query->whereNotIn('estado_id', [3]);
            } else {
                $resultados = $query;
            }
        }

        //Comprueba las incidencias que pertenecen al usuario logado
        $resultados2 = [];
        foreach ($resultados as $incidencia) {
            if ($incidencia->usuario_asignado === $user->id) {
                $resultados2[] = $incidencia;
            }
        }



        $resultados = $user->esDepartamentoDireccion() || $user->esDepartamentoSupervision() ? $resultados : $resultados2;
        $view = view('incidencias._busqueda', ['incidencias' => $resultados]);

        return $view->render();
    }
}
