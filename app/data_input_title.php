<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class data_input_title extends Model
{
    protected $guarded = [];

    public function component()
    {
        return $this->belongsTo('App\Component', 'component_id', 'id')->select('id', 'package_no', 'name_en');
    }

}