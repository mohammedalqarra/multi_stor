<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CategoriesController;

Route::resource('dashboard/categories', CategoriesController::class);
