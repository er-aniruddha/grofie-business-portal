<?php

namespace Grofie;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';
    protected $table = 'categories';
    protected $fillable = ['image','category_name', 'category_description', 'publication_status', ];
    protected $dates = ['created_at','updated_at'];
}
