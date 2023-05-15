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

        return Cart::with('products')->where('cookie_id', '=', $this->getCookieId())->get();
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
            ->where('cookie_id', '=', $this->getCookieId()) // سلة ال user
            ->update([
                'quantity' => $quantity,
            ]);
    }


    public function delete($id)
    {
        Cart::where('id', '=', $id)
            ->where('cookie_id', '=', $this->getCookieId())
            ->delete();
    }

    public function empty()
    {
        Cart::where('cookie_id', '=', $this->getCookieId())->destroy();
    }

    public function total(): float
    {
        return (float) Cart::where('cookie_id', '=', $this->getCookieId())
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->selectRaw('SUM(products.price * carts.quantity) as total')
            ->value('total');
    }

    protected function getCookieId()
    {
        $cookie_id  = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            // ما برجع responce بما ببعت معها cookie او بخزنها بال Q

            //            Cookie::queue('cart_id', $cookie_id, Carbon::now()->addDays(30)); // carbon convert ont
            Cookie::queue('cart_id', $cookie_id, 30 * 24  * 60);
            // dd('cookie_id');
        }
        return $cookie_id;
    }
    // public function __construct()
    // {
    // }
}
