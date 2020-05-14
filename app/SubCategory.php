<?php

namespace Grofie;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $primaryKey = 'sub_cat_id';
    protected $table = 'sub_categories';
    protected $fillable = ['image','sub_cat_name', 'sub_cat_description', 'publication_status', ];
    protected $dates = ['created_at','updated_at'];
}
