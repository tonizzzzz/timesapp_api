<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TimeEntryController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// routes/api.php

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/clock-in', [TimeEntryController::class, 'clockIn']);
    Route::post('/clock-out/{id}', [TimeEntryController::class, 'clockOut']);
    Route::get('/entries', [TimeEntryController::class, 'getEntries']);
    Route::get('/clock-in-today', [TimeEntryController::class, 'checkClockInToday']);
});
