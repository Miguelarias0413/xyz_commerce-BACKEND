<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Ruta protegida que devuelve el usuario autenticado
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Ruta de prueba
Route::get('/test', function () {
    return response()->json(['message' => 'xd']);
});

// Rutas de autenticación (sin middleware de autenticación)
Route::prefix('/user')->name('user.')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'registerUser']);
});

// Otras rutas protegidas por el middleware de autenticación / Logica USUARIOS/PRODUCTOS
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/addUserProduct', [ProductController::class, 'addUserProduct']);
    Route::get('/getAllUsers', [ProductController::class, 'getAllUsers']);
    Route::get('/getAllProducts', [ProductController::class, 'getAllProducts']);
    Route::get('/associateProductsToUser', [ ProductController::class,'associateProductsToUser']);

});


// Rutas con middleware de auth pero dedicadas para las ordenes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/createOrder', [OrderController::class, 'createOrder']);
});
