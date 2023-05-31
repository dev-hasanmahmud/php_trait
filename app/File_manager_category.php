<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File_manager_category extends Model
{
    protected $table='file_manager_categories';

    protected $guarded=[];
    public function parent()
    {
        return $this->belongsTo('App\File_manager_category','parent_id','id');
    }
}