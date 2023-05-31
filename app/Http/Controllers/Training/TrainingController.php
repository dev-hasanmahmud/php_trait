<?php

namespace App\Http\Controllers\Training;


use App\Training;
use Illuminate\Http\Request;
use App\Validator\validatorForm;
use App\Http\Controllers\Controller;

class TrainingController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'title'                 => 'required',
        'training_category_id'  => 'nullable|numeric',
        'serial_number'         => 'required',
        'total_event'           => 'nullable|numeric',
        'toatal_batch'          => 'nullable|numeric',
    );
    public function index()
    {
        $training = Training::with('trainingcategory')->latest()->paginate(20);
        //return $training;
        return view('training.training.index',compact('training'));
    }

   
    public function create()
    {
        // $indicator = Indicator::get();
       // $categories = Component::all();
        return view('training.training.create');
    }

    
    public function store(Request $request)
    {
        //dd($request->all());
        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $training = $this->getFormData($request->all(),$this->rules);
            //dd($source_of_fund);
            Training::create($training);
            
            return redirect('/training')->with('toast_success','Training data save Successfully.');
        }
        return back()->with('toast_error', $response)->withInput();
    }

    public function edit( $id)
    {
        $training = Training::findOrFail($id);
        return view('training.training.edit',compact('training'));
    }

    
    public function update(Request $request, $id)
    {
        //return dd($request->all());
        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $training = $this->getFormData($request->all(),$this->rules);
            Training::updateOrCreate(['id'=>$id],$training); 
            
            return redirect('/training')->with('toast_success','Training Data  Updated Successfully.');
        }
        return back()->with('toast_error', $response)->withInput();
    }

    public function show($id)
    {
        
    }
    
    public function destroy($id)
    {
        $source = Training::findOrFail($id);
        //$this->authorize('delete',$source);
        $source->delete();
        return $this->responseWithSuccess('Data Deleted successfully','success');
        
    }

    

}
