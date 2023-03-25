<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (request()->has('category')) {
            $categories = Category::where('name', 'like', '%' . request()->category . '%')->orderBy('id', 'desc')->paginate(10);
        } else {
            $categories = Category::where('name', 'like', '%' . request()->category . '%')->orderByDesc('id')->paginate(10);
        }
        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $parents = Category::all();
        return view('admin.categories.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // $category = new Category( $request->all() );
        // $category->save();
        //Request merge
        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);
        //Mass assignment
        $category = Category::create($request->all());

        //PRG
        //  return redirect()->route('categories.index');

        return Redirect::route('categories.index')->with('msg', 'Category created successfully!')->with('type', 'success');
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
