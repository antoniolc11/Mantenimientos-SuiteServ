<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

use App\Http\Requests\StoreAspiranteRequest;
use App\Http\Requests\UpdateAspiranteRequest;
use App\Models\Aspirante;
use Illuminate\Support\Facades\Storage;

class AspiranteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aspirantes = Aspirante::all();
        return view('aspirantes.index', ['aspirantes' => $aspirantes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('aspirantes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAspiranteRequest $request)
    {
        // Validación de campos del formulario.
        $request->validate([
            'nombre' => 'required|string|max:255',
            'curriculum' => 'required|mimes:pdf,doc,docx|max:2048', // Asegúrate de que solo se acepten ciertos tipos de archivos
        ]);

        if ($request->hasFile('curriculum')) {
            $curriculumPath = $request->file('curriculum')->store('public/curriculums');
            $aspirante = new Aspirante([
                'nombre' => $request->input('nombre'),
                'primer_apellido' => $request->input('primer_apellido'),
                'segundo_apellido' => $request->input('segundo_apellido'),
                'nif' => $request->input('nif'),
                'telefono' => $request->input('telefono'),
                'email' => $request->input('email'),
                'curriculum' => $curriculumPath,
            ]);
        }

        $aspirante->save();
        return redirect()->route('login')->with('success', 'Tu solicitud se ha mandado correctamente. ¡Gracias!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aspirante $aspirante)
    {
        return view('aspirantes.show', ['aspirante' => $aspirante]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aspirante $aspirante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAspiranteRequest $request, Aspirante $aspirante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aspirante $aspirante)
    {

/*     if($contents = Storage::get(public_path($aspirante->pdf))){
       Storage::delete(public_path($aspirante->pdf));
       Storage::delete('file.jpg');
    } */
    //TODO: borrar archivo pdf del storage
        $aspirante->delete();
        return redirect()->route('aspirantes.index')->with('success', 'Aspirante eliminado exitosamente.');
    }

/*     public function download($id)
    {
        $aspirante = Aspirante::findOrFail($id);

        return response($aspirante->pdf, 200, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="'.$aspirante->nombre.'"'
        ]);
    } */

    public function download($id)
    {
        $documento = Aspirante::findOrFail($id);

        $pdfContent = $documento->pdf;

        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'documento.pdf');
    }
}

