<?php

namespace App\Http\Controllers\Admin;

use App\Camp;
use App\Http\Controllers\Controller;
use App\Validator\validatorForm;
use Illuminate\Http\Request;

class CampController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'code' => 'required',
        'name_en' => 'required|min:3',
        'name_bn' => 'nullable',

    );
    public function index()
    {
        $camp = Camp::latest()->paginate(20);
        return view('admin.camp.index', compact('camp'));
    }

    public function create()
    {

        return view('admin.camp.create');
    }

    public function store(Request $request)
    {

        // $sql = "DELETE FROM 'camps' where id=5";
        // return dd($request->all());
        $response = $this->validationWithJson($request->all(), $this->rules);
        if ($response === true) {
            $camp = $this->getFormData($request->all(), $this->rules);
            //dd($source_of_fund);
            Camp::create($camp);

            return redirect('/camp')->with('toast_success', 'Camp Created Successfully.');
        }
        return back()->with('toast_error', $response);
    }

    public function edit($id)
    {
        $camp = Camp::findOrFail($id);
        return view('admin.camp.edit', compact('camp'));
    }

    public function update(Request $request, $id)
    {
        //return dd($id);
        $response = $this->validationWithJson($request->all(), $this->rules);
        if ($response === true) {
            $camp = $this->getFormData($request->all(), $this->rules);
            Camp::updateOrCreate(['id' => $id], $camp);

            return redirect('/camp')->with('toast_success', 'Camp Updated Successfully.');
        }
        return back()->with('toast_error', $response);
    }

    public function show($id)
    {

    }

    public function destroy($id)
    {
        $source = Camp::findOrFail($id);
        //$this->authorize('delete',$source);
        $source->delete();

        return $this->responseWithSuccess('Data Deleted successfully', 'success');
        //return redirect('/camp')->with('toast_success','Camp Deleted Successfully.');

    }
}