<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\AspiranteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Pagina principal: será el login, para una vez dado de alta a los operarios, estós puedan iniciar sesión en el sistema.
Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');


//Página de inicio de sesión: donde se mostrarán las incidencias.
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [IncidenciaController::class, 'index'])->name('home');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//Mis rutas:

//Rutas Aspirantes:
Route::get('/aspirantes', [AspiranteController::class, 'index'])->name('aspirantes.index')->middleware(['auth', 'CheckDepartamentoRrhhDire']);
Route::post('/aspirantes', [AspiranteController::class, 'store'])->name('aspirantes.store');
Route::get('/aspirantes/create', [AspiranteController::class, 'create'])->name('aspirantes.create');
Route::delete('/aspirantes/{id}', [AspiranteController::class, 'destroy'])->name('aspirantes.destroy');
Route::get('/descargar-pdf/{id}', [AspiranteController::class, 'download'])->name('descargar.pdf');

//Rutas Departamentos:
Route::resource('departamentos', DepartamentoController::class)->middleware(['auth', 'check.direction']);

//Rutas Estados:
Route::resource('estados', EstadoController::class)->middleware(['auth', 'check.direction']);

//Rutas Incidencias:
//Route::resource('incidencias', IncidenciaController::class)->middleware(['auth', 'CheckDepartamentoSuperDire']);
Route::get('/buscar-incidencia', [IncidenciaController::class, 'buscarIncidencia'])->name('buscar.incidencia');
Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index')->middleware(['auth', 'CheckDepartamentoSuperDire']);
Route::post('/incidencias', [IncidenciaController::class, 'store'])->name('incidencias.store')->middleware(['auth', 'CheckDepartamentoSuperDire']);
Route::get('/incidencias/create', [IncidenciaController::class, 'create'])->name('incidencias.create')->middleware(['auth', 'CheckDepartamentoSuperDire']);
Route::get('/incidencias{incidencia}', [IncidenciaController::class, 'show'])->name('incidencias.show');
Route::put('/incidencias/{incidencia}/cambiar-estado', [IncidenciaController::class, 'cambiarEstado'])->name('incidencias.cambiar-estado');

//Rutas Categorías:
Route::resource('categorias', CategoriaController::class)->middleware(['auth', 'check.direction']);

//Rutas Ubicaciones
Route::resource('ubicaciones', UbicacionController::class)->middleware(['auth', 'check.direction']);

//Rutas Historiales:
Route::resource('historiales', HistorialController::class);

//Rutas Usuarios:
Route::resource('users', UserController::class)->middleware(['auth', 'verified', 'check.direction']);



require __DIR__.'/auth.php';
