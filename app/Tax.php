<?php

namespace Grofie;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $primaryKey = 'tax_id';
    protected $table = 'taxes';
    protected $fillable = ['tax_name_lm', 'tax_name_sm', 'tax_percentage', ];
    protected $dates = ['created_at','updated_at'];
}
