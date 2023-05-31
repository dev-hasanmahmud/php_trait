<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityIndicatorData extends Model
{
    protected $guarded=[];
   

    public function activityindicator()
    {
        return $this->belongsTo('App\ActivityIndicator','activity_indicator_id','id');
    }

    public function component()
    {
        return $this->belongsTo('App\Component','component_id','id');
    }
}
