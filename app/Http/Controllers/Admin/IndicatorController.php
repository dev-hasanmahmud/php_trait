<?php

namespace App\Http\Controllers\Admin;

use App\Component;
use App\Indicator;
use App\Indicator_category;
use Illuminate\Http\Request;
use App\Validator\validatorForm;
use App\Http\Controllers\Controller;
use DB;

class IndicatorController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'name_en'               => 'required|min:3',
        'name_bn'               => '',
        'indicator_category_id' => 'required|numeric',
        'component_id'          => 'required|numeric',
        'target'                => 'required|numeric',
        'ave_weightage'         => 'nullable|numeric',
    );
    public function index(Request $request)
    {
        $indicator = Indicator::with('component','indicator_category')->latest()->paginate(20);
        $package = Component::latest()->get();
        $search [1]    = $request->package_id;
        $is_filter=0;

        if($request->package_id)
		{
            $is_filter=1;;
            $package_id     = $request->package_id;
			$indicator = DB::table('indicators as in_d')->where('in_d.component_id',$package_id)
            ->leftJoin('components as c', 'c.id', '=', 'in_d.component_id')
            ->leftJoin('indicator_categories  as i', 'i.id', '=', 'in_d.indicator_category_id')
            ->where('in_d.deleted_at',null)
            ->select('in_d.*','c.name_en as package_name','c.package_no','i.name_en as category')
            ->paginate(30);
            //dd($indicator);
            
        }
        //return $indicator;
        return view('admin.indicator.index',compact('indicator','package','search','is_filter'));
    }


    public function create()
    {
        $indicator_category = Indicator_category::all();
        $component = Component::all();
        return view('admin.indicator.create',compact('indicator_category','component'));
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $indicator = $this->getFormData($request->all(),$this->rules);
            //dd($source_of_fund);
            Indicator::create($indicator);

            return redirect('/indicator')->with('toast_success','Indicator Created Successfully.');
        }
        return back()->with('toast_error', $response);
    }

    public function edit( $id)
    {
        $indicator = Indicator::findOrFail($id);
        $indicator_category = Indicator_category::all();
        $component = Component::all();

        return view('admin.indicator.edit',compact('indicator','indicator_category','component'));
    }


    public function update(Request $request, $id)
    {
        //return dd($id);
        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $indicator = $this->getFormData($request->all(),$this->rules);
            Indicator::updateOrCreate(['id'=>$id],$indicator);

            return redirect('indicator?package_id='.$indicator['component_id'])->with('toast_success','Indicator Updated Successfully.');
        }
        return back()->with('toast_error', $response);
    }

    public function show($id)
    {

    }

    public function destroy($id)
    {
        $source     = Indicator::findOrFail($id);
        $package_id = $source->component_id;
       // dd($package_id);
        //$this->authorize('delete',$source);
        //return 'hello';
        $source->delete();
        return redirect('/indicator?package_id='.$package_id)->with('toast_success','Indicator Deleted Successfully.');
    }
    public function indicator_settings()
    {
        return view('admin.indicator.indicator_settings');
    }


    /*get indicator for indivitual component for indicator data page  */

    public function get_indicator($id)
    {
        $indicator = Indicator::where('component_id',$id)->get();
        return $this->responseWithSuccess('message',$indicator);
    }
}
