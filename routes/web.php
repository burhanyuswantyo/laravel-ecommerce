<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LivewireProductController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Auth::routes();

// Route::middleware('auth')
//     ->group(function () {
//         Route::prefix('admin')->as('admin.')
//             ->group(function () {
//                 Route::resource('products', ProductController::class);
//             });
//     });

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::resource('products', ProductController::class);
        Route::resource('products-livewire', LivewireProductController::class);
    });
});
