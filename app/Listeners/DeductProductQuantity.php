<?php

namespace App\Listeners;

use Throwable;
use App\Facades\Cart;
use App\Models\Product;
use App\Events\OrderCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeductProductQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event)
    {
        $order = $event->order;
      //  dd($order->products);
        // UPDATE products SET quantity = quantity - 1
        try {
            foreach ($order->products as $product) {
                $product->decrement('quantity', $product->order_item->quantity);

                // Product::where('id', '=', $item->product_id)
                //     ->update([
                //         'quantity' => DB::raw("quantity - {$item->quantity}")
                //     ]);
            }
        } catch (Throwable $e) {

        }
    }
}



// foreach (Cart::get() as $item) {
//     $productId = $item->product_id;
//     $quantity = $item->quantity;

//     Product::where('id', $productId)
//         ->where('quantity', '>=', $quantity) // Ensure the quantity is sufficient
//         ->update([
//             'quantity' => DB::raw("quantity - $quantity"),
//         ]);
// }
