<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlaskController;
use App\Http\Controllers\ExpressController;


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


//Rutas de ventas (Express)
Route::get('/ventas', [ExpressController::class,'traer_ventas']);
Route::post('/ventas', [ExpressController::class,'crear_venta'])->middleware("auth:api");
Route::put('/ventas/{id}', [ExpressController::class,'actualizar_venta'])->middleware("auth:api");
Route::delete('/ventas/{id}', [ExpressController::class,'eliminar_venta']);

