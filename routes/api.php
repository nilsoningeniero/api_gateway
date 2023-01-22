<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\VehiculoController;

Route::post('register', [LoginController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::get('vehiculos/alquiler', [VehiculoController::class, 'alquiler']);

Route::group( ['middleware' => ["auth:sanctum"]], function(){
    //rutas usuarios
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);

    //rutas marcas
    Route::get('marcas', [MarcaController::class, 'index']);
    Route::post('marcas', [MarcaController::class, 'store']);
    Route::get('marcas/{id}', [MarcaController::class, 'show']);
    Route::put('marcas/{id}', [MarcaController::class, 'update']);
    Route::delete('marcas/{id}', [MarcaController::class, 'destroy']);

    //rutas modelos
    Route::get('modelos', [ModeloController::class, 'index']);
    Route::post('modelos', [ModeloController::class, 'store']);
    Route::get('modelos/{id}', [ModeloController::class, 'show']);
    Route::put('modelos/{id}', [ModeloController::class, 'update']);
    Route::delete('modelos/{id}', [ModeloController::class, 'destroy']);

    //rutas personas
    Route::get('personas', [PersonaController::class, 'index']);
    Route::post('personas', [PersonaController::class, 'store']);
    Route::get('personas/{id}', [PersonaController::class, 'show']);
    Route::put('personas/{id}', [PersonaController::class, 'update']);
    Route::delete('personas/{id}', [PersonaController::class, 'destroy']);

    //rutas vehiculos vehiculos/alquiler
    Route::get('vehiculos', [VehiculoController::class, 'index']);
    Route::post('vehiculos', [VehiculoController::class, 'store']);
    Route::get('vehiculos/{id}', [VehiculoController::class, 'show']);
    Route::put('vehiculos/{id}', [VehiculoController::class, 'update']);
    Route::delete('vehiculos/{id}', [VehiculoController::class, 'destroy']);

    Route::get('user-profile', [LoginController::class, 'userProfile']);
    
    Route::get('logout', [LoginController::class, 'logout']);
});

