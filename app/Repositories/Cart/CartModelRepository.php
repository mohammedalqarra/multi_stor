<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartModelRepository implements CartRepository
{
    //  protected $items;

    public function get(): collection
    {
        //return Cart::all();

        return Cart::with('product')->get();
        //->where('cookie_id', '=', $this->getCookieId())->get();
    }

    public function add(Product $product, $quantity = 1)
    {
        $item = Cart::where('product_id' , '=' , $product->id)
     //   ->where('cookie_id', '=', $this->getCookieId())
        ->first();

       // dd($item);
        if(!$item){
            return Cart::create([
              //  'cookie_id' => Str::uuid(),
               // 'cooke_id' => $this->getCookieId(), // add events
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return $item->increment('quantity' , $quantity);

    }


    public function update(Product $product, $quantity)
    {
        Cart::where('product_id', '=', $product->id)
         //   ->where('cookie_id', '=', $this->getCookieId()) // سلة ال user
            ->update([
                'quantity' => $quantity,
            ]);
    }


    public function delete($id)
    {
        Cart::where('id', '=', $id)
         //   ->where('cookie_id', '=', $this->getCookieId())
            ->delete();
    }

    public function empty()
    {
        Cart::query()->delete();
        // where('cookie_id', '=', $this->getCookieId())
       // ->destroy();
    }

    public function total(): float
    {
        return (float)  Cart:: // casting 
        //  where('cookie_id', '=', $this->getCookieId())
            join('products', 'products.id', '=', 'carts.product_id')
            ->selectRaw('SUM(products.price * carts.quantity) as total')
            ->value('total');
    }


    // public function __construct()
    // {
    // }
}
