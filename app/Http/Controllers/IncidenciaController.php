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
        $incidencias = Incidencia::whereNotIn('estado_id', [3])->where('usuario_asignado', $user->id);
        $numero = $incidencias->count();

        return view('home', compact(['estados', 'categorias', 'departamentosall', 'numero']));
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
        // Validaciones
        $request->validate([
            'usuario_creador' => 'required|numeric',
            'estado_id' => 'required|numeric',
            'prioridad' => 'required|in:Baja,Media,Alta',
            'departamento_id' => 'required|numeric',
            'usuario_asignado' => 'nullable|numeric',
            'ubicacion_id' => 'required|numeric',
            'categoria_id' => 'required|numeric',
            'descripcion' => 'required|string',
        ]);

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
        // Validaciones
        $request->validate([
            'usuario_creador' => 'required|numeric',
            'estado_id' => 'required|numeric',
            'prioridad' => 'required|in:Baja,Media,Alta',
            'departamento_id' => 'required|numeric',
            'usuario_asignado' => 'nullable|numeric',
            'ubicacion_id' => 'required|numeric',
            'categoria_id' => 'required|numeric',
            'descripcion' => 'required|string',
        ]);

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
        // Obtiene el nombre del estado actual de la incidencia
        $nombreEstado = $incidencia->estado->nombre;

        // Cambia el estado a 'En curso' si estaba 'Pendiente'
        if ($nombreEstado == 'Pendiente') {
            $estado = Estado::where('nombre', 'En curso')->first();
            $incidencia->estado_id = $estado->id;
            $incidencia->save();
            $mensaje = "Estado de la incidencia cambiado a {$estado->nombre}";
        }

        // Cierra la incidencia si estaba en 'En curso' o 'Reabierta'
        if ($nombreEstado == 'En curso' || $nombreEstado == 'Reabierta') {
            $estado = Estado::where('nombre', 'Finalizado')->first();
            $incidencia->estado_id = $estado->id;
            $incidencia->save();
            $mensaje = "La incidencia ha sido cerrada.";
        }

        // Crea un nuevo registro en la tabla de historial
        Historial::create([
            'incidencia_id'       => $incidencia->id,
            'user_id'             => $incidencia->usuario_asignado,
            'trabajo_realizado'  => $nombreEstado == 'Pendiente' ? $incidencia->descripcion : $request->descripcion,
            'estado_id'           => $incidencia->estado_id,
            'hora_inicio'         => $nombreEstado == 'Pendiente' ? Carbon::now() : null,
            'hora_fin'            => $nombreEstado == 'En curso' || $nombreEstado == 'Reabierta' ? Carbon::now() : null,
            'fecha_actualizacion' => Carbon::now(),
        ]);

        // Redirige a la vista de detalles de la incidencia con un mensaje de éxito
        return redirect()->route('incidencias.show', $incidencia)->with('success', $mensaje);
    }


    /* Reasigna una incidencia a un user  */
    public function reasignarIncidencia($incidenciaId, StoreIncidenciaRequest $request)
    {
        // Obtener el ID del usuario proporcionado en la solicitud
        $usuarioId = $request->usuario;

        // Buscar la incidencia correspondiente al ID proporcionado
        $incidencia = Incidencia::find($incidenciaId);

        // Buscar al usuario correspondiente al ID proporcionado
        $usuario = User::find($usuarioId);

        // Verificar si se encontraron tanto la incidencia como el usuario
        if ($incidencia && $usuario) {
            // Asignar el ID del usuario a la incidencia y guardar los cambios
            $incidencia->usuario_asignado = $usuario->id;
            $incidencia->save();

            // Redirigir a la vista de detalles de la incidencia con un mensaje de éxito
            return redirect()->route('incidencias.show', $incidencia)->with('success', 'Incidencia reasignada correctamente a ' . $usuario->nombre);
        } else {
            // Si no se encuentran la incidencia o el usuario, redirigir con un mensaje de error
            return redirect()->route('incidencias.show', $incidencia)->with('error', 'No se pudo reasignar la incidencia.');
        }
    }


    /*
        Metodo que realiza la logíca del formulario de busqueda de la pagina /home, donde se podrá filtrar los resultados por
        varios campos
    */
    public function buscarIncidencia(Request $request)
    {
        // Recoge los datos del formulario de búsqueda.
        $numero = $request->input('search');
        $estado = $request->input('estado');
        $prioridad = $request->input('prioridad');
        $categoria = $request->input('categoria');
        $departamento = $request->input('departamento');

        // Obtiene el usuario autenticado.
        $user = User::find(auth()->user()->id);
        $departamentos = $user->departamentos;

        // Consulta base para incidencias con roles de dirección o supervisión.
        $query = Incidencia::query()
            ->where('numero', 'like', '%' . $numero . '%')
            ->orderByRaw("
                CASE
                    WHEN prioridad = 'Alta' THEN 1
                    WHEN prioridad = 'Media' THEN 2
                    WHEN prioridad = 'Baja' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('prioridad', 'asc');

        // Aplica filtros para usuarios con roles de dirección o supervisión.
        if (!$user->esDepartamentoDireccion() && !$user->esDepartamentoSupervision()) {
            $query->whereIn('departamento_id', $departamentos->pluck('id'))
                ->with(['creador', 'asignado']);
        }

        // Aplica filtros adicionales basados en los parámetros proporcionados.
        if ($estado !== null && $estado !== '') {
            $query->where('estado_id', $estado);
        }
        if ($prioridad !== null && $prioridad !== '') {
            $query->where('prioridad', $prioridad);
        }
        if ($categoria !== null && $categoria !== '') {
            $query->where('categoria_id', $categoria);
        }
        if ($departamento !== null && $departamento !== '') {
            $query->where('departamento_id', $departamento);
        }

        // Aplica filtro para valores no nulos y no vacíos.
        if (!empty($estado) || !empty($prioridad) || !empty($categoria) || !empty($departamento) || !empty($numero)) {
            $resultados = $query->get();;
        } else {
            $resultados = $query->whereNotIn('estado_id', [3])->get();
        }

        // Filtra resultados para incidencias asignadas.
        $resultados2 = $resultados->filter(function ($incidencia) use ($user) {
            return $incidencia->usuario_asignado === $user->id;
        });

        // Determina los resultados finales según el rol del usuario.
        $resultados = $user->esDepartamentoDireccion() || $user->esDepartamentoSupervision() ? $resultados : $resultados2;

        // Crea la vista con los resultados y la renderiza.
        $view = view('incidencias._busqueda', ['incidencias' => $resultados]);
        return $view->render();
    }
}
