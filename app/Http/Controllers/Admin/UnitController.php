<?php

namespace App\Http\Controllers\Admin;
use App\Type;
use App\Unit;
use App\Proc_method;
use Illuminate\Http\Request;
use App\Validator\validatorForm;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'name_en' => 'required',
        'name_bn' => 'nullable',
        'type_id' => 'nullable'
    );
    
    public function index()
    {
        $units = Unit::with('types')->latest()->paginate(20);
        $type = Type::all()->toArray();
        
        $ln = count($type);
        $unit_data = $units->toArray();
        $unit_data = $unit_data['data'];
        $ln_u = count($unit_data);
        $ln2 = 0;
       // dd($unit_data);
        for($i=0;$i<$ln_u;$i++){
            $id = array();
            $id = json_decode($unit_data[$i]['type_id']);
            $unit_data[$i]['name']='';
            if( $id!=null ){
                $ln2 = count($id);
            }
            for($k=0;$k<$ln2;$k++){
                for($j=0;$j<$ln;$j++){
                    if($id[$k]==$type[$j]['id']){
                        $unit_data[$i]['name'] = $type[$j]['name_en'].'  '.$unit_data[$i]['name'];
                        break;
                    }
                }
            }  
        }

       // dd($unit_data[1]['name']);
       //dd($unit_data);
        //$units['data']=$unit_data;
        //dd($units);
        return view('admin.unit.index',compact('units','unit_data'));
    }

    public function create()
    {
        return view('admin.unit.create');
    }

    public function store(Request $request)
    {

        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $unit = $this->getFormData($request->all(),$this->rules);
            $unit['type_id'] = json_encode($unit['type_id'],true);
           // dd($unit);
            Unit::create($unit);
            return redirect('/unit')->with('toast_success','Unit created Successfully.');
        }
        return back()->with('toast_error', $response)->withInput();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $unit= Unit::find($id);
        return view('admin.unit.edit',compact('unit'));
    }

   
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $unit = $this->getFormData($request->all(),$this->rules);
            $unit['type_id'] = json_encode($unit['type_id'],true);
           // dd($unit);
            Unit::updateOrCreate(['id'=>$id],$unit);
            return redirect('/unit')->with('toast_success','Unit updated Successfully.');
        }
        return back()->with('toast_error', $response)->withInput();
    }

    public function destroy($id)
    {
        $unit= Unit::find($id);
        $unit->delete();
        return redirect()->route('unit.index')
               ->with('toast_success','Unit Deleted Successfully.');
    }

    function get_unit($id){
        
        $id = (string) $id;
        $unit = DB::table('units')->whereJsonContains('type_id', $id)->get();
        $p = DB::table('proc_methods')->whereJsonContains('type_id', $id)->get();
        $s = DB::table('source_of_funds')->whereJsonContains('type_id', $id)->get();

        $data = array();
        $data['unit'] = $unit;
        $data['method'] = $p;
        $data['source'] = $s;

        return $this->responseWithSuccess('message',$data);
    }
}