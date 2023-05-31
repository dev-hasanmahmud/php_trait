<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approving_authority extends Model
{
    protected $fillable = [
        'name_en', 'name_bn'
    ];
}
