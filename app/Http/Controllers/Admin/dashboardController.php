<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class dashboardController extends Controller
{
    // مجوعة ال methon عبارة عن Aaction


    public function index()
    {
        $title = 'Store';

        // return response : view , json , redirect , file
        return view('admin.index' , [
            'user' => 'Mohammed',
            'title' => $title
        ]);
    }
}
