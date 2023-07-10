<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
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
      //  return view('admin.index', compact('user'));
    }
}
