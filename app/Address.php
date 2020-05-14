<?php

namespace Grofie;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $primaryKey = 'address_id';
    protected $table = 'address';
    protected $dates = ['created_at','updated_at'];
}
