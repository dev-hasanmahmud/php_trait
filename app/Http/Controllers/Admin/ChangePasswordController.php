<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class ChangePasswordController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.user.changePassword');
    }

    public function store(Request $request)
    {
     $this->validate($request, [
        'old_password'     => 'required',
        'new_password'     => 'required|min:6',
        'confirm_password' => 'required|same:new_password',
    ]);
 
    $data = $request->all();
  
    $user = User::find(auth()->user()->id);
 
    if(!\Hash::check($data['old_password'], $user->password)){
 
         return back()->with('toast_error','Your have entered wrong password');
 
    }else{
 
         $user->update(['password'=> Hash::make($request->new_password)]);
        return redirect('/dashboard')->with('toast_success','Your Password changed successfully.');
 
    }
       
    }
}
