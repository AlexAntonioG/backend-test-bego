<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\UserController;

// Endpoints para autenticación
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Endpoint general de CRUD para usuarios
// GET    /api/users        -> index()
// POST   /api/users        -> store()
// GET    /api/users/{id}   -> show()
// PUT    /api/users/{id}   -> update()
// DELETE /api/users/{id}   -> destroy()
Route::apiResource('users', UserController::class);

// Endpoint general de CRUD para trucks
// GET    /api/trucks        -> index()
// POST   /api/trucks        -> store()
// GET    /api/trucks/{id}   -> show()
// PUT    /api/trucks/{id}   -> update()
// DELETE /api/trucks/{id}   -> destroy()
Route::apiResource('trucks', TruckController::class);

// Endpoint general de CRUD para orders
// GET    /api/orders        -> index()
// POST   /api/orders        -> store()
// GET    /api/orders/{id}   -> show()
// PUT    /api/orders/{id}   -> update()
// DELETE /api/orders/{id}   -> destroy()
Route::apiResource('orders', OrderController::class);

// Cambio de status especifico de la orden
Route::patch('orders/{id}/status', [OrderController::class, 'updateStatus']);

// Endpoint general de CRUD para locations
// GET    /api/locations        -> index()
// POST   /api/locations        -> store()
// GET    /api/locations/{id}   -> show()
// PUT    /api/locations/{id}   -> update()
// DELETE /api/locations/{id}   -> destroy()
Route::apiResource('locations', LocationController::class);
