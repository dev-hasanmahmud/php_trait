<?php

namespace App\Http\Controllers\Admin;
use App\Designation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
  
    public function index()
    {
        $designations = Designation::latest()->paginate(20);
        return view('admin.designation.index',compact('designations'));
    }

    
    public function create()
    {
        return view('admin.designation.create');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required',
            'name_bn' => 'required',
        ]);
        //dd($request->all());
        Designation::create($request->all());
   
        return redirect()->route('designation.index')
               ->with('toast_success','Designation created Successfully.'); 
    }

  
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $designation= Designation::find($id);
        return view('admin.designation.edit',compact('designation'));
    }

   
    public function update(Request $request, $id)
    {
        $designation= Designation::find($id);
        
        $request->validate([
            'name_en' => 'required',
            'name_bn' => 'required',
        ]);

        $designation->update($request->all());

        return redirect()->route('designation.index')
               ->with('toast_success','Designation Updated Successfully.');
    }

   
    public function destroy($id)
    {
        
        $designation= Designation::find($id);
        $designation->delete();
        return redirect()->route('designation.index')
               ->with('toast_success','Designation Deleted Successfully.');
    }
}
