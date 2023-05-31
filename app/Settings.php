<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table='settings';
    protected $guarded=[];
    public $timestamps = false;

    public function types()
    {
        return $this->belongsTo('App\Type','type_id','id');
    }

    public function procurement()
    {
        return $this->belongsTo('App\Proc_method','procurement_method_id','id');
    }
}
