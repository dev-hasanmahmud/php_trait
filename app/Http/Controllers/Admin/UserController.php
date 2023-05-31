<?php

namespace App\Http\Controllers\Admin;
use Hash;
use App\Role;
use App\User;
use App\Designation;
use App\Contactor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('userDesignation','userRole')->latest()->paginate(20);
        //return $users;
        return view('admin.user.index',compact('users'));
    }


    public function create()
    {
        $designations = Designation::all();
        $role         = Role::all();
        $teams        = \App\Team::all();
        return view('admin.user.create',compact('designations','role','teams'));
    }


    public function store(Request $request)
    {
        //dd($request->toArray());
         $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'designation' => 'required',
            'status' => 'required',
            'password' => 'required|confirmed|min:6',
            'role' => 'required',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->designation = $request->designation;
        $user->password = Hash::make($request->password);
        $user->address = $request->address;
        $user->role = $request->role;
        $user->status = $request->status;
        if($request->is_consultant){
            $user->is_consultant= $request->is_consultant;
        }
        else{
            $user->is_consultant=0;
        }
        if($request->teamlead_id){
            $user->teamlead_id= $request->teamlead_id;
        }
        else{
            $user->teamlead_id=0;
        }

        $user->save();
        return redirect()->route('user.index')
               ->with('toast_success','User created Successfully.');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $user         = User::find($id);
        $designations = Designation::all();
        $role         = Role::all();
        $teams        = \App\Team::all();
        //return $user;
        return view('admin.user.edit',compact('designations','user','role','teams'));
    }


    public function update(Request $request, $id)
    {
        //dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'designation' => 'required',
            'status' => 'required',
            'role' => 'required',
        ]);
        if ($request->input('password')) {
            $this->validate($request, [
            'password' => 'required|confirmed|min:6',
            ]);
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->designation = $request->designation;
        if($request->input('password'))
        {

            $user->password = Hash::make($request->input('password'));
        }

        $user->address = $request->address;
        $user->role = $request->role;
        $user->status = $request->status;
        if($request->is_consultant){
             $user->is_consultant= $request->is_consultant;
        }
        else{
            $user->is_consultant=0;
        } 
        
        if($request->teamlead_id){
            $user->teamlead_id= $request->teamlead_id;
        }
        else{
            $user->teamlead_id=0;
        }
        $user->save();
        return redirect()->route('user.index')
               ->with('toast_success','User updated Successfully.');
    }


    public function destroy($id)
    {
        $user= User::find($id);
        $user->delete();
        return redirect()->route('user.index')
               ->with('toast_success','User Deleted Successfully.');
    }
}
