<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Cart\CartRepository;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
    //

    public function create(CartRepository $cart)
    {

        if ($cart->get()->count() == 0) {
            return redirect()->route('home');
        }

        return view(
            'front.checkout',
            [
                'cart' => $cart,
                'countries' => Countries::getNames(),
            ]
        );
    }

    public function store(Request $request, CartRepository $cart)
    {

        $request->validate([]);

        $items = $cart->get()->groupBy('product.store_id')->all();

        DB::beginTransaction(); // exit commit

        try {
            foreach ($items as $store_id => $cart_items) {
                //1
                $order = Order::create([
                    'store_id' =>  $store_id,
                    'user_id' =>  Auth::id(),
                    'payment_method' => 'cod',
                ]);

                //2items
                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                    ]);
                }

                //3 customer in the order address
                foreach ($request->post('addr') as $type => $address) { // key array in the type address and value details address
                    $address['type'] = $type; // billing or shipping in the key
                    $order->addresses()->create($address);
                }
            }

            $cart->empty();
            DB::commit();


        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return redirect()->route('home');
    }
}
