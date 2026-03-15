<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlaskController;
use App\Http\Controllers\ExpressController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Login y register de usuario
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:api');


//Rutas de productos (Flask)
Route::get('/productos', [FlaskController::class,'traer_productos'])->middleware('auth:api');
Route::post('/productos', [FlaskController::class,'crear_producto'])->middleware('auth:api');
Route::put('/productos/{id}', [FlaskController::class,'actualizar_producto'])->middleware('auth:api');
Route::delete('/productos/{id}', [FlaskController::class,'eliminar_producto'])->middleware('auth:api');


//Rutas de ventas (Express)
Route::get('/ventas', [ExpressController::class,'traer_ventas'])->middleware("auth:api");
Route::post('/ventas', [ExpressController::class,'crear_venta'])->middleware("auth:api");
Route::put('/ventas/{id}', [ExpressController::class,'actualizar_venta'])->middleware("auth:api");
Route::delete('/ventas/{id}', [ExpressController::class,'eliminar_venta'])->middleware("auth:api");
Route::post('/ventas_usuario/', [ExpressController::class,'traer_ventas_usuario'])->middleware("auth:api");

