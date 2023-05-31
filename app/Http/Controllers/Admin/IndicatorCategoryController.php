<?php

namespace App\Http\Controllers\Admin;

use App\Indicator_category;
use Illuminate\Http\Request;
use App\Validator\validatorForm;
use App\Http\Controllers\Controller;

class IndicatorCategoryController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'name_en'         => 'required|min:3',
        'name_bn'         => 'nullable',
        'description'     => 'nullable',
    );
    public function index()
    {
        $indicator_category = Indicator_category::latest()->paginate(20);
        return view('admin.indicator_category.index',compact('indicator_category'));
    }

   
    public function create()
    {
        return view('admin.indicator_category.create');
    }

    
    public function store(Request $request)
    {
       // return dd($request->all());
        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $indicator_category = $this->getFormData($request->all(),$this->rules);
            //dd($source_of_fund);
            Indicator_category::create($indicator_category);
            
            return redirect('/indicator_category')->with('toast_success','Indicator Category Created Successfully.');
        }
        return back()->with('toast_error', $response);
    }

    public function edit( $id)
    {
        $Indicator_category = Indicator_category::findOrFail($id);
        return view('admin.indicator_category.edit',compact('Indicator_category'));
    }

    
    public function update(Request $request, $id)
    {
        //return dd($id);

        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $indicator_category = $this->getFormData($request->all(),$this->rules);
            Indicator_category::updateOrCreate(['id'=>$id],$indicator_category); 
            
            return redirect('/indicator_category')->with('toast_success','Indicator Category Updated Successfully.');
        }
        return back()->with('toast_error', $response);
    }

    public function show($id)
    {
        
    }
    
    public function destroy($id)
    {
        $source = Indicator_category::findOrFail($id);
        //$this->authorize('delete',$source);
        //return 'hello';
        $source->delete();
        return redirect('/indicator_category')->with('toast_success','Indicator Category Deleted Successfully.');
    }
}
