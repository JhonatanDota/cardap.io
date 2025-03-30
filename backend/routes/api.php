<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;

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

// =========================================================================
// Auth
// =========================================================================

Route::post('/auth', [AuthController::class, 'login']);

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('/me', [AuthController::class, 'me']);
});

// =========================================================================
// Companies
// =========================================================================

Route::prefix('companies')->group(function () {
    Route::get('/{slug}', [CompanyController::class, 'retrieve']);
});
