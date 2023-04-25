<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //2
        // $user = Auth::user();
        // if($user->store_id){
        //     $products = Product::where('store_id', '=' , $user->store_id)->paginate();
        // }else {
        //     $products = Product::paginate();
        // }
        //1
        // $products = Product::paginate(15);
        //3
        //  $products = Product::withoutGlobalScope('store')->paginate();
        $products = Product::paginate();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        // $user = Auth::user();
        // if($user->store_id){
        //     $products = Product::where('store_id', '=' , $user->store_id)->findOrFail($id);
        // }else {
        //     $products = Product::findOrFail($id);
        // }
        $products = Product::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
