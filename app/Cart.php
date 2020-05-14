<?php

namespace Grofie;

use Illuminate\Database\Eloquent\Model;


class Cart extends Model
{
    protected $primaryKey = 'cart_id';
    protected $table = 'carts';
    protected $fillable = ['user_id', 'product_id', 'qty', ];
    protected $dates = ['created_at','updated_at'];
}
