<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\dashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\ProfileController;

Route::group([
    'middleware' => ['auth'],
    'prefix'  => 'dashboard',
], function () {

    Route::get('/', [dashboardController::class, 'index'])->name('dashboard');

    Route::get('/categories/trash' , [CategoriesController::class, 'trash'])->name('categories.trash');
    Route::put('categories/{category}/restore' , [CategoriesController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/{category}/force-delete' , [CategoriesController::class, 'forceDelete'])->name('categories.force-delete');

    Route::resource('/categories', CategoriesController::class);

    Route::resource('/products', ProductsController::class);
    
    Route::get('profile' , [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('profile' , [ProfileController::class, 'update'])->name('profile.update');


});
