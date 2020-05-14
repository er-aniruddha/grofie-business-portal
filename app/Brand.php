<?php

namespace Grofie;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $primaryKey = 'brand_id';
    protected $table = 'brands';
    protected $fillable = ['brand_image','brand_name', 'brand_description', 'publication_status', ];
    protected $dates = ['created_at','updated_at'];
}
