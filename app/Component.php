<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
    protected $guarded=[];
    use SoftDeletes;
    
    public function type()
    {
        return $this->belongsTo('App\Type','type_id','id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit','unit_id','id');
    }

    public function proc_method()
    {
        return $this->belongsTo('App\Proc_method','proc_method_id','id');
    }

    public function approving_authority()
    {
        return $this->belongsTo('App\Approving_authority','approving_authority_id','id');
    }

    public function source_of_fund()
    {
        return $this->belongsTo('App\Source_of_fund','source_of_fund_id','id');
    }

    public function title() //data input title
    {
        return $this->hasMany('App\data_input_title','component_id','id');
    }
}
