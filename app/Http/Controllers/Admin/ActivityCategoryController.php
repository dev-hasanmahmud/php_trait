<?php

namespace App\Http\Controllers\Admin;

use App\ActivityCategory;
use App\Component;
use App\Http\Controllers\Controller;
use App\Validator\validatorForm;
use Illuminate\Http\Request;

class ActivityCategoryController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'name_en' => 'required|min:3',
        'name_bn' => 'nullable|min:3',
        'component_id' => 'required',
    );
    public function index()
    {

        $activity_categories = ActivityCategory::latest()->paginate(20);
        return view('admin.activitycategory.index', compact('activity_categories'));
    }

    public function create()
    {
        $components = Component::all();
        return view('admin.activitycategory.create', compact('components'));
    }

    public function store(Request $request)
    {

        //dd($request->all());
        $response = $this->validationWithJson($request->all(), $this->rules);
        if ($response === true) {
            $activity_category = $this->getFormData($request->all(), $this->rules);
            //dd($source_of_fund);
            ActivityCategory::create($activity_category);

            return redirect('/activitycategory')->with('toast_success', 'Activity Category Created Successfully.');
        }
        return back()->with('toast_error', $response);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $activity_category = ActivityCategory::find($id);
        $components = Component::all();
        return view('admin.activitycategory.edit', compact('activity_category', 'components'));
    }

    public function update(Request $request, $id)
    {
        $response = $this->validationWithJson($request->all(), $this->rules);
        if ($response === true) {
            $activity_category = $this->getFormData($request->all(), $this->rules);
            ActivityCategory::updateOrCreate(['id' => $id], $activity_category);

            return redirect('/activitycategory')->with('toast_success', 'Activity Category Updated Successfully.');
        }
        return back()->with('toast_error', $response);

    }

    public function destroy($id)
    {
        $activity_category = ActivityCategory::find($id);
        $activity_category->delete();
        return redirect('/activitycategory')->with('toast_success', 'Activity Category Deleted Successfully.');
    }
}