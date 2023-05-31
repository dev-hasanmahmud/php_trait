<?php

namespace App\Http\Controllers\Admin;
use App\Permission;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\PermissionRole;

class PermisionRoleController extends Controller
{
    public function index(Request $request)
    {
       $role_id=$request->role_id;
       $role_details=Role::find($role_id);
       $permissions = Permission::orderBy('description')->get();
       $role_permission_query=PermissionRole::select('permission_id')->where('role_id',$role_id)->get();
       $role_permission=[];
       foreach($role_permission_query as $r)
       {
            $role_permission[$r->permission_id]=1;
       }
       //dd($role_permission);

       return view('admin.role.user_permision',compact('permissions','role_details','role_permission'));
    }

    public function update_permision(Request $request,$id)
    {
        //dd($request->all());
      DB::table('permission_role')->where('role_id', $id)->delete();
      $role = Role::findOrFail($id);
      $role->syncPermissions($request->permissions);

      // $role->syncPermissions($request->permissions);

      return redirect()->route('role.index')->with('toast_success','User Permission updated Successfully.');
    }

}
