<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityCategory extends Model
{
    protected $guarded=[];

    public function component()
    {
        return $this->belongsTo('App\Component', 'component_id');
    }
}
