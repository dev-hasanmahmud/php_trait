<?php

namespace App\Http\Controllers\Admin;

use App\ActivityCategory;
use App\ActivityIndicator;
use App\Component;
use App\data_input_title;
use App\Http\Controllers\Controller;
use App\Validator\validatorForm;
use Illuminate\Http\Request;

class ActivityIndicatorController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'title' => 'required',

        'component_id' => 'required',

    );
    public function index()
    {

        //$activity_indicators = ActivityIndicator::latest()->paginate(20);
        $data_input_titles = data_input_title::with('component')->latest()->paginate(20);
        // return $data_input_titles;
        return view('admin.activityindicator.index', compact('data_input_titles'));
    }

    public function create()
    {
        $components = Component::where('type_id', '!=', 1)->select('id', 'package_no', 'name_en')->get();
        $activity_categories = ActivityCategory::all();
        return view('admin.activityindicator.create', compact('components', 'activity_categories'));
    }

    public function store(Request $request)
    {
        $response = $this->validationWithJson($request->all(), $this->rules);
        if ($response === true) {
            $activity_indicator = $this->getFormData($request->all(), $this->rules);
            //dd($source_of_fund);
            data_input_title::create($activity_indicator);

            return redirect('/activityindicator')->with('toast_success', 'Activity Indicator Created Successfully.');
        }
        return back()->with('toast_error', $response);

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data_input_title = data_input_title::find($id);
        $components = Component::all();
        // $activity_categories = ActivityCategory::all();
        return view('admin.activityindicator.edit', compact('components', 'data_input_title'));
    }

    public function update(Request $request, $id)
    {
        //dd('ok');
        $response = $this->validationWithJson($request->all(), $this->rules);
        //dd($request->all());

        if ($response === true) {

            $activity_indicator = $this->getFormData($request->all(), $this->rules);
            data_input_title::updateOrCreate(['id' => $id], $activity_indicator);

            return redirect('/activityindicator')->with('toast_success', 'Activity  Updated Successfully.');
        }
        return back()->with('toast_error', $response);

    }

    public function destroy($id)
    {
        $activity_indicator = data_input_title::findOrFail($id);
        $activity_indicator->delete();
        return redirect('/activityindicator')->with('toast_success', 'Activity Indicator Deleted Successfully.');
    }

    public function get_active_indicator($id)
    {
        $indicator = ActivityIndicator::where('component_id', $id)->get();
        return $this->responseWithSuccess('message', $indicator);
    }
}