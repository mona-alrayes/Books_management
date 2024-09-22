<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::put('books/restore/{id}', [BookController::class, 'restore'])->name('books.restore');
Route::get('books/trashed', [BookController::class, 'showTrashed'])->name('books.trashed');
Route::delete('books/forceDelete/{id}', [BookController::class, 'forceDelete'])->name('books.forceDelete');
Route::apiResource('books', BookController::class);

