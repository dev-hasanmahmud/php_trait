<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Works_package_payment extends Model
{
    protected $guarded = [];

    public function component()
    {
        return $this->belongsTo('App\Component', 'package_id', 'id')->orderBy('package_no');
    }

    public function contactor()
    {
        return $this->belongsTo('App\Contactor', 'contactor_id', 'id');
    }

    public function source_of_fund()
    {
        return $this->belongsTo('App\Source_of_fund', 'source_of_fund_id', 'id');
    }

    public function fiancial_item()
    {
        return $this->belongsTo('App\FinancialItem', 'package_id', 'id');
    }

}