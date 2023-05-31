<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indicator_data extends Model
{
    protected $guarded=[];

    public function indicator()
    {
        return $this->belongsTo('App\Indicator','indicator_id','id');
    }

    public function component()
    {
        return $this->belongsTo('App\Component','component_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','approval_by','id');
    }

    public function data_add_user()
    {
        return $this->belongsTo('App\User','created_by','id');
    }

    // public function disapprove_details()
    // {
    //     return $this->belongsTo('App\Disapprove_details','id','indicator_data_id');
    // }
}
