<?php

use App\Http\Controllers\{TransactionController, TransactionDataController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/transaction/customers', [TransactionDataController::class, 'customers']);
Route::get('/transaction/customers/{customer}', [TransactionDataController::class, 'showCustomer']);
Route::get('/transaction/items', [TransactionDataController::class, 'items']);
Route::get('/transaction/item/{code}', [TransactionDataController::class, 'getId']);

Route::get('/transactions', [TransactionController::class, 'index']);
Route::post('/transactions/create', [TransactionController::class, 'create']);
Route::get('/transactions/{id}', [TransactionController::class, 'show']);
Route::put('/transactions/{order}', [TransactionController::class, 'update']);
Route::delete('/transactions/{order}', [TransactionController::class, 'delete']);