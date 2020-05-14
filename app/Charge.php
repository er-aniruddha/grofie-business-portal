<?php

namespace Grofie;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{   
    protected $table = 'charges';
    protected $fillable = ['delivery_charges', 'km_charges', ];
    protected $dates = ['created_at','updated_at'];
}
