<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $incrementing  = false;

    protected $fillable =  [
        'cookie_id', 'user_id', 'product_id' , 'quantity' , 'options'
    ];

    // Events(observer)
    // creating , created , updating , updated , saving , saved
    // deleting , deleted , restoring ,  restored , retrieved

    protected static function booted()
    {
        static::observe(CartObserver::class);
        // static::creating(function(Cart $cart){
        //     $cart->id = Str::uuid();
        // });
    }
}
