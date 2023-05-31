<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $guarded = [];
    public function types()
    {
        return $this->hasMany('App\Type','id','type_id');
    }
}
