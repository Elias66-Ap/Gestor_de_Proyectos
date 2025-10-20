<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\LiderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerfilController;
use App\Http\Middleware\RolMiddleware;


Route::get('/', function () {
    return view('login');
})->name('inicio');

Route::get('/tablero', function () {
    return view('tablero');
})->name('tablero');

Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

//Grupo de rutas para el administrador:
Route::middleware(['auth:usuario', 'rol:Administrador'])->group(function () {
    Route::get('/admin/inicio', [AdminController::class, 'index'])->name('admin.inicio');

    Route::get('/admin/colaboradores', [AdminController::class, 'colaboradores'])->name('admin.colaboradores');
    Route::get('/admin/equipos', [AdminController::class, 'equipos'])->name('admin.equipos');
    Route::get('/admin/proyecto', [AdminController::class, 'proyecto'])->name('admin.proyecto');
    Route::get('/admin/perfil', [AdminController::class, 'perfil'])->name('admin.perfil');
    Route::get('/admin/notificacion', [AdminController::class, 'notificacion'])->name('admin.notificacion');
    Route::post('register', [AdminController::class, 'store'])->name('register');
});

//Grupo de rutas para el Lider:
Route::middleware(['auth:usuario', 'rol:Lider'])->group(function () {
    Route::get('/lider/inicio', [LiderController::class, 'index'])->name('lider.inicio');
    Route::get('/lider/proyecto', [LiderController::class, 'proyectos'])->name('lider.proyectos');
    Route::get('/lider/colaboradores', [LiderController::class, 'colaboradores'])->name('lider.colaboradores');
    Route::get('/lider/perfil', [LiderController::class, 'perfil'])->name('lider.perfil');
    Route::get('/lider/notificacion', [LiderController::class, 'notificacion'])->name('lider.notificacion');
    Route::get('/lider/tareas', [LiderController::class, 'tareas'])->name('lider.tareas');
    Route::get('/lider/equipo', [LiderController::class, 'equipo'])->name('lider.equipo');
});

//Rutas para el colaborador
Route::middleware(['auth:usuario', 'rol:Colaborador'])->group(function () {
    Route::get('/colab/inicio', [ColaboradorController::class, 'inicio'])->name('colab.inicio');
    Route::get('/colab/equipo', [ColaboradorController::class, 'equipo'])->name('colab.equipo');
    Route::get('/colab.notificaciones', [ColaboradorController::class, 'notificacion'])->name('colab.notificaciones');
    Route::get('/colab/perfil', [ColaboradorController::class, 'miPerfil'])->name('colab.perfil');
    Route::get('/colab/tareas', [ColaboradorController::class, 'tareas'])->name('colab.tareas');
});


// Mostrar formulario para crear perfil
Route::get('crear_perfil', [PerfilController::class, 'crear'])
    ->name('crear_perfil')
    ->middleware('auth:usuario'); // Solo usuarios autenticados

// Guardar el perfil
Route::post('guardar', [PerfilController::class, 'guardar'])
    ->name('perfil.guardar')
    ->middleware('auth:usuario');
