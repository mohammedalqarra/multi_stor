<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\dashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;

Route::get('/dashboard' , [dashboardController::class , 'index'])->middleware(['auth' , 'verified'])->name('dashboard');


Route::resource('dashboard/categories', CategoriesController::class);
