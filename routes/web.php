<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/bem-vindos', [DashboardController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'painel']);
Route::get('/login', [LoginController::class, 'login_html']);

Route::get('/cadastro_usuario', [UsuarioController::class, 'cadastro_usuario_html']);
Route::post('/admin/aprovar_usuario/{id}', [UsuarioController::class, 'aprovar_usuario'])->middleware(\App\Http\Middleware\EnsureTokenIsAdmin::class);
Route::get('/admin/solicitacoes', [UsuarioController::class, 'listar_solicitacoes'])->middleware(\App\Http\Middleware\EnsureTokenIsAdmin::class);