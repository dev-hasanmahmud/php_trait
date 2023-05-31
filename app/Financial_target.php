<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Financial_target extends Model
{
    protected $guarded=[];

    public function component()
    {
        return $this->belongsTo('App\Component','package_id','id');
    }

    public function financialitem()
    {
        return $this->belongsTo('App\FinancialItem','package_id','id');
    }
}
