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
        // Optiene los departamentos a los que el usuario pertenece.
        $departamentos = $user->departamentos;
        // Verifica si el usuario es del departamento de dirección
        $esDepartamentoDireccion = $user->departamentos->contains('nombre', 'Dirección');

        if ($user->esDepartamentoDireccion() || $user->esDepartamentoSupervision()) {
            $incidencias = Incidencia::whereNotIn('estado_id', [3])->orderBy('categoria_id')->get();
        } else {
            $incidencias = Incidencia::whereIn('departamento_id', $departamentos->pluck('id'))
                ->with(['creador', 'asignado'])
                ->whereNotIn('estado_id', [3]) // Excluir las incidencias con estado_id igual a (3 Finalizado)
                ->orderBy('categoria_id')
                ->get();
        }

        return view('home', compact(['estados', 'categorias', 'departamentosall', 'incidencias']));
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
            'trabajo_realizado' => $incidencia->descripcion,
            'estado_id' => $incidencia->estado_id,
            'hora_inicio' => Carbon::now(),
        ]);

        return redirect()->route('incidencias.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Incidencia $incidencia)
    {
        $historiales = Historial::where('incidencia_id', $incidencia->id)->get();
        return view('incidencias.show', ['incidencia' => $incidencia, 'historiales' => $historiales]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incidencia $incidencia)
    {
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
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIncidenciaRequest $request, Incidencia $incidencia)
    {
        $incidencia->update($request->all());

        return redirect()->route('incidencias.show', $incidencia)->with('success', 'Incidencia modificada con exito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incidencia $incidencia)
    {
        //
    }


    public function cambiarEstado(StoreIncidenciaRequest $request, Incidencia $incidencia)
    {
        $nombreEstado = $incidencia->estado->nombre;

        if ($nombreEstado == 'Pendiente') {
            $incidencia->estado_id = Estado::where('nombre', 'En curso')->first()->id;
            $incidencia->save();
        }

        if ($nombreEstado == 'En curso') {
            $incidencia->estado_id = Estado::where('nombre', 'Finalizado')->first()->id;
            $incidencia->save();
        }

        // Crea un nuevo registro en la tabla de historial
        $historial =
            Historial::create([
                'incidencia_id' => $incidencia->id,
                'user_id'  => $incidencia->usuario_asignado,
                'trabajo_realizado' => $nombreEstado == 'Pendiente' ? $incidencia->descripcion : $request->descripcion,
                'estado_id' => $incidencia->estado_id,
                'hora_inicio' => $nombreEstado == 'Pendiente' ? Carbon::now() : null,
                'hora_fin' => $nombreEstado == 'En curso' ? Carbon::now() : null,
            ]);

        return redirect()->route('incidencias.index')->with('success', 'Estado de la incidencia cambiado exitosamente');
    }
}
