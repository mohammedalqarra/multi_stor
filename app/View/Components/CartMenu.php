<?php

namespace App\View\Components;


use App\Facades\Cart;
use App\Repositories\Cart\CartRepository;
use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class CartMenu extends Component
{
    public $items;

    public $total;

    /**
     * Create a new component instance.
     */     //CartRepository $cart
    public function __construct()
    {
        // $this->items = $cart->get();
        // $this->total = $cart->Total();

        $this->items = Cart::get();
        $this->total = Cart::Total();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart-menu');
    }
}
