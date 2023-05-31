<?php

namespace App\Http\Controllers\Admin;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::latest()->paginate(20);
        return view('admin.role.index',compact('roles'));
    }

    
    public function create()
    {
        return view('admin.role.create');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
			'display_name' => 'required'
        ]);
        //dd($request->all());
        Role::create($request->all());
   
        return redirect()->route('role.index')
               ->with('toast_success','Role created Successfully.'); 
    }

  
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $role= Role::find($id);
        return view('admin.role.edit',compact('role'));
    }

   
    public function update(Request $request, $id)
    {
        $role= Role::find($id);
        $request->validate([
            'name' => 'required',
			'display_name' => 'required'
        ]);

        $role->update($request->all());

        return redirect()->route('role.index')
               ->with('toast_success','Role Updated Successfully.');
    }

   
    public function destroy($id)
    {
        
        $role= Role::find($id);
        $role->delete();
        return redirect()->route('role.index')
               ->with('toast_success','Role Deleted Successfully.');
    }
}
