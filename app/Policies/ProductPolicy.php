<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy extends ModelPolicy
{
    public function view($user, Product $product)
    {
        return $user->hasAbility('products.view');
    }
}
