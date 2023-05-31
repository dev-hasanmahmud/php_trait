<?php

namespace App\Http\Controllers\Admin;
use App\Department;
use App\Validator\validatorForm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'name'         => 'required',
        'is_department'=> 'required',
       
    );
    public function index()
    {
        $departments = Department::latest()->paginate(20);
        return view('admin.department.index',compact('departments'));
    }

   
    public function create()
    {
       
        return view('admin.department.create');
    }

    
    public function store(Request $request)
    {
        // dd($request->all());
        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            //dd($request->all());
            $department = new Department();
            $department->name= $request->name;
            $department->address= $request->address;
            $department->contact_no= $request->contact_no;
            $department->is_department= $request->is_department;

            $department->save();
            
            return redirect('/department')->with('toast_success','Department Created Successfully.');
        }
        return back()->with('toast_error', $response);
    }

    public function edit( $id)
    {
        $department = Department::findOrFail($id);
        return view('admin.department.edit',compact('department'));
    }

    
    public function update(Request $request, $id)
    {
        //return dd($id);
        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $department = Department::find($id);
            $department->name= $request->name;
            $department->address= $request->address;
            $department->contact_no= $request->contact_no;
            $department->is_department= $request->is_department;

            $department->save();
            
            return redirect('/department')->with('toast_success','Department Updated Successfully.');
        }
        return back()->with('toast_error', $response);
    }

    public function show($id)
    {
        
    }
    
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        //$this->authorize('delete',$source);
        $department->delete();
    
      
        return redirect('/department')->with('toast_success','Department Deleted Successfully.');
        

    }
}
