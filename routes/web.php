<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\RolMiddleware;


Route::get('/', function () {
    return view('login');
})->name('inicio');

//Grupo de rutas para el administrador:
Route::middleware(['auth:usuario', 'rol:Administrador'])->group(function () {
    Route::get('/admin/inicio', [AdminController::class, 'index'])->name('admin.inicio');

    Route::get('/admin/colaboradores', [AdminController::class, 'colaboradores'])->name('admin.colaboradores');
    Route::post('register', [AdminController::class, 'store'])->name('register');
});

//Grupo de rutas para el Lider:
Route::middleware(['auth:usuario', 'rol:Lider'])->group(function () {
    Route::get('/lider/inicio', [AdminController::class, 'index'])->name('lider.inicio');
});


Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
