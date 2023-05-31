<?php

namespace App\Http\Middleware;

use Closure;
use Route;
use Auth;
use App\PermissionRole;
use App\Permission;

class HasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if (!$user){
            return redirect('/');
        }
        if($user->role == 1)
        {
            return $next($request);
        }

      //  return dd($user->role);
        // $controllerAction = class_basename(Route::currentRouteAction());
        // //dd( $$controllerAction );
        // if($user->can($controllerAction)){
        //     return $next($request);
        // }
        // else {
        //     return redirect()->back()->with('toast_error', 'you are not allowed for this requesting page');
        // }
        $controllerAction = class_basename(Route::currentRouteAction());
        
        // if(strpos($controllerAction, 'create') || strpos($controllerAction, 'store') || strpos($controllerAction, 'update'))
        // {
        //     $controllerAction=strstr($controllerAction, '@', true);
        //     $controllerAction .='@index';

        // }
        // if(strpos($controllerAction, 'edit'))
        // {
        //     $controllerAction=strstr($controllerAction, '@', true);
        //     $controllerAction .='@index';

        // }
        // if(strpos($controllerAction, 'delete'))
        // {
        //     $controllerAction=strstr($controllerAction, '@', true);
        //     $controllerAction .='@index';

        // }

        //return dd($controllerAction);

        $permission=false;
        $permission_id_id=0;
        $permission_result = Permission::where('name',$controllerAction)->exists();
        
        //return dd($permission_result);

        $permission_id = Permission::where('name',$controllerAction)->first();

        //return dd($permission_id);

        if(!$permission_result)
        {
            $permission_id_id=0;
        }
        else{
            $permission_id_id=$permission_id->id;
        }
       // return dd($permission_id_id);
       
        $permission_data = PermissionRole::where('role_id',$user->role)->where('permission_id',$permission_id_id)->exists();
        //return dd($permission_data);
        if($permission_data)
        {
            $permission=true;
        }
        //dd($user->role);
       // dd($user->hasPermission($controllerAction));


        if($permission){
            return $next($request);
        }
        else {
           return redirect()->back()->with('toast_error', 'you are not allowed for this requesting page');
        }
    }
}
