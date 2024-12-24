<?php

use Illuminate\Support\Facades\Route;

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
// Companies
// =========================================================================

Route::prefix('companies')->group(function () {
    Route::get('/{slug}', [CompanyController::class, 'show']);
});
