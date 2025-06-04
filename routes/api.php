<?php

use App\Http\Controllers\Api\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// API Version 1 Group
Route::prefix('v1')->group(function () {

    // Companies Service Group
    Route::prefix('companies')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('companies.index');
        Route::post('/', [CompanyController::class, 'store'])->name('companies.store');
        Route::get('/{nit}', [CompanyController::class, 'show'])->name('companies.show');
        Route::put('/{nit}', [CompanyController::class, 'update'])->name('companies.update');
        Route::delete('/{nit}', [CompanyController::class, 'destroy'])->name('companies.destroy');
    });

});
