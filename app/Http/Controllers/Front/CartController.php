<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CartRepository $cart)
    {
        //
        // $repository = new CartModelRepository();
        // $repository = App::make('cart');
        // $items = $repository->get();
        //  $items = $cart->get();
        return view('front.cart', [
            'cart' => $cart,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CartRepository $cart)
    {
        //
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1'],
        ]);

        $prooduct = Product::findOrFail($request->post('product_id'));
        //  $repository = new CartModelRepository();
        //  $repository->add($product, $request->post('quantity'));
        $cart->add($prooduct, $request->post('quantity'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartRepository $cart)
    {
        //
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1'],
        ]);

        $prooduct = Product::findOrFail($request->post('product_id'));
        //  $repository = new CartModelRepository();
        //  $repository->update($product, $request->post('quantity'));
        $cart->update($prooduct, $request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartRepository $cart, $id)
    // id - parameter in the route
    {
        //
        // $repository = new CartModelRepository();

        $cart->delete($id);
    }
}
