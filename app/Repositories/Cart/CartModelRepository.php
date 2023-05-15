<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartModelRepository implements CartRepository
{
    protected $items;

    public function get(): collection
    {
        //return Cart::all();

        return Cart::where('cookie_id', '=', $this->getCookieId())->get();
    }

    public function add(Product $product, $quantity = 1)
    {

        return Cart::create([
            'cooke_id' => $this->getCookieId(),
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);
    }


    public function update(Product $product, $quantity)
    {
        Cart::where('product_id', '=', $product->id)
        ->where('cookie_id' , '=' , $this->getCookieId()) // سلة ال user
        ->update([
            'quantity' => $quantity,
        ]);
    }


    public function delete(Product $product)
    {
        Cart::where('product_id', '=', $product->id)
        ->where('cookie_id' , '=' , $this->getCookieId())
        ->delete();
    }

    public function empty()
    {
        Cart::where('cookie_id' , '=' , $this->getCookieId())->destroy();
    }

    public function total(): float
    {
        return Cart::where('cookie_id', '=', $this->getCookieId())
        ->join('product', 'product.id', '=', 'carts.product_id')
        ->selectRaw('SUM(products.price * carts.quantity) as total')
        ->value('total');
    }

    public function getCookieId()
    {
        $cookie_id  = Cookie::get('cart_id');
        if(!$cookie_id){
            $cookie_id = Str::uuid();
            // ما برجع responce بما ببعت معها cookie او بخزنها بال Q
            Cookie::queue('cart_id', $cookie_id , Carbon::now()->addDays(30));
        }
        return $cookie_id;
    }
    public function __construct()
    {
    }
}
