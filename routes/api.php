<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\AuthController;


// ------------------- RUTA DE PRUEBA -------------------
Route::get('/test', function () {
    return response()->json(['message' => 'API funciona correctamente!']);
});

// ------------------- LOGIN -------------------

//Route::post('/register', [AuthController::class, 'register']);
//Route::post('/login', [AuthController::class, 'login']);


// ------------------- CLIENTES -------------------
Route::get('/clients', [ClientController::class, 'index']);        
Route::get('/clients/{id}', [ClientController::class, 'show']);   
Route::post('/clients', [ClientController::class, 'store']);      

// ------------------- PRODUCTOS -------------------
Route::get('/products', [ProductController::class, 'index']);       
Route::get('/products/{id}', [ProductController::class, 'show']);  
Route::post('/products', [ProductController::class, 'store']);     

// ------------------- ÓRDENES -------------------
//Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/orders', [OrderController::class, 'index']);           
    Route::get('/orders/{id}', [OrderController::class, 'show']);       
    Route::post('/orders', [OrderController::class, 'store']);          
//});
