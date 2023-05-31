<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training_activity extends Model
{
    protected $guarded=[];

    public function trainingcategory()
    {
        return $this->belongsTo('App\TrainingCategory','training_category_id','id');
    }

    public function training()
    {
        return $this->belongsTo('App\Training','training_id','id');
    }
}
