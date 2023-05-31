<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancialItem extends Model
{
    protected $table='financial_items';
    protected $guarded=[];
    public $timestamps = false;
}
