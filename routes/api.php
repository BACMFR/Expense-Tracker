<?php

use App\Http\Controllers\ExpenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Define routes for ExpenseController
Route::controller(ExpenseController::class)->group(function () {
    Route::get('/expenses', 'index');
    Route::post('/expenses', 'store');
    Route::get('/expenses/{expense}', 'show');
    Route::put('/expenses/{expense}', 'update');
    Route::delete('/expenses/{expense}', 'destroy');
});

Route::get('/summary/expense', [ExpenseController::class, 'summary']);
Route::get('/expenses/summary/{month}', [ExpenseController::class, 'monthlySummary']);
