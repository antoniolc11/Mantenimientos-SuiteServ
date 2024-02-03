<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Aspirante;
use App\Models\Departamento;
use App\Models\Incidencia;
use App\Models\User;
use App\Notifications\UserRegistered;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();
        $departamentos = Departamento::all();

        return view('users.index', ['usuarios' => $usuarios, 'departamentos' => $departamentos]);
    }


    /**
     * Display the registration view.
     */
    public function create()
    {
        $departamentos = Departamento::all();
        return view('users.create', ['departamentos' => $departamentos]);
    }


    public function store(Request $request): RedirectResponse
    {
        // Validar los datos enviados en la solicitud
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
                Rule::unique('users')->ignore($request->id),
            ],
            'telefono' => 'required|string|max:9',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($request->id),
            ],
            'departamento' => 'required|array',
            'departamento.*' => 'numeric',
        ]);

        $nif = User::where('nif', $request->nif);
        $email = User::where('email', $request->email);
        if ($nif->exists()) {
            return redirect()->route('users.index')->with('error', 'El dni que intentas registrar ya existe en el sistema.');
        }

        if ($email->exists()) {
            return redirect()->route('users.index')->with('error', 'El email que intentas registrar ya existe en el sistema.');
        }

        $user = User::create([
            'nombre' => $request->nombre,
            'primer_apellido' => $request->primer_apellido,
            'segundo_apellido' => $request->segundo_apellido,
            'nif' => $request->nif,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => Hash::make('asdf1369'),
        ]);

        //TODO: enviar email de confirmación de registro

        // Generar y guardar el token de restablecimiento de contraseña
        $token = Password::getRepository()->create($user);

        // Enviar la notificación de restablecimiento de contraseña
        $user->notify(new UserRegistered($token));

        event(new Registered($user));

        //coge el id del ultimo usuario registrado y realizar attach para meterlo en la tabla departamento_usuario

        $usuario = User::latest()->first(); //ordena el resultado descendentemente y coge el primero de la lista.

        $usuario->departamentos()->attach($request->departamento); //Inserta el ultimo usuario registrado y su departamento en la tabla departamento_usuario



        if ($aspirante = Aspirante::where('nif', $usuario->nif)->first()) {
            $aspirante->delete();
            return redirect()->route('aspirantes.index')->with('success', 'El aspirante ha sido ascendido y notificado correctamente.');
        }


        return redirect()->route('users.index')->with('success', 'El usuario ha sido creado y notificado correctamente.');
    }


    /*
     *  Muestra la ficha del usuario.
     */
    public function show(User $user)
    {
        return view('users.show', ['usuario' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $departamentos = Departamento::all();
        return view('users.edit', ['usuario' => $user, 'departamentos' => $departamentos]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Validar los datos enviados en la solicitud
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
                Rule::unique('users')->ignore($user->id),
            ],
            'telefono' => 'required|string|max:9',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'departamento' => 'required|array',
            'departamento.*' => 'numeric',
        ]);


        // Obtener la URL de la página anterior y el ID del usuario
        $urlPaginaAnterior = strtolower(rtrim(url()->previous(), '/'));
        //$userId = $request->input('user_id');



        // Obtener los nuevos datos del usuario desde la solicitud
        $nuevosDatos = $request->only(['nombre', 'primer_apellido', 'segundo_apellido', 'telefono', 'email', 'nif']);

        // Obtener los nuevos departamentos asociados al usuario desde la solicitud
        $nuevosDepartamentos = $request->input('departamento');

        // Obtener el usuario que se va a actualizar
        $usuario = $user;

        // Comprobar si se va a quitar al usuario de un departamento en el que tiene alguna incidencia asignada

        // Obtener los departamentos actuales del usuario
        $userdepart = $user->departamentos;

        // Obtener los departamentos que se van a modificar según la solicitud
        $departmodify = $request->departamento;

        // Iterar sobre los departamentos actuales del usuario
        foreach ($userdepart as $departamento) {

            // Verificar si el departamento actual no está en la lista de departamentos a modificar
            if (!in_array($departamento->id, $departmodify)) {

                // Contar las incidencias asignadas al usuario en el departamento actual que no estén cerradas (estado_id <> 3)
                $conteoIncidencias = Incidencia::where('usuario_asignado', $user->id)
                    ->where('departamento_id', $departamento->id)
                    ->where('estado_id', '<>', 3)
                    ->count();

                // Si hay incidencias pendientes en el departamento actual, mostrar un mensaje de error y redirigir a la página de edición de usuarios
                if ($conteoIncidencias > 0) {
                    return redirect()
                        ->route('users.edit', $user->id)
                        ->with('error', 'El usuario aún tiene incidencias pendientes en el departamento ' . $departamento->nombre . '. Debes reasignar las incidencias antes de quitar el departamento al usuario.');
                }
            }
        }

        // Si no hay incidencias pendientes, el código continúa su ejecución sin redirección.


        if ($usuario) {

            // Actualizar el nombre del usuario con los nuevos datos
            $usuario->update($nuevosDatos);

            // Actualizar los departamentos asociados al usuario utilizando la relación "sync"
            $usuario->departamentos()->sync($nuevosDepartamentos);

            // Redireccionar a una página específica dependiendo de la página anterior
            if (str_contains($urlPaginaAnterior, 'profile')) {
                // Redireccionar a la página de edición de perfil con un mensaje de éxito
                return redirect()->route('profile.edit')->with('success', 'Tus datos han sido actualizados correctamente.');
            } else {
                // Redireccionar a la página de índice de usuarios con un mensaje de éxito
                return redirect()->route('users.index')->with('success', 'El usuario ha sido actualizado correctamente.');
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->departamentos()->detach();
        $user->delete();
        return redirect()->route('users.index');
    }

    //Función para cambiar la foto de perfíl del usuario
    public function editarImagen(Request $request, User $user)
    {
        // Obtiene la imagen
        $imagenPath = $request->file('imagen')->store('public/imagenesperfil');
        $user->fotoperfil = $imagenPath;
        $user->save();

        // Redirecciona al usuario a la página de perfil
        return view('users.show', ['usuario' => $user]);
    }

    //Función para borrar la foto de perfíl del usuario.
    public function borrarImagen(Request $request, User $user)
    {
        // Verifica si el usuario tiene una imagen de perfil antes de intentar borrarla
        if ($user->fotoperfil) {
            // Elimina la imagen almacenada en el sistema de archivos
            Storage::delete($user->fotoperfil);

            // Actualiza el campo de fotoperfil en la base de datos
            $user->fotoperfil = null;
            $user->save();
        }

        // Redirecciona al usuario a la página de perfil
        return view('users.show', ['usuario' => $user]);
    }

    //Función para realizar la busqueda del usuario.

    public function buscadorUsuario(Request $request)
    {
        // Obtenemos los datos de búsqueda.
        $nombre = $request->input('nombre');
        $primer_apellido = $request->input('primer_apellido');
        $email = $request->input('email');
        $departamento = $request->input('departamento');

        // Creamos la consulta SQL.
        $query = User::query();

        if ($nombre !== null) {
            $query->where('nombre', 'ILIKE', '%' . strtolower($nombre) . '%');
        }

        if ($primer_apellido !== null) {
            $query->where('primer_apellido', 'ILIKE', '%' . strtolower($primer_apellido) . '%');
        }

        if ($email !== null) {
            $query->where('email', 'ILIKE', '%' . strtolower($email) . '%');
        }

        if ($departamento !== null) {
            $query->whereHas('departamentos', function ($query) use ($departamento) {
                $query->where('departamento_id', $departamento);
            });
        }

        // Obtén los resultados de la búsqueda.
        $usuarios = $query->orderBy('nombre')->get();

        // Devuelve los resultados en formato JSON.
        return Response::json(['usuarios' => $usuarios]);
    }


    /* Consulta los usuarios que pertenecen a un determinado departamento pasado por parametro, para cargar el desplegable
        al seleccionar el departamento, cuando se va a crear una incidencia. */
    public function usuariosPorDepartamento($departamentoId)
    {
        $departamento = Departamento::find($departamentoId);

        if ($departamento) {
            $usuarios = $departamento->users;
            // Aquí tienes la colección de usuarios que pertenecen al departamento
        } else {
            // El departamento no fue encontrado
        }
        return response()->json($usuarios); // Asegúrate de devolver los datos en formato JSON
    }

    //Función para bloquear el acceso a usuarios.
    public function addBanned(User $user)
    {

        $user->status = 0; // Asignar el nuevo valor directamente al atributo
        $user->save(); // Guardar el modelo en la base de datos

        return response()->json(['message' => 'El usuario ha sido bloqueado exitosamente', 'user' => $user]);
    }

    //Función para bloquear el acceso a usuarios.
    public function outBanned(User $user)
    {
        $user->status = 1; // Asignar el nuevo valor directamente al atributo
        $user->save(); // Guardar el modelo en la base de datos


        return response()->json(['message' => 'El usuario ha sido desbloqueado exitosamente.', 'user' => $user]);
        //return redirect()->route('users.index')->with('success', 'El usuario ha sido desbloqueado exitosamente.');
    }

    public function viewIncidencias(User $user)
    {
        $incidencias = $user->incidencias()->paginate(7); // Cambia 10 por el número de elementos por página que desees mostrar

        return view('users.viewIncidencias', ['incidencias' => $incidencias]);
    }
}
