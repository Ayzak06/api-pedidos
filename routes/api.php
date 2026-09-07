<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;

Route::apiResource('usuarios', UsuarioController::class);
Route::apiResource('pedidos', PedidoController::class);
Route::apiResource('productos', ProductoController::class);