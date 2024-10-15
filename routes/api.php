<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

// Rutas para la autenticación
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

// Rutas para los libros
/*Route::get('books', [BookController::class, 'index']);
Route::post('books', [BookController::class, 'store'])->middleware('auth:api');
Route::get('books/{id}', [BookController::class, 'show'])->middleware('auth:api');
Route::delete('books/{id}', [BookController::class, 'destroy'])->middleware('auth:api');
*/

// CRUD de libros, protegido con JWT extraído de cookies
Route::middleware('jwt.cookie')->group(function () {
    Route::post('books', [BookController::class, 'store']);      // Crear libro
    Route::get('books', [BookController::class, 'index']);       // Listar todos los libros
    Route::get('books/{id}', [BookController::class, 'show']);   // Mostrar un libro específico por su identificador
});

