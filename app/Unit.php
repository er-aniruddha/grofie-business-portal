<?php

namespace Grofie;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $primaryKey = 'unit_id';
    protected $table = 'units';
    protected $fillable = ['unit_name_lm', 'unit_name_sm', 'unit_unit', ];
    protected $dates = ['created_at','updated_at'];
}
