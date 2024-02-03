<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::Paginate(10);
        return view('categorias.index', ['categorias' => $categorias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        // Validar si la categoría ya existe
        $existingCategoria = Categoria::where('nombre', $request->input('nombre'))->first();

        if ($existingCategoria) {
            // La categoría ya existe, redireccionar con un mensaje de error
            return redirect()->route('categorias.index')->with('error', 'La categoría ya existe.');
        }

        // La categoría no existe, crearla
        $categorias = Categoria::create($request->all());

        // Redireccionar con un mensaje de éxito
        return redirect()->route('categorias.index')->with('success', 'La categoría se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        return view('categorias.show', ['categoria' => $categoria]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', ['categoria' => $categoria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        // Validar si la categoría ya existe
        $existingCategoria = Categoria::where('nombre', $request->input('nombre'))->first();

        if ($existingCategoria) {
            // La categoría ya existe, redireccionar con un mensaje de error
            return redirect()->route('categorias.index')->with('error', 'La categoría ya existe.');
        }

        $categoria->update($request->all());

        return redirect()->route('categorias.index')->with('success', 'La categoría se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias.index');
    }
}
