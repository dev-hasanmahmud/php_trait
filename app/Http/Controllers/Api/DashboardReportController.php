<?php

namespace App\Http\Controllers\Api;

use App\PermissionRole;
use Illuminate\Http\Request;
use App\File_manager_category;
use App\Validator\apiResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardReportController extends Controller
{
    use apiResponse;
    public function index(Request $request)
    {
        //return $request->date;
        $package_id = $request->package_id;
        //dd($package_id);
        $categories= File_manager_category::whereIn('id',[2,1,6])->select('id','title as category_name')->get();
        $user       = Auth::user();
        $permission = PermissionRole::where('role_id',$user->role)->where('permission_id',173)->get();
        
        if($user->role !=1 && !$permission->isEmpty()){

            $file_count=DB::select("SELECT fm_category_id,COUNT(name) AS `count` FROM file_managers
                where ( deleted_at IS NULL AND created_by=$user->id)
                GROUP BY fm_category_id");
            if($request->category_id){
                $files = $this->filtering_report(true,$request->category_id,$request->date,$user->id);
            }else{
            $files= DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->whereIn('fm.fm_category_id',[1,3,4,5,6])
                ->where('fm.created_by',$user->id)
                ->where('fm.deleted_at',null)
                ->select('fm.*','cat.title')
                ->orderby('fm.id','DESC')
                ->select('fm.id','cat.title as category','fm.name','fm.date','fm.file_path')
                ->get();
            }
            //dd($files);
        }else{

            $file_count=DB::select("SELECT fm_category_id,COUNT(name) AS `count` FROM file_managers
                where deleted_at IS NULL 
                GROUP BY fm_category_id");
            if($request->category_id){
                $files = $this->filtering_report(false,$request->category_id,$request->date,$user->id);
            }else{
                $files= DB::table('file_managers as fm')
                    ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                    ->whereIn('fm.fm_category_id',[1,3,4,5,6])
                    ->where('fm.deleted_at',null)
                    ->select('fm.*','cat.title')
                    ->orderby('fm.id','DESC')
                    ->select('fm.id','cat.title as category','fm.name','fm.date','fm.file_path')
                    ->get();
            }
        }
        //dd($files);
        if($request->ajax()){
            return view('all_report.dashboard_table',compact('files'))->render();
        }
        $file_count_array=[];
        $sum=0;
        //dd($file_count);
        $file_count_array = array();
        $file_count_array[2]=0;
        $file_count_array[1]=0;
        $file_count_array[6]=0;
        if($file_count){
            foreach($file_count as $r)
            {
                if($r->fm_category_id==2 || $r->fm_category_id==3 || $r->fm_category_id==4 || $r->fm_category_id==5 ){
                    //$sum+= $r->count;
                    $file_count_array[2] +=$r->count;
                }
                $file_count_array[$r->fm_category_id]=$r->count;
            }
        }
        $categories[0] = collect($categories[0])->merge(['count' => $file_count_array[1]]);
        $categories[1] = collect($categories[1])->merge(['count' => $file_count_array[2]]);
        $categories[2] = collect($categories[2])->merge(['count' => $file_count_array[6]]);
        $data = [];
        $data['category'] = $categories;
        $data['report']   = $files;

        
        return $this->responseApiWithSuccess('succeessfully',$data);
        
    }

    public function filtering_report($is_permission=null,$category_id=null,$date=null,$user_id=null)
    {
        $fm_array = array($category_id);
        if($category_id==2){
            $fm_array = array(3,4,5);
        }
        if($category_id && $date){
            if($is_permission){
                $files= DB::table('file_managers as fm')
                    ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                    ->whereIn('fm.fm_category_id',$fm_array)
                    ->where('fm.date',$date)
                    ->where('fm.created_by',$user->id)
                    ->where('fm.deleted_at',null)
                    ->select('fm.*','cat.title')
                    ->orderby('fm.id','DESC')
                    ->select('fm.id','cat.title as category','fm.name','fm.date','fm.file_path')
                    ->get();
            }else{
                $files= DB::table('file_managers as fm')
                    ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                    ->whereIn('fm.fm_category_id',$fm_array)
                    ->where('fm.date',$date)
                    //->where('fm.created_by',$user->id)
                    ->where('fm.deleted_at',null)
                    ->select('fm.*','cat.title')
                    ->orderby('fm.id','DESC')
                    ->select('fm.id','cat.title as category','fm.name','fm.date','fm.file_path')
                    ->get();
            }
        }else{
            if($is_permission){
                $files= DB::table('file_managers as fm')
                    ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                    ->whereIn('fm.fm_category_id',$fm_array)
                    //->where('fm.date',$date)
                    ->where('fm.created_by',$user->id)
                    ->where('fm.deleted_at',null)
                    ->select('fm.*','cat.title')
                    ->orderby('fm.id','DESC')
                    ->select('fm.id','cat.title as category','fm.name','fm.date','fm.file_path')
                    ->get();
            }else{
                $files= DB::table('file_managers as fm')
                    ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                    ->whereIn('fm.fm_category_id',$fm_array)
                    //->where('fm.date',$date)
                    //->where('fm.created_by',$user->id)
                    ->where('fm.deleted_at',null)
                    ->select('fm.*','cat.title')
                    ->orderby('fm.id','DESC')
                    ->select('fm.id','cat.title as category','fm.name','fm.date','fm.file_path')
                    ->get();
            }
        }

        return $files;

    }

    public function package_wise_report(Request $request)
    {
        //dd('ye');
        $package_id = $request->package_id;
        $user       = Auth::user();
        $categories = File_manager_category::where('parent_id',15)->get();
        $permission = PermissionRole::where('role_id',$user->role)->where('permission_id',172)->get();
        
        if($user->role !=1 && !$permission->isEmpty()){
            //dd($user->id);
            $file_count=DB::select("SELECT fm_category_id,COUNT(name) AS `count` FROM file_managers
            where ( table_id= $package_id AND is_approve=1 AND created_by=$user->id)
            AND deleted_at IS NULL 
            GROUP BY fm_category_id");

            $files= DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            ->where('fm.table_id',$package_id)
            ->where('fm.is_approve',1)
            ->where('fm.created_by',$user->id)
            ->where('cat.parent_id',15)
            ->where('fm.deleted_at',null)
            ->select('fm.id','cat.title as category','fm.name','fm.date','fm.file_path')
            ->orderby('fm.id','DESC')
            ->get();
            
        }else{
            $file_count=DB::select("SELECT fm_category_id,COUNT(name) AS `count` FROM file_managers
            where ( table_id= $package_id AND is_approve=1)
            AND deleted_at IS NULL 
            GROUP BY fm_category_id");
            $files= DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            ->where('fm.table_id',$package_id)
            ->where('fm.is_approve',1)
            ->where('cat.parent_id',15)
            ->where('fm.deleted_at',null)
            ->select('fm.id','cat.title as category','fm.name','fm.date','fm.file_path')
            ->orderby('fm.id','DESC')
            ->get();
        }

        $package_name = \App\Component::find($package_id);
        $package_name = $package_name->package_no.'-'.$package_name->name_en;
        //dd($package_name);
        $file_count_array=[];
        if($file_count){
            foreach($file_count as $r)
            {
                $file_count_array[$r->fm_category_id]=$r->count;
            }
        }

        $data = [];
        $data['package_name'] = $package_name;
        $data['report']       = $files;

        
        return $this->responseApiWithSuccess('package wise report get succeessfully',$data);
        // $package_name= Component::where('id',$package_id)->first();

        // return view('all_report.package_report',compact('categories','files','file_count_array','package_id','package_name'));
    }
}
