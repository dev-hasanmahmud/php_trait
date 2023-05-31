<?php

namespace App\Http\Controllers\Admin;

use App\Component;
use App\Indicator;
use App\Indicator_data;
use App\PermissionRole;
use App\Disapprove_details;
use Illuminate\Http\Request;
use App\Validator\validatorForm;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndicatorDataController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'indicator_id'         => 'required|numeric',
        'component_id'         => 'required|numeric',
        'progress_value'       => 'nullable|numeric',
        'achievement_quantity' => 'required|numeric',
        'details'              => 'nullable',
        'date'                 => 'nullable|date|date_format:Y-m-d',
    );
    public function index(Request $request)
    {
        $user       = Auth::user();
        $permission = PermissionRole::where('role_id',$user->role)->where('permission_id',174)->get();

        if($user->role !=1 && !$permission->isEmpty()){
            $package = Component::latest()->get();
            $indicator_data = Indicator_data::with('indicator','component')->where('created_by',$user->id)->latest()->paginate(20);
            $is_filter=0;
            $search [0] = $request->indicator_name;;
            $search [1]    = $request->package_id;

            if($request->package_id || $request->indicator_name ){
                $is_filter=1;
                $indicator_name = $request->indicator_name;
                $package_id     = $request->package_id;
                $indicator_data = DB::table('indicator_datas as in_d')->where('in_d.component_id',$package_id)
                    ->where('in_d.created_by',$user->id)
                    ->leftJoin('components as c', 'c.id', '=', 'in_d.component_id')
                    ->leftJoin('indicators  as i', 'i.id', '=', 'in_d.indicator_id')
                    ->where('i.name_en', 'LIKE', "%{$indicator_name}%")
                    ->select('in_d.*','c.name_en as package_name','c.package_no','i.name_en as indicator_name')
                    ->paginate(30);  
            }
        }else{
            $package = Component::latest()->get();
            $indicator_data = Indicator_data::with('indicator','component')->latest()->paginate(20);
            $is_filter=0;
            $search [0] = $request->indicator_name;;
            $search [1]    = $request->package_id;
            if($request->package_id || $request->indicator_name ){
                $is_filter=1;
                $indicator_name = $request->indicator_name;
                $package_id     = $request->package_id;
                $indicator_data = DB::table('indicator_datas as in_d')->where('in_d.component_id',$package_id)
                ->leftJoin('components as c', 'c.id', '=', 'in_d.component_id')
                ->leftJoin('indicators  as i', 'i.id', '=', 'in_d.indicator_id')
                ->where('i.name_en', 'LIKE', "%{$indicator_name}%")
                ->select('in_d.*','c.name_en as package_name','c.package_no','i.name_en as indicator_name')
                ->paginate(30);
            }
        }
        //dd($indicator_data);
        return view('admin.indicator_data.index',compact('indicator_data','package','is_filter','search'));
    }

   
    public function create()
    {
        $indicator = Indicator::get();
        $component = Component::all();
        return view('admin.indicator_data.create',compact('indicator','component'));
    }

    
    public function store(Request $request)
    {
        //return dd($request->all());
        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $indicator_data = $this->getFormData($request->all(),$this->rules);
            $indicator_data['created_by'] = Auth::user()->id;
            //dd($indicator_data);
            Indicator_data::create($indicator_data);
            
            return redirect('/indicator_data')->with('toast_success','Indicator Data Created Successfully.');
        }
        return back()->with('toast_error', $response);
    }

    public function edit( $id)
    {   
        $user       = Auth::user();
        $permission = PermissionRole::where('role_id',$user->role)->where('permission_id',174)->get();
        $indicator_data = Indicator_data::findOrFail($id);

        if($user->role !=1 && !$permission->isEmpty() && $user->id != $indicator_data->created_by ){
            return redirect('/indicator_data')->with('toast_success','You are not allowed to edit this data.');
        }

        
        $indicator = Indicator::where('component_id',$indicator_data->component_id)->get();
        $component = Component::all();
        $data = $this->indicator_progress($indicator_data->indicator_id,true);
        //dd($data);
        $target       = $data[1];
        $pending_data = $data[2];
        $approve_data = $data[0];
        //dd($pending_data);
        if($data[2] !=null && $indicator_data->is_approve==1){
            $remain_target = $target-$data[0][0]->qty - $pending_data[0]->qty + $indicator_data->achievement_quantity;
            $percentange   = $data[0][0]->progress + $pending_data[0]->progress - $indicator_data->progress_value;
            //dd($data);
            $approve_data[0]->qty      -= $indicator_data->achievement_quantity;
            $approve_data[0]->progress -= $indicator_data->progress_value;   
        }
        else if($data[0] !=null && $indicator_data->is_approve==0 ){
            $remain_target = $target-$data[0][0]->qty - $pending_data[0]->qty + $indicator_data->achievement_quantity;
            $percentange   = $data[0][0]->progress + $pending_data[0]->progress - $indicator_data->progress_value;
            $pending_data[0]->qty      -= $indicator_data->achievement_quantity;
            $pending_data[0]->progress -= $indicator_data->progress_value;
        }
        else if($data[0] ==null && $indicator_data->is_approve==0){
            $remain_target = $target - $pending_data[0]->qty + $indicator_data->achievement_quantity;
            $percentange   = $pending_data[0]->progress - $indicator_data->progress_value;
           // dd($pending_data);
            $pending_data[0]->qty      -= $indicator_data->achievement_quantity;
            $pending_data[0]->progress -= $indicator_data->progress_value;
        }
        else{
            $remain_target = $target-$data[0][0]->qty + $indicator_data->achievement_quantity;
            $percentange   = $data[0][0]->progress - $indicator_data->progress_value;
            $approve_data[0]->qty      -= $indicator_data->achievement_quantity;
            $approve_data[0]->progress -= $indicator_data->progress_value;  
        }
        return view('admin.indicator_data.edit',compact('indicator_data','pending_data','approve_data','indicator','component','target','remain_target','percentange'));
    }

    
    public function update(Request $request, $id)
    {
        //return dd($id);
        //$data             = Indicator_data::find($id);
        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $indicator_data = $this->getFormData($request->all(),$this->rules);
            $indicator_data['created_by'] = Auth::user()->id;
            Indicator_data::updateOrCreate(['id'=>$id],$indicator_data); 
            
            return redirect('/indicator_data?package_id='.$indicator_data['component_id'])->with('toast_success','Indicator Category Updated Successfully.');
        }
        return back()->with('toast_error', $response);
    }

    public function show($id)
    {
        $user       = Auth::user();
        $permission = PermissionRole::where('role_id',$user->role)->where('permission_id',174)->get();
        if($user->role !=1 && !$permission->isEmpty() ){
            $data             = Indicator_data::with('indicator','component','user','data_add_user')->find($id);
            if( $user->id != $data->created_by ){
                return redirect('/indicator_data')->with('toast_success','You are not allowed to see this data.');
            }
            $dissapprove_data = Disapprove_details::where('table_id',1)->where('indicator_data_id',$data->id)->first();
        }else{
            $data             = Indicator_data::with('indicator','component','user','data_add_user')->find($id);
            $dissapprove_data = Disapprove_details::where('table_id',1)->where('indicator_data_id',$data->id)->first();
        }
        //dd($data);
        return view('admin.indicator_data.show',compact('data','dissapprove_data'));
    }
    
    public function destroy(Request $request,$id)
    {
        //dd($request->all());
        $source = Indicator_data::findOrFail($id);
        //$this->authorize('delete',$source);
        $source->delete();
    
        return $this->responseWithSuccess('Data Deleted successfully','success');
        //return redirect('/indicator_data')->with('toast_success','Indicator Data Deleted Successfully.');
        

    }
    /*indicaor edit and create page for indicator progreess details */
    public function indicator_progress($id,$is_class=null)
    {
        $indicator_id= $id;
        $indicator_details = DB::select("SELECT indicator_id,SUM(progress_value) AS progress,SUM(achievement_quantity) AS qty FROM `indicator_datas`
        WHERE ( indicator_id IN ($id)
        AND is_approve=1)
        GROUP BY indicator_id");

        $pending_data = DB::select("SELECT indicator_id,SUM(progress_value) AS progress,SUM(achievement_quantity) AS qty FROM `indicator_datas`
        WHERE ( indicator_id IN ($id)
        AND is_approve=0)
        GROUP BY indicator_id");
        //$indicator_details= Indicator_data::with('indicator')->where('indicator_id',$indicator_id)->where('is_approve',1)->get();
        //dd($indicator_details);
        $indicator_target = Indicator::find($id);
        //return view('admin.indicator_data.table',compact('indicator_details','indicator_target'));
        $data[0]=$indicator_details;
        $data[1]=$indicator_target->target;
        $data[2]=$pending_data;
        if($is_class) return $data;
        return $this->responseWithSuccess('Data Deleted successfully',$data);
    }
}
