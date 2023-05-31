<?php

namespace App\Http\Controllers;

use App\Component;
use App\File_manager;
use App\Indicator_data;
use App\Disapprove_details;
use Illuminate\Http\Request;
use App\File_manager_category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        
        $component = Component::orderby('package_no')->get();
        $indicator_data = Indicator_data::where('is_approve',0)->latest()->paginate(30);
        $is_filter = 0;
        $search[0] = 1;
        $search[1] = 0;
        if($request->component_id){
            //dd('yes');
            //$indicator_data = Indicator_data::where('component_id',$request->component_id)->where('is_approve',$request->status)->get();
            $indicator_data = DB::table('indicator_datas as in')
                ->where('in.component_id','=',$request->component_id)
                ->where('in.is_approve','=',$request->status)
                ->leftjoin('components as c', 'c.id','=','in.component_id')
                ->leftjoin('indicators as i', 'i.id','=','in.indicator_id')
                ->leftjoin('users as u','u.id','in.created_by')
                ->select('in.*','c.name_en as package','c.package_no','u.name as user','i.name_en as indicator_name')
                ->paginate(30);
            
            $is_filter=1;
            $search[0] = $request->component_id;
            $search[1] = $request->status;
           // return view('approval.index',compact('component','indicator_data','is_filter','search'));
        }
        //dd($indicator_data);
        return view('approval.index',compact('component','indicator_data','is_filter','search'));
    }
    public function approve($id)
    {
       //dd($id);
        $indicator_data = Indicator_data::find($id);
        //dd($indicator_data);
        $user = Auth::user();
        $indicator_data->is_approve  = 1;
        $indicator_data->approval_by = $user->id;
        if( $indicator_data->save() ){
            $messege      = get_notificaton_message(0);
            $link         = "http://139.59.91.209/indicator_data/".$id;
            $from_user_id = $user->id;
            $to_user_id   = $indicator_data->created_by;
            save_notification_data($messege,$link,$from_user_id,$to_user_id,$executed=0,$created_by=null,$updated_by=null,$type=null,$button=0,$button_value=null,$button_link=null);
            //dd('yses');
            return true ; 
        }
    }
    public function dis_approve(Request $request,  $id)
    {
       // return 'yes';
        //dd($request->all());
        $indicator_data = Indicator_data::find($id);
        //dd($indicator_data);
        $user = Auth::user();
        $indicator_data->is_approve  = 2;
        $indicator_data->approval_by = $user->id;
        
        $disapprove_data = array();
        $disapprove_data['indicator_data_id'] = $id;
        $disapprove_data['disapprove_by'] = $user->id;
        $disapprove_data['details'] = $request->text;
        $disapprove_data['date'] = date("Y-m-d");
        $disapprove_data['table_id'] = 1;
        //dd($disapprove_data);
        Disapprove_details::create($disapprove_data);

        if( $indicator_data->save() ){
            $messege      = get_notificaton_message(1);
            $link         = "http://139.59.91.209/indicator_data/".$id;
            $from_user_id = $user->id;
            $to_user_id   = $indicator_data->created_by;
            save_notification_data($messege,$link,$from_user_id,$to_user_id,$executed=0,$created_by=null,$updated_by=null,$type=null,$button=0,$button_value=null,$button_link=null);
            //dd('yses');
            return true ; 
        }
    }
    public function report_file_approve_index(Request $request)
    {   
        $categories= File_manager_category::where('parent_id',15)->get();
        $package = Component::orderby('package_no')->get();
        $search[0] = 1;
        $search[1] = 0;
        $search[2] = 1;
       
        if($request->package_id !=0 ){
            $files= DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('cat.parent_id',15)
                ->leftJoin('components as com', 'com.id', '=', 'fm.table_id')
                ->where('fm.fm_category_id',$request->fm_id)
                ->where('fm.table_id',$request->package_id)
                ->where('fm.is_approve',$request->status)
                ->select('fm.*','cat.title','com.package_no','com.name_en')
                ->orderby('fm.id','DESC')
                ->paginate(20);
            $search[0] = $request->fm_id;
            $search[1] = $request->status;
            $search[2] = $request->package_id;
        }else{
            $files= DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            ->where('cat.parent_id',15)
            ->leftJoin('components as com', 'com.id', '=', 'fm.table_id')
            //->where('fm.table_id',$package_id)
            ->where('fm.is_approve',0)
            ->where('fm.deleted_at',null)
            ->select('fm.*','cat.title','com.package_no','com.name_en' )
            ->orderby('fm.id','DESC')
            ->paginate(20);
        }
        //dd($files);
        return view('approval.report-file-index',compact('files','categories','search','package'));
        
    }
    public function report_file_approve($id)
    {
        //dd($id);
        $indicator_data = File_manager::find($id);
        //dd($indicator_data);
        $user = Auth::user();
        $indicator_data->is_approve  =1;
        $indicator_data->approval_by = $user->id;
        //$indicator_data->save();

        if( $indicator_data->save() ){
            $messege      = get_notificaton_message(2);
            $link         = "http://139.59.91.209/dashboard/package-wise-report/".$id;
            $from_user_id = $user->id;
            $to_user_id   = $indicator_data->created_by;
            save_notification_data($messege,$link,$from_user_id,$to_user_id,$executed=0,$created_by=null,$updated_by=null,$type=null,$button=0,$button_value=null,$button_link=null);
            //dd('yses');
            return true ; 
        }
        
    }
    public function report_file_dis_approve(Request $request,$id)
    {
        $indicator_data = File_manager::find($id);
        //dd($indicator_data);
        $user = Auth::user();
        $indicator_data->is_approve  =2;
        $indicator_data->approval_by = $user->id;
        //$indicator_data->save();

        $disapprove_data = array();
        $disapprove_data['indicator_data_id'] = $id;
        $disapprove_data['disapprove_by'] = $user->id;
        $disapprove_data['details'] = $request->text;
        $disapprove_data['date'] = date("Y-m-d");
        $disapprove_data['table_id'] = 2;
        //dd($disapprove_data);
        Disapprove_details::create($disapprove_data);

        if( $indicator_data->save() ){
            $messege      = get_notificaton_message(3);
            $link         = "http://139.59.91.209/dashboard/package-wise-report/".$id;
            $from_user_id = $user->id;
            $to_user_id   = $indicator_data->created_by;
            save_notification_data($messege,$link,$from_user_id,$to_user_id,$executed=0,$created_by=null,$updated_by=null,$type=null,$button=0,$button_value=null,$button_link=null);
            //dd('yses');
            return true ; 
        }
    }
}
