<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $guarded=[];

    //protected $fillable=['data_acquisition_id','user_id','comment'];

    public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

}
