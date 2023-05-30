<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\CartModelRepository;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }
    /**
     * Display a listing of the resource.
     */
    // public function index(CartRepository $cart)
    public function index()
    {
        //
        // $repository = new CartModelRepository();
        // $repository = App::make('cart');
        // $items = $repository->get();
        //  $items = $cart->get();
        return view('front.cart', [
            'cart' => $this->cart,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1'],
        ]);


        $product = Product::findOrFail($request->post('product_id'));
        //  $repository = new CartModelRepository();
        //  $repository->add($product, $request->post('quantity'));
        $this->cart->add($product, $request->post('quantity'));

        if($request->expectsJson()){
            
            return response()->json([
                'message' => 'Item added to cart!',
            ], 201);
        }
        return redirect()->route('cart.index')->with('success' , 'Product added to Cart');

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
           // 'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['required', 'int', 'min:1'],
        ]);

       // $product = Product::findOrFail($request->post('product_id'));
       //  $repository = new CartModelRepository();
       //  $repository->update($product, $request->post('quantity'));
        $this->cart->update($id, $request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    // id - parameter in the route
    {
        //
        // $repository = new CartModelRepository();

        $this->cart->delete($id);

        return[
            'message' => 'Item deleted!',
        ];
    }

    // public function remove_cart($id)
    // {
    //     Cart::destroy($id);

    //     return redirect()->back();
    // }
}
