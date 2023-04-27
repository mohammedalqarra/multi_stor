<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // helper function
        $request = request();

        // $query = Category::query();
        // $categories = $query->paginate(2);
        /*
        SELECT a.* , b.name as parent_name (*)
        FORm categories as a (Arries)
        LEFT JOIN categories as  b ON b.id = a.parent_id
*/
        $categories = Category::with('parent')
            /*leftJoin('categories as parents' , 'parents.id' , '=' , 'categories.parent_id')
        ->select([
            'categories.*',
            'parents.name as parent_name'
        ])*/
            //->select('categories.*')
            //   ->selectRaw('(SELECT COUNT(*) FROM products WHERE  AND status = 'active' category_id = categories.id) as products_count')
            // or
            //   ->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as products_count')
            // ->addSelect(DB::raw('(SELECT COUNT(*) FROM products WHERE category_id = category.id) as product_count'))
            ->withCount([
                'products as products_number' => function($query){
                $query->where('status' , '=' , 'active');
            }])
            ->filter($request->query())
            // ->withTrashed()
            ->orderByDesc('categories.name')
            ->paginate(15);
        // $categories = Category::active()->paginate(); // scopeActive
        //  $categories = Category::Status('archived')->active()->paginate(); // scope & parameter
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

        return view('admin.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $clena_data = $request->validate(Category::rules(), [ // ترجع ال data بعد فحصها
            'required'  => 'This Field (:attribute) is required',
            'name.unique' => 'This is name already exists!' // customization message
        ]);

        //Request merge
        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);

        $data  = $request->except('image');
        $data['image']  = $this->uploadImage($request);


        $category = Category::create($data);

        // $category = new Category( $request->all() );
        // $category->save();

        //Mass assignment
        // $category = Category::create($request->all());



        //PRG
        //  return redirect()->route('categories.index');

        return Redirect::route('categories.index')->with('msg', 'Category created successfully!')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
        return view('admin.categories.show' , [
            'category' => $category
        ]);

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
        $parents = Category::where('id', '<>', $id)->where(function ($query) use ($id) {
            $query->whereNull('parent_id')
                ->orWhere('parent_id', '<>', $id);
        })->get();
        return view('admin.categories.edit', compact('category', 'parents'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        //
        //  $request->validate(Category::rules($id));

        $category = Category::findOrFail($id);
        $old_image = $category->image;
        $data  = $request->except('image');
        $new_image = $this->uploadImage($request);

        if ($new_image) {
            $data['image'] = $new_image;
        }
        //  $category = Category::find($id);

        // $category->update($request->all());
        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image); // name disk because use delete
        }

        $category->update($data);
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

        // if ($category->image) {
        //     Storage::disk('public')->delete($category->image);
        // }
        return redirect()->route('categories.index')->with('msg', 'Category delete successfully')->with('type', 'danger');
    }


    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }

        $file = $request->file('image'); // UploadedFile object
        // $file->getClientOriginalName();
        // $file->getSize();
        // $file->getClientOriginalExtension();
        // $file->getMimeType(); // png,jpg
        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);

        return  $path;
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();

        return view('admin.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('categories.trash')
            ->with('success', 'category restored!');
        // return Redirect::route('categories.trash')->with('msg', 'Category created successfully!')->with('type', 'success');

    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }


        return redirect()->route('categories.trash')
            ->with('success', 'category Delete forever!');
    }
}
