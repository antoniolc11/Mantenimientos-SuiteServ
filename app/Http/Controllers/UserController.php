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
        return view('users.edit', ['usuario' => $user]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $user->update($request->all());

        return redirect()->route('users.index');
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
}
