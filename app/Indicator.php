<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Indicator extends Model
{
    protected $guarded=[];
    use SoftDeletes;

    public function indicator_category()
    {
        return $this->belongsTo('App\Indicator_category','indicator_category_id','id');;
    }

    public function component()
    {
        return $this->belongsTo('App\Component','component_id','id');
    }
}
