<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Source_of_fund;
use App\Type;
use App\Validator\validatorForm;
use Illuminate\Http\Request;

class SourceOfFundController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'name_en' => 'required|min:3',
        'name_bn' => 'nullable',
        'type_id' => 'required',
    );
    public function index()
    {
        $source_of_fund = Source_of_fund::latest()->paginate(20);
        $type = Type::all()->toArray();

        $ln = count($type);
        $unit_data = $source_of_fund->toArray();
        $unit_data = $unit_data['data'];
        $ln_u = count($unit_data);
        $ln2 = 0;
        for ($i = 0; $i < $ln_u; $i++) {
            $id = array();
            $id = json_decode($unit_data[$i]['type_id']);
            $unit_data[$i]['name'] = '';
            if ($id != '0') {
                $id = (array) $id;
                $ln2 = count($id);
            }
            for ($k = 0; $k < $ln2; $k++) {
                for ($j = 0; $j < $ln; $j++) {
                    if ($id[$k] == $type[$j]['id']) {
                        $unit_data[$i]['name'] = $type[$j]['name_en'] . ' , ' . $unit_data[$i]['name'];
                        break;
                    }
                }
            }
        }
        return view('admin.source_of_fund.index', compact('source_of_fund', 'unit_data'));
    }

    public function create()
    {
        return view('admin.source_of_fund.create');
    }

    public function store(Request $request)
    {
        $response = $this->validationWithJson($request->all(), $this->rules);
        if ($response === true) {
            $source_of_fund = $this->getFormData($request->all(), $this->rules);
            //dd($source_of_fund);
            $source_of_fund['type_id'] = json_encode($source_of_fund['type_id'], true);
            Source_of_fund::create($source_of_fund);

            return redirect('/source_of_fund')->with('toast_success', 'Source of fund Created Successfully.');
        }
        return back()->with('toast_error', $response);
    }

    public function edit($id)
    {
        $source = Source_of_fund::findOrFail($id);
        return view('admin.source_of_fund.edit', compact('source'));
    }

    public function update(Request $request, $id)
    {
        //return dd($id);

        $response = $this->validationWithJson($request->all(), $this->rules);
        if ($response === true) {
            $source_of_fund = $this->getFormData($request->all(), $this->rules);
            $source_of_fund['type_id'] = json_encode($source_of_fund['type_id'], true);
            Source_of_fund::updateOrCreate(['id' => $id], $source_of_fund);

            return redirect('/source_of_fund')->with('toast_success', 'Source of fund Updated Successfully.');
        }
        return back()->with('toast_error', $response);
    }

    public function show($id)
    {

    }

    public function destroy($id)
    {
        //return $id;
        $source = Source_of_fund::findOrFail($id);
        //$this->authorize('delete',$source);
        //return 'hello';
        $source->delete();
        return $this->responseWithSuccess('Data Deleted successfully', 'success');
        //return redirect('/source_of_fund')->with('toast_success','Source of fund Deleted Successfully.');

    }
}