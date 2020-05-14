<?php

namespace Grofie;


use Illuminate\Foundation\Auth\User as Authenticatable;

class DeliveryAssociates extends Authenticatable
{
	
    protected $table = 'delivery_associates';
    protected $fillable = ['phone','f_name','s_name','email',];
    protected $dates = ['created_at','updated_at'];
}
