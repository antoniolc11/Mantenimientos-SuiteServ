<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartamentoRequest;
use App\Http\Requests\UpdateDepartamentoRequest;
use App\Models\Departamento;
use App\Models\User;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departamentos = Departamento::all();
        return view('departamentos.index', ['departamentos' => $departamentos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departamentos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartamentoRequest $request)
    {
        $departamento = Departamento::create($request->all());
        return redirect()->route('departamentos.index')->with('success', 'El departamento se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Departamento $departamento)
    {
        return view('departamentos.show', ['departamento' => $departamento]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departamento $departamento)
    {
        return view('departamentos.edit', ['departamento' => $departamento]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartamentoRequest $request, Departamento $departamento)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $departamento->update($request->all());

        return redirect()->route('departamentos.index')->with('success', 'Departamento modificado correctamente.');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departamento $departamento)
    {
        $usuariosEnDepartamento = $departamento->users()->count();

        if ($usuariosEnDepartamento > 0) {
            return redirect()->route('departamentos.index')->with('error', 'No se puede eliminar el departamento, hay usuarios asignados a él.');
        }

        $departamento->delete();
        return redirect()->route('departamentos.index')->with('success', 'Se ha borrado correctamente el departamento.');
    }
}
