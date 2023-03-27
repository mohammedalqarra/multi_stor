<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\dashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;


Route::group([
    'middleware' => ['auth'],
    'prefix'  => 'dashboard',
], function () {

    Route::get('/', [dashboardController::class, 'index'])->name('dashboard');
    Route::resource('/categories', CategoriesController::class);
});
