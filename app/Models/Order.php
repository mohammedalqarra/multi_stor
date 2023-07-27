<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id', 'user_id', 'payment_method', 'status', 'payment_status',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Customer'
        ]);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id')
            ->using(OrderItem::class)
            ->as('order_item')
            ->withPivot([
                'product_name', 'price', 'quantity', 'options',
            ]);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
            ->where('type', '=', 'billing');

        //return $this->addresses()->where('type', '=', 'billing');
    }

    public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
            ->where('type', '=', 'shipping');
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    protected static function booted()
    {
        static::creating(function(Order $order) {
            // 20220001, 20220002
            $order->number = Order::getNextOrderNumber();
        });
    }

    // public static function getNextOrderNumber()
    // {
    //     // SELECT MAX(number) FROM orders
    //     $year =  Carbon::now()->year;
    //     $number = Order::whereYear('created_at', $year)->max('number');
    //     if ($number) {
    //         return $number + 1;
    //     }
    //     return $year . '0001';
    // }

    public static function getNextOrderNumber()
{
    $year = Carbon::now()->year;

    // Retrieve the maximum order number for the given year
    $number = Order::whereYear('created_at', $year)->max('number');

    if (is_numeric($number)) {
        // If the $number is numeric (not null), increment it by 1
        return $number + 1;
    } else {
        // If $number is non-numeric (e.g., null), generate a new order number
        $lastOrderNumber = Order::orderBy('number', 'desc')->first();

        if ($lastOrderNumber) {
            // Extract the year part of the last order number
            $lastYear = substr($lastOrderNumber->number, 0, 4);

            if ($lastYear == $year) {
                // If the last order was created in the same year, increment the last order number by 1
                return $lastOrderNumber->number + 1;
            }
        }

        // If there are no existing orders for the current year or the last order was from a different year
        return $year . '0001';
    }
}

}
