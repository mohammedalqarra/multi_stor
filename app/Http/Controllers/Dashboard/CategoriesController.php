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
        $category = new Category();

        return view('admin.categories.create', compact('parents' , 'category'));
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
        // try{
        //     $category = Category::findOrFail($id);
        // }catch (Exception $e{
        //     abort(404);
        // }
        $category = Category::findOrFail($id);
        // Select * From categories Where id <> id And (Parent_id is null OR parent_id <> $id)
        $parents = Category::where('id' , '<>' , $id)->where(function ($query) use($id){
            $query->whereNull('parent_id')
            ->orWhere('parent_id' , '<>' , $id);
        })->get();
        return view('admin.categories.edit', compact('category' , 'parents'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $category = Category::find($id);
        $category->update($request->all());
        //$category->fill($request->all())->save();
        return Redirect::route('categories.index')->with('msg', 'Category update successfully!')->with('type', 'info');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //$category::where('id' , '=' , $id)->delete();
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('msg', 'Category delete successfully')->with('type', 'danger');
    }
}
