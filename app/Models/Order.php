<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'store_id' , 'payment_method' , 'status' , 'payment_status',
    ]; 

    public function user(){
        return $this->belongsTo(User::class)->withDefault([
            'name' => ' Guest Customer'
        ]);
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function addresses(){
        return $this->hasMany(OrderAddress::class);
    }

    // تحديد شئ معين نستخد one to one
    public function billingAddress(){
        // Model
        return $this->hasOne(OrderAddress::class , 'order_id' , 'id')
        ->where('type' , '=' , 'billing');
    }

    public function shippingAddress(){
        return $this->hasOne(OrderAddress::class , 'order_id' , 'id')
        ->where('type' , '=' , 'shipping');
    }

    public function delivery(){
        return $this->hasOne(Delivery::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class , 'order_items' , 'order_id' ,'product_id' , 'id' , 'id')
        ->using(OrderItem::class) // pivot table  علاقة order_item
        ->as('order_item')
        ->withPivot([ // name column by جدول وسيط
            'product_name' , 'price' , 'quantity' , 'options',
        ]);
    }

    protected static function booted(){
        static::creating(function(Order $order){
            // 20220001 , 20220002
            $order->number = Order::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber(){
        // SELECT MAX(number) FROM orders
        $year = Carbon::now()->year();
        $number = Order::whereYear('created_at' , $year)->max('number');

        if($number){
            return $number + 1 ;
        }
        return $year . '0001';

    }
}
