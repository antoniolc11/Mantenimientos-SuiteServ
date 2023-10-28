<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
/*     public function create(): View
    {
        return view('auth.register');
    } */

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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

        event(new Registered($user));

        //coge el id del ultimo usuario registrado y realizar attach para meterlo en la tabla departamento_usuario

        $usuario = User::latest()->first(); //ordena el resultado descendentemente y coge el primero de la lista.

        $usuario->departamentos()->attach($request->departamento); //Inserta el ultimo usuario registrado y su departamento en la tabla departamento_usuario

        //Auth::login($user); loga al usuario directamente despues del registro

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $usuario)
    {
        return view('users.show', ['usuario' => $usuario]);
    }
}

