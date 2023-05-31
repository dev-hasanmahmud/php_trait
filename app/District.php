<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $guarded=[];
   
    public function unions()
    {
        return $this->hasMany('App\Union','district_id','id');
    }
}
