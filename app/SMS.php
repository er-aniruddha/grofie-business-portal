<?php

namespace Grofie;

use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    protected $table = 'sms';
    protected $fillable = ['api', 'secret' , 'email']; 
    protected $dates = ['created_at','updated_at'];
   
}
