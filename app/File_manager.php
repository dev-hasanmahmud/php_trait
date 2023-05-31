<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class File_manager extends Model
{
    protected $guarded=[];
    use SoftDeletes;

 
    
}
