<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\dashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// بستبدل route facade بال router object

// $router = app()->make('router');

// $router::get('/', function () {
//     return view('welcome');
// });



// Route::get('/', function () {
//     return view('admin.dashboard');
// });

Route::get('/index' , [dashboardController::class , 'index']);
