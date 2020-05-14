<?php

namespace Grofie;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    protected $table = 'products';
    protected $fillable = ['product_image','product_name', 'product_description', 'publication_status','product_stock_qty' ];
    protected $dates = ['created_at','updated_at'];
}    
