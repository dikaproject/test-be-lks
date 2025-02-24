<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\api\BookController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\LoanController;
use App\Http\Controllers\api\PublisherController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/books', BookController::class);
Route::apiResource('/loans', LoanController::class);
Route::apiResource('/publishers', PublisherController::class);
Route::apiResource('/authors', AuthorController::class);
Route::apiResource('/users', UserController::class);
});






Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);