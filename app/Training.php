<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $guarded=[];

    public function trainingcategory()
    {
        return $this->belongsTo('App\TrainingCategory','training_category_id','id');
    }
}
