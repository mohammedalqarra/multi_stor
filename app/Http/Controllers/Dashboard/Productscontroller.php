<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
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
        $this->authorize('view-any' , Product::class);
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

        $products = Product::with(['category', 'store'])->paginate();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $this->authorize('create', Product::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->authorize('create', Product::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $product = Product::findOrFail($id);
        $this->authorize('view', $product);
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


        $product = Product::findOrFail($id);

        $this->authorize('update' , $product);

        $tags = implode(',' , $product->tags()->pluck('name')->toArray());

        return view('admin.products.edit' , compact('product' , 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, product $product)
    {
        //
        $this->authorize('update' , $product);

        $product->update( $request->except('tags') );

       // $tags = explode(',' , $request->post('tags'));

       $tags = json_decode($request->post('tags'));

        $tag_ids = [];

        $saved_tag = Tag::all();


        foreach($tags as $item){
            // $slugcount  = Product::where('slug', 'like' , '%' . Str::slug ($item->value) . '%')->count();
            // $slug = Str::slug($item->value);
            // if($slugcount){
            //     $slug = Str::slug($item->value).'_'.$slugcount;
            // }

             $slug = Str::slug($item->value);
            $tag = $saved_tag->where('slug' , $slug)->first(); // search collection
            if(!$tag){
                $tag = Tag::create([
                    'name' => $item->value,
                    'slug' => $slug,
                ]);
            }
            $tag_ids[] = $tag->id;
        }

        $product->tags()->sync($tag_ids);

        return redirect()->route('products.index')->with('success' , 'product updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $product= Product::findOrFail($id);

        $this->authorize('delete' , $product);
    }
}
