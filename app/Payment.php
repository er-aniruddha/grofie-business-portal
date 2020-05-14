<?php

namespace Grofie;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
   
    protected $table = 'payments';
    protected $fillable = ['cod',];
    protected $dates = ['created_at','updated_at'];
}
