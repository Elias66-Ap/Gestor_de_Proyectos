<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LoginController;


route::get('/', function () {
    return view('login');
})->name('inicio');

route::get('/admin/colaboradores', function () {
    return view('admin.colaboradores');
})->name('admin.colaboradores');

route::get('/admin/proyecto', function () {
    return view('admin.proyecto');
})->name('admin.proyecto');

route::get('/admin/perfil', function () {
    return view('admin.perfil');
})->name('admin.perfil');

route::get('/admin/notificaciones', function () {
    return view('admin.notificaciones');
})->name('admin.notificaciones');

route::get('/admin/equipos', function () {
    return view('admin.equipos');
})->name('admin.equipos');

Route::get('/admin/inicio', [UsuarioController::class, 'index'])->name('admin.inicio');

Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
