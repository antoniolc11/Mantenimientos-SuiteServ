<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckDirectionDepartment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Obtener el usuario autenticado
            $user = Auth::user()->departamentos;

            // Verificar si el usuario pertenece al departamento de dirección
            foreach ($user as $departamento) {
                if ($departamento['nombre'] == 'Dirección') {
                    return $next($request);
                }
            }
        }

        // Si el usuario no está autenticado o no pertenece al departamento de dirección, redireccionar a otra página (puedes ajustar la URL según tu necesidad)
        return redirect('/home');
    }
}
