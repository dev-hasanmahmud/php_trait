<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityIndicator extends Model
{
    protected $guarded=[];

    public function activitycategory()
    {
        return $this->belongsTo('App\ActivityCategory', 'activity_category_id');
    }

    public function component()
    {
        return $this->belongsTo('App\Component', 'component_id');
    }
}
