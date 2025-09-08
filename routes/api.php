<?php

use App\Http\Controllers\AuthController;
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
