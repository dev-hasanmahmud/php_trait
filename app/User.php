<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //use LaratrustUserTrait;
    //use Notifiable;
    use LaratrustUserTrait , HasApiTokens, Notifiable;

    protected $table='users';

    protected $fillable = [
        'name', 'email', 'password','designation','address','role','status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function userDesignation()
    {
        return $this->belongsTo('App\Designation','designation','id');
    }

    public function userRole()
    {
        return $this->belongsTo('App\Role','role','id');
    }
}
