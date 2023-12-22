<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUbicacionRequest;
use App\Http\Requests\UpdateUbicacionRequest;
use App\Models\Ubicacion;

class UbicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ubicaciones = Ubicacion::Paginate(10);
        return view('ubicaciones.index', ['ubicaciones' => $ubicaciones]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ubicaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUbicacionRequest $request)
    {
        $ubicacion = Ubicacion::create($request->all());
        return redirect()->route('ubicaciones.index')->with('success', 'La ubicación se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ubicacion $ubicacione)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ubicacion $ubicacione)
    {
        return view('ubicaciones.edit', ['ubicacion' => $ubicacione]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUbicacionRequest $request, ubicacion $ubicacione)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $ubicacione->update($request->all());

        return redirect()->route('ubicaciones.index')->with('success', 'La ubicación se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ubicacion $ubicacione)
    {
        $ubicacione->delete();
        return redirect()->route('ubicaciones.index');
    }
}
