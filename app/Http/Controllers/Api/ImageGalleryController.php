<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Validator\apiResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ImageGalleryController extends Controller
{
    use apiResponse;
    public function index(Request $request)
    {

        //gallery permission id = 115
        $category = DB::table('file_manager_categories')
                   ->where('parent_id',0)
                   ->where('id','!=',29)
                   ->select('id','title as name')
                   ->get();

        if($request->category_id && $request->date){

            $images = DB::table('file_managers as fm')
                ->leftjoin('file_manager_categories as cat','cat.id','=','fm.fm_category_id')
                ->where('is_image',1)
                ->where('fm_category_id','!=',30)
                ->where('fm_category_id','!=',31)
                ->where('fm_category_id','!=',32)
                ->where('fm_category_id','!=',38)
                ->where('cat.parent_id',$request->category_id)
                ->where('fm.date',$request->date)
                ->orderby('fm.id','DESC')
                ->select('fm.id','fm.name','fm.file_path','fm.date','fm.description')
                ->get();
       }
       else if($request->category_id){
           //return $request->category_id;
            $images = DB::table('file_managers as fm')
                ->leftjoin('file_manager_categories as cat','cat.id','=','fm.fm_category_id')
                ->where('is_image',1)
                ->where('fm_category_id','!=',30)
                ->where('fm_category_id','!=',31)
                ->where('fm_category_id','!=',32)
                ->where('fm_category_id','!=',38)
                ->where('cat.parent_id',$request->category_id)
                //->where('fm.date',$request->date)
                ->orderby('fm.id','DESC')
                ->select('fm.id','fm.name','fm.file_path','fm.date','fm.description')
                ->get();
       }else{
            $images = DB::table('file_managers')
                ->where('is_image',1)
                ->where('fm_category_id','!=',30)
                ->where('fm_category_id','!=',31)
                ->where('fm_category_id','!=',32)
                ->where('fm_category_id','!=',38)
                ->where('deleted_at',null)
                ->orderby('id','DESC')
                ->select('id','name','file_path','date','description')
                ->get();
       }

       $user       = \Auth::user();
       $permission = \App\PermissionRole::where('role_id',$user->role)->where('permission_id',115)->get();
       
       if($user->role ==1 || !$permission->isEmpty()){
           $permissionFile = $images;
       }else{
           $permissionFile = [];
       }

       $filter=[];
       $filter['category_id'] = $request->category_id;
       $filter['date']        = $request->date;

        $data =[];
        $data['category']    = $category;
        // $data['images']      = $images;
        $data['images']      = $permissionFile;
        $data['filtered_by'] = $filter;

        
        return $this->responseApiWithSuccess('succeessfully',$data);
    }
}
