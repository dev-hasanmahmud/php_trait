<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\File_manager_category;
use App\Validator\apiResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GisController extends Controller
{
    use apiResponse;
    public function index(Request $request)
    {
        // gis permission Controller id 140
        //return $request->category_id;
        $categories= File_manager_category::where('parent_id',29)->select('id','title as category_name')->get();

       if( $request->category_id && $request->date ){
            $files= DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where([['cat.parent_id',29],['cat.id',$request->category_id]])
                ->where([['fm.deleted_at',null],['fm.date',$request->date]])
                ->select('fm.*','cat.title')
                ->orderby('fm.id','DESC')
                ->select('fm.id','cat.title as category','fm.name','fm.date','fm.file_path')
                ->get();
        }
        else if( $request->category_id ){
            $files= DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where([['cat.parent_id',29],['cat.id',$request->category_id]])
                ->where('fm.deleted_at',null)
                ->select('fm.*','cat.title')
                ->orderby('fm.id','DESC')
                ->select('fm.id','cat.title as category','fm.name','fm.date','fm.file_path')
                ->get();
        }else{
            $files= DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('cat.parent_id',29)
                ->where('fm.deleted_at',null)
                ->select('fm.*','cat.title')
                ->orderby('fm.id','DESC')
                ->select('fm.id','cat.title as category','fm.name','fm.date','fm.file_path')
                ->get();
        }

        $pre ='';
        $index=1;
        $ind = 0;
        $count = [];
        foreach($files as $f){
            $ind++;
            if($pre == $f->name){
                $count[ $index ] +=1;
            }else{
                $index = $ind;
                $count[ $index ] = 1;
            }

            $pre = $f->name;
        }
        //dd($files);


        $file_count_array=[];
        $file_count_array[30]=0;
        $file_count_array[31]=0;
        $file_count_array[32]=0;
        $file_count=DB::select("SELECT fm_category_id,COUNT(NAME) AS `count` FROM file_managers
        WHERE deleted_at IS NULL
        GROUP BY fm_category_id");
        
        if($file_count){
            foreach($file_count as $r)
            {
                $file_count_array[$r->fm_category_id]=$r->count;
            }
        }

        //return $file_count;

        $categories[0] = collect($categories[0])->merge(['count' => $file_count_array[30]]);
        $categories[1] = collect($categories[1])->merge(['count' => $file_count_array[31]]);
        $categories[2] = collect($categories[2])->merge(['count' => $file_count_array[32]]);

        $user       = \Auth::user();
        $permission = \App\PermissionRole::where('role_id',$user->role)->where('permission_id',140)->get();
        
        if($user->role ==1 || !$permission->isEmpty()){
            $permissionFile = $files;
        }else{
            $permissionFile = [];
        }

        $data = [];
        $data['category'] = $categories;
        // $data['report']   = $files;
        $data['report']   = $permissionFile;

        
        return $this->responseApiWithSuccess('gis report get succeessfully',$data);
    }
}
