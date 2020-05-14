<?php

namespace Grofie;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = ['product_id', 'user_id', 'qty', 'address_id',];
    protected $dates = ['created_at','updated_at'];
}
