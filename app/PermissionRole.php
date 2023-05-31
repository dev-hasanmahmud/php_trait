<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    Protected $table='permission_role';
    Protected $fillable=['permission_id','role_id'];
    public $timestamps = false;

    public function permissions(){
        return $this->hasOne('App\Permission','id','permission_id');
    }
}
