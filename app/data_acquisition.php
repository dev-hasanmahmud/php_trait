<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class data_acquisition extends Model
{
    protected $guarded=[];
    // protected $appends=['files_count'];

    public function component()
    {
        return $this->belongsTo('App\Component','component_id','id');
    }

    public function data_input_title()
    {
        return $this->belongsTo('App\data_input_title','data_input_title_id','id');
    }

    public function upload_by()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function users()
    {
        return $this->hasMany('App\User','user_id','id');
    }

    public function files()
    {
        return $this->hasMany('App\File_manager','table_id','id')->where('fm_category_id',38);
    }

    // public function getFilesCountAttribute()
    // {
    //     return $this->files->count();
    // }

   
    public function upazila()
    {
        return $this->hasOne('App\District','id','upazila_id');
    }
    public function union()
    {
        return $this->hasOne('App\Union','id','area_id');
    }

}
