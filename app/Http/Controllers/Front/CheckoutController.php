<?php

namespace App\Http\Controllers\Front;

use Throwable;
use App\Models\Order;
use App\Models\OrderItem;
use App\Events\OrderCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use App\Exceptions\InvalidOrderException;
use App\Repositories\Cart\CartRepository;

class CheckoutController extends Controller
{
    //

    public function create(CartRepository $cart)
    {

        if ($cart->get()->count() == 0) {
            // return redirect()->route('home');
            throw new InvalidOrderException('Cart is Empty');
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

        $request->validate([
            'addr.billing.first_name' => ['required', 'string', 'max:255'],
            'addr.billing.last_name' => ['required', 'string', 'max:255'],
            'addr.billing.email' => ['required', 'string', 'max:255'],
            'addr.billing.phone_number' => ['required', 'string', 'max:255'],
            'addr.billing.city' => ['required', 'string', 'max:255'],
        ]);

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

            DB::commit();

            // event('order.created' , $order , Auth::id());
            event(new OrderCreated($order));
        } catch (Throwable $e) {

            DB::rollBack();
            throw $e;
        }
        return redirect()->route('orders.payments.create' , $order->id);
    }
}
