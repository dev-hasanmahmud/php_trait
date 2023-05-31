<?php

namespace App\Http\Controllers\Admin;
use App\Component;
use App\ActivityIndicator;
use App\ActivityIndicatorData;
use App\Validator\validatorForm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityIndicatordataControlller extends Controller
{
    use validatorForm;
    protected $rules = array(
        'activity_indicator_id'         => 'required|numeric',
        'component_id'                  => 'required|numeric',
        'value'                         => 'required',
        
    );
    public function index()
    {
        $activity_indicators_data = ActivityIndicatorData::with('activityindicator','component')->latest()->paginate(20);
        return view('admin.activityindicatordata.index',compact('activity_indicators_data'));
    }

   
    public function create()
    {
        $activity_indicators = ActivityIndicator::all();
        $components = Component::all();
        return view('admin.activityindicatordata.create',compact('activity_indicators','components'));
    }

    
    public function store(Request $request)
    {
        //return dd($request->all());
        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $activity_indicator_data = $this->getFormData($request->all(),$this->rules);
            //dd($source_of_fund);
            ActivityIndicatorData::create($activity_indicator_data);
            
            return redirect('/activity-indicator-data')->with('toast_success','Activity Indicator Data Created Successfully.');
        }
        return back()->with('toast_error', $response);
    }

    public function edit( $id)
    {
        $activity_indicator_data = ActivityIndicatorData::findOrFail($id);
        $activity_indicators = ActivityIndicator::where('component_id',$activity_indicator_data->component_id)->get();
        //return $activity_indicators;
        $components = Component::all();
        return view('admin.activityindicatordata.edit',compact('activity_indicator_data','activity_indicators','components'));
    }

    
    public function update(Request $request, $id)
    {
        //return dd($id);
        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $activity_indicator_data = $this->getFormData($request->all(),$this->rules);
            ActivityIndicatorData::updateOrCreate(['id'=>$id],$activity_indicator_data); 
            
            return redirect('/activity-indicator-data')->with('toast_success','Activity Indicator Data Updated Successfully.');
        }
        return back()->with('toast_error', $response);
    }

    public function show($id)
    {
        
    }
    
    public function destroy($id)
    {
        $activity_indicator_data = ActivityIndicatorData::findOrFail($id);
        //$this->authorize('delete',$source);
        $activity_indicator_data->delete();
    
      
        return redirect('/activity-indicator-data')->with('toast_success','Indicator Data Deleted Successfully.');
        

    }
}
