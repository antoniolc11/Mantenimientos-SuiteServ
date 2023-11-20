<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Departamento;
use App\Models\User;
use App\Notifications\UserRegistered;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();
        return view('users.index', ['usuarios' => $usuarios]);
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
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'primer_apellido' => ['required', 'string', 'max:255'],
            'segundo_apellido' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'primer_apellido' => $request->primer_apellido,
            'segundo_apellido' => $request->segundo_apellido,
            'nif' => $request->nif,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            //TODO poner la url de la imagen
        ]);

        //TODO: enviar email de confirmación de registro

        event(new Registered($user));

        //coge el id del ultimo usuario registrado y realizar attach para meterlo en la tabla departamento_usuario

        $usuario = User::latest()->first(); //ordena el resultado descendentemente y coge el primero de la lista.

        $usuario->departamentos()->attach($request->departamento); //Inserta el ultimo usuario registrado y su departamento en la tabla departamento_usuario

        return redirect()->route('users.index');
    }

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
        //return redirect()->route('users.index');

        $userId = $request->input('user_id');
        $nuevosDatos = $request->only(['nombre', 'primer_apellido', 'segundo_apellido', 'telefono', 'email', 'nif']); // Obtener datos para actualizar nombre
        $nuevosDepartamentos = $request->input('departamento'); // Obtener departamentos nuevos



        $usuario = $user;
        if ($usuario) {
            // Actualizar el nombre del usuario
            $usuario->update($nuevosDatos);

            // Actualizar los departamentos asociados al usuario


            $usuario->departamentos()->sync($nuevosDepartamentos);

            return "Usuario actualizado con éxito con los nuevos datos.";
        }

        return "Usuario no encontrado.";
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

    public function editarImagen(Request $request, User $user)
    {
        // Obtiene la imagen
        $imagenPath = $request->file('imagen')->store('public/imagenesperfil');
        $user->fotoperfil = $imagenPath;
        $user->save();

        // Redirecciona al usuario a la página de perfil
        return view('users.show', ['usuario' => $user]);
    }

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


    public function buscadorUsuario(Request $request)
    {
        // Obtenemos los datos de búsqueda.
        $nombre = $request->input('nombre');
        $primer_apellido = $request->input('primer_apellido');
        $email = $request->input('email');

        // Creamos la consulta SQL.

        // Creamos la consulta SQL.

        $query = User::query();

        if ($nombre !== '') {
            $query->where('nombre', 'ILIKE', '%' . strtolower($nombre) . '%');
        }

        if ($primer_apellido !== '') {
            $query->where('primer_apellido', 'ILIKE', '%' . strtolower($primer_apellido) . '%');
        }

        if ($email !== '') {
            $query->where('email', 'ILIKE', '%' . strtolower($email) . '%');
        }

        // Devolvemos los resultados de la búsqueda.
        $view = view('users._busquedaUsuarios', ['usuarios' => $query->get()]);
        return $view->render();
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
}
