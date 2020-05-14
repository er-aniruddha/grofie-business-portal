<?php

namespace Grofie;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    
    protected $table = 'stores';
    protected $fillable = ['store_name', 'lat', 'long', ];
    protected $dates = ['created_at','updated_at'];
}
