<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstadoRequest;
use App\Http\Requests\UpdateEstadoRequest;
use App\Models\Estado;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = Estado::all();
        return view('estados.index', ['estados' => $estados]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstadoRequest $request)
    {
        $estado = Estado::create($request->all());
        return redirect()->route('estados.index')->with('success', 'El estado se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Estado $estado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estado $estado)
    {
        return view('estados.edit', ['estado' => $estado]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstadoRequest $request, Estado $estado)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $estado->update($request->all());

        return redirect()->route('estados.index')->with('success', 'El estado se ha modificado correctamente.');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estado $estado)
    {
        $estado->delete();
        return redirect()->route('estados.index');
    }
}
