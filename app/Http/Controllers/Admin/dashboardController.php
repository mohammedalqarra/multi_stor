<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    // مجوعة ال methon عبارة عن Aaction

    public function index()
    {
        // return response : view , json , redirect , file
        return view('admin.dashboard');
    }
}
