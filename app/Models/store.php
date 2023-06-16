<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Store extends Model
{
    use HasFactory , Notifiable;

    const CREATE = 'created_at';
    const UPDATE = 'updated_at';

    protected $connection = 'mysql';

    protected $table = 'stores';

    protected $primaryKey  = 'mysql';

    protected $KeyType = 'int';

    // protected $incrementing = true;

    // protected $timestamp = true;



    public function products()
    {
        return $this->hasMany(Product::class , 'store_id' , 'id');
    }
}
