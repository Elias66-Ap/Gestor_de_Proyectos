<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;


Route::get('/', function () {
    return view('login');
})->name('inicio');

Route::get('/admin/colaboradores', function () {
    return view('admin.colaboradores');
})->name('admin.colaboradores');  

Route::get('/admin/inicio', [AdminController::class, 'index'])->name('admin.inicio');

Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');