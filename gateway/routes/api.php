<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlaskController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:api');


//Rutas de productos (Flask)
Route::get('/productos', [FlaskController::class,'traer_productos']);
Route::post('/productos', [FlaskController::class,'crear_producto']);
Route::put('/productos/{id}', [FlaskController::class,'actualizar_producto']);
Route::delete('/productos/{id}', [FlaskController::class,'eliminar_producto']);

