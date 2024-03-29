<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

use App\Http\Requests\StoreAspiranteRequest;
use App\Http\Requests\UpdateAspiranteRequest;
use App\Models\Aspirante;
use App\Models\User;
use App\Models\Departamento;
use Illuminate\Support\Facades\Storage;
use App\Mail\SendCurriculum;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;


class AspiranteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aspirantes = Aspirante::Paginate(5);
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
        $nif = Aspirante::where('nif', $request->nif);
        $email = Aspirante::where('email', $request->email);
        $telefono = Aspirante::where('telefono', $request->telefono);
/*         if ($nif->exists() || $email->exists() || $telefono->exists()) {
            return redirect()->route('login')->with('error', 'Ya realizaste la solicitud, tus datos serán valorados pronto. ¡Gracias!');
        }
 */
        // Validación de campos del formulario.
        $request->validate([
            'nombre' => 'required|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'nullable|string|max:255',
            'nif' => [
                'required',
                'string',
                'max:9',
                'min:9',
                'regex:/^[0-9]+[A-Za-z]$/i',
                Rule::unique('aspirantes')->ignore($request->id),
            ],
            'telefono' => 'required|string|max:9',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('aspirantes')->ignore($request->id),
            ],
        ]);

        $aspirante = new Aspirante([
            'nombre' => $request->input('nombre'),
            'primer_apellido' => $request->input('primer_apellido'),
            'segundo_apellido' => $request->input('segundo_apellido'),
            'nif' => $request->input('nif'),
            'telefono' => $request->input('telefono'),
            'email' => $request->input('email'),
            'curriculum' => null,
        ]);

        $aspirante->save();
        // Después de guardar el aspirante en la base de datos enviamos la notificación para completar el registro adjuntando el cv.
        // Verifica si el aspirante existe
        if ($aspirante) {
            // Crea una nueva instancia de SendCurriculum y pasa el aspirante al constructor
            $mail = new SendCurriculum($aspirante);

            // Envía el correo electrónico
            Mail::to($aspirante->email)->send($mail);
        }

        return redirect()->route('login')->with('success', 'Tu solicitud se ha mandado correctamente, revisa su email para completar el registro. ¡Gracias!');
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
        if ($aspirante->curriculum) {
            # code...
            // Elimina el curriculum almacenado en el sistema de archivos
            Storage::delete($aspirante->curriculum);
        }
        $aspirante->delete();
        return redirect()->route('aspirantes.index')->with('success', 'Aspirante descartado exitosamente.');
    }



    public function download($id)
    {
        $documento = Aspirante::findOrFail($id);

        $pdfContent = $documento->pdf;

        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'documento.pdf');
    }

    public function showForm($aspiranteId)
    {
        // Obtén el aspirante según su ID
        $aspirante = Aspirante::find($aspiranteId);

        if (!$aspirante) {
            // Manejar el caso en el que el aspirante no se encuentre
            return redirect()->back()->with('error', 'Aspirante no encontrado.');
        }

        if ($aspirante->curriculum) {
            return redirect()->route('login')->with('success', 'Ya as enviado tu curriculum anteriormente, por favor espera una respuesta por parte de nuestro departamento de RRHH.');
        }

        return view('aspirantes.formularioCurriculum', ['aspirante' => $aspirante]);
    }

    public function upload(StoreAspiranteRequest $request)
    {
        $aspirante = Aspirante::find($request->aspirante_id);
        // Lógica para manejar la subida del currículum
        // Puedes guardar el currículum en el servidor, en una base de datos, etc.

        $request->validate([
            'curriculum' => 'required|mimes:pdf,doc,docx|max:2048', // Asegúrate de que solo se acepten ciertos tipos de archivos
        ]);

        if ($request->hasFile('curriculum')) {
            $curriculumPath = $request->file('curriculum')->store('public/curriculums');
            $aspirante->curriculum = $curriculumPath;
            $aspirante->save();
        }

        // Después de manejar la subida, podrías redirigir al aspirante a una página de agradecimiento
        return redirect()->route('login')->with('success', 'Tu registro en nuestro sistema se ha completado correctamente. ¡Gracias!');
    }

    /**
     * Metodo que mete en la plantilla de operarios a los trabajadores
     */
    public function ascenderAspirante(Aspirante $aspirante)
    {
        if ($aspirante->curriculum == null) {
            return redirect()->route('aspirantes.index')->with('error', 'No puedes ascender a un aspirante sin curriculum.');
        }
        $departamentos = Departamento::all();
        return view('users.create', ['aspirante' => $aspirante, 'departamentos' => $departamentos]);
    }
}
