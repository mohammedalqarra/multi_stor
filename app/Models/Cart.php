<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Observers\CartObserver;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable =  [
        'cookie_id', 'user_id', 'product_id' , 'quantity' , 'options'
    ];

    // Events(observer)
    // creating , created , updating , updated , saving , saved
    // deleting , deleted , restoring ,  restored , retrieved

    protected static function booted()
    {
        static::observe(CartObserver::class);
        // static::creating(function(Cart $cart){ // instanse
        //     $cart->id = Str::uuid();
        // });

        static::addGlobalScope('cookie_id' , function(Builder $builder){
            $builder->where('cookie_id', '=' , Cart::getCookieId());
        });
    }

    public static function getCookieId()
    {
        $cookie_id  = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            // ما برجع responce بما ببعت معها cookie او بخزنها بال Q

            //Cookie::queue('cart_id', $cookie_id, Carbon::now()->addDays(30)); // carbon convert int
            Cookie::queue('cart_id', $cookie_id , 30 * 24  * 60);
            // dd('cookie_id');
        }
        return $cookie_id;
    }


    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Anonymous',
        ]);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
