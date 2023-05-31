<?php

namespace App\Http\Controllers\Api;

use App\Component;
use App\data_input_title;
use Illuminate\Http\Request;
use App\Validator\apiResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{
    use apiResponse;
    public function index()
    {
        $all_package = [];
        $goods= Component::where('type_id',1)->orderby('package_no')->select('id','package_no','name_en')->get();
       // dd($goods[0]->id);
        $works= Component::where('type_id',2)->orderby('package_no')->select('id','package_no','name_en')->get();
        $service= Component::where('type_id',3)->orderby('package_no')->select('id','package_no','name_en')->get();
        

        $all_package['good']   = $goods;
        $all_package['work']   = $works;
        $all_package['service'] = $service;

        return $this->responseApiWithSuccess('succeessfully',$all_package);

    }
    /*For image upload page */
    public function all_package()
    {
        $all_package = [];
        $goods = Component::whereIn('type_id',[1,2,3])->orderby('package_no')->select('id','package_no','name_en')->get();
        $title = data_input_title::latest()->select('id','title')->get();
        $all_package['package']   = $goods;
        $all_package['title']   = $title;

        return $this->responseApiWithSuccess('Package code and package name get succeessfully',$all_package);

    }


    public function package_dashboard(Request $request)
    {

        $data = [];
        $id = $request->package_id;

        // $indicator_details = DB::table('indicators as in')
        // ->where('in.component_id',$id)->where('in.indicator_category_id',1)->where('in.deleted_at',null)
        // ->leftJoinSub(function($query){
        //     $query->select(['da.indicator_id', DB::raw( 'sum(da.progress_value) as  achivement_percentage' ),DB::raw( 'sum(da.achievement_quantity) as achievement_quantity ' )])
        //         ->from('indicator_datas as da')->where('da.is_approve',1)
        //         ->groupBy(['da.indicator_id']);
        // },'at','in.id','=','at.indicator_id')
        
        // ->select('in.id','in.name_en as name','in.target','at.achievement_quantity','at.achivement_percentage')
        // ->get();

        $indicator_details = DB::query()
        ->select(['result_1.*','result_2.*'])
        ->fromSub(function($query) {
            return $query->select(['t.*'])
            ->from('indicators as t')
            ->where('t.component_id',6)->where('t.indicator_category_id',1)->where('t.deleted_at',null);
        },'result_1')
        ->leftJoinSub(function($query){
            $query->select(['da.indicator_id', DB::raw( 'sum(da.progress_value) as  achivement_percentage' ),DB::raw( 'sum(da.achievement_quantity) as achievement_quantity ' )])
                ->from('indicator_datas as da')->where('da.is_approve',1)
                ->groupBy(['da.indicator_id']);
        },'result_2','result_1.id','=','result_2.indicator_id')
        ->get();

        $details=Component::with('unit','proc_method','approving_authority')->find($id);

        $data ['package'] = $details->package_no;
        $data ['component'] = $details->name_en;

        $data ['indicator_details']=$indicator_details;
        $component = [];
        $component['package_no'] = $details->package_no;
        $component['package_description'] = $details->name_en;
        $component['unit'] = $details->unit->name_en;
        $component['quantity'] = $details->quantity;
        $component['proquerment_method'] = $details->proc_method->name_en;
        $component['approving_authority'] = $details->approving_authority->name_en;
        $component['signing_of_contract'] = $details->signing_of_contact_act;
        $component['completion_of_contract'] = $details->complition_of_contact_act;

        $data ['procurement'] = $component;

        return $this->responseApiWithSuccess('Package information get succeessfully',$data);

      
    }

}
