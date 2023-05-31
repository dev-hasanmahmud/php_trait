<?php

namespace App\Http\Controllers\Admin;
use App\Approving_authority;
use App\Http\Controllers\Controller;
use App\Validator\validatorForm;
use Illuminate\Http\Request;

class ApproveAuthorityController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'name_en'               => 'required|min:3',
        'name_bn'               => 'required',
    );
    public function index()
    {
        
        $approve_authorities = Approving_authority::latest()->paginate(20);
        return view('admin.aprroveauthotities.index',compact('approve_authorities'));
    }

   
    public function create()
    {
        return view('admin.aprroveauthotities.create');
    }

  
    public function store(Request $request)
    {
      $response = $this->validationWithJson($request->all(),$this->rules);
        //dd($request->all());
        if($response===true){
            $authority = $this->getFormData($request->all(),$this->rules);
            Approving_authority::create($authority);
            return redirect('/aprroveauthotities')->with('toast_success','Authority Created Successfully.');
        }
         return back()->with('toast_error', $response);  
    }

  
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $authority= Approving_authority::find($id);
        return view('admin.aprroveauthotities.edit',compact('authority'));
    }

  
    public function update(Request $request, $id)
    {
        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $authority = $this->getFormData($request->all(),$this->rules);
            Approving_authority::updateOrCreate(['id'=>$id],$authority); 
            
            return redirect('/aprroveauthotities')->with('toast_success','Authority Updated Successfully.');
        }
        return back()->with('toast_error', $response);

    }

   
    public function destroy($id)
    {
        $authority= Approving_authority::findOrFail($id);
        $authority->delete();
        return redirect('/aprroveauthotities')->with('toast_success','Authority Deleted Successfully.');
    }
}
