<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyPaymentMethodController;
use App\Http\Controllers\CompanyOpeningHourController;

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
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// =========================================================================
// Companies
// =========================================================================

Route::prefix('companies')->group(function () {
    Route::get('/{company}/opening-hours', [CompanyOpeningHourController::class, 'show']);
    Route::get('/{company}/payment-methods', [CompanyPaymentMethodController::class, 'show']);

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::post('/', [CompanyController::class, 'store']);
        Route::get('/my-company', [CompanyController::class, 'userCompany']);
        Route::patch('/{company}', [CompanyController::class, 'update']);

        Route::post('/{company}/payment-methods', [CompanyPaymentMethodController::class, 'sync']);
    });
});
