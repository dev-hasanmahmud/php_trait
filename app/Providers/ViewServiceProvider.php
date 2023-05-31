<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Permission;
use App\PermissionRole;
use Auth;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view) {
            $user = Auth::user();
            $role_permission =array();
            $permission=array();
            if(!is_null($user) && ($user->role != 1)) {
                $role_permission = PermissionRole::with('permissions')->where('role_id', $user->role)->get();
                if(!empty($role_permission))
                {
                    foreach ($role_permission as $r)
                    {
                        $permission[$r->permissions->name]=1;
                    }
                }
            }else{
                $role_permission = Permission::get();
                if(!empty($role_permission))
                {
                    foreach ($role_permission as $r)
                    {
                        $permission[$r->name]=1;
                    }
                }
            }

            //dd($permission);

            $arr['permission'] = $permission;
            //$arr['goals'] = Goal::getGoals();
            $view->with($arr);
        });
    }
}
