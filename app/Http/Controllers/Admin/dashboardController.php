<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth']);
    // }

    // مجوعة ال methon عبارة عن Aaction


    public function index()
    {
        $title = 'Store';

        $user = Auth::user();
        // return response : view , json , redirect , file
        return view('admin.index' , [
            'user' => 'Mohammed',
            'title' => $title
        ]);
    }
}
