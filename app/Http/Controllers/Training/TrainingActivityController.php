<?php

namespace App\Http\Controllers\Training;

use App\Training;
use App\File_manager;
use App\TrainingCategory;
use App\Training_activity;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Validator\validatorForm;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TrainingActivityController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'training_category_id'           => 'required|numeric',
        'training_id'                    => 'required|numeric',
        'number_of_event'                => 'required|numeric',
        'number_of_participant_perbatch' => 'required|numeric',
        'number_of_batch'                => 'required|numeric',
        'date'                           => 'required|date|date_format:Y-m-d',
        'reference'                      => 'nullable',
        'number_of_benefactor'           => 'nullable|numeric',
        'number_of_participant_attend'   => 'nullable|numeric',
        'male'                           => 'nullable|numeric',
        'female'                         => 'nullable|numeric'
    );

    public function index(Request $request)
    {
        $search[0]=$request->training_name;
        $search[1]=$request->training_category_id;
		if($request->training_name || $request->training_category_id || $request->training_id)
		{
			$name=$request->training_name;
            $training_cat_id=$request->training_category_id;
            $training_id=$request->training_id;

			$training_activity = DB::table('training_activities as at')
            ->leftJoin('training_categories as ct', 'ct.id', '=', 'at.training_category_id')
            ->leftJoin('trainings  as t', 't.id', '=', 'at.training_id')
            ->where('t.title', 'LIKE', "%{$name}%")
            ->where('ct.id', '=' , "{$training_cat_id}" )
            ->orwhere('at.training_id', '=' , "{$training_id}")
            ->select('at.id','ct.name','ct.serial_no','t.title','at.reference')
            ->paginate(30);
		}else{
			$training_activity = Training_activity::with('trainingcategory','training')->latest()->paginate(20);
        }
		$training_category = TrainingCategory::all();
        //return $training_activity;
        return view('training.training_activity.index',compact('training_activity','training_category','search'));
    }


    public function create()
    {
        // $indicator = Indicator::get();
        $training_categories = TrainingCategory::all();
        return view('training.training_activity.create',compact('training_categories'));
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $response = $this->validationWithJson($request->all(),$this->rules);
        //dd($response);
        if($response===true){
            $training_activity = $this->getFormData($request->all(),$this->rules);
            //dd($source_of_fund);
            Training_activity::create($training_activity);
            $training_activity = Training_activity::latest()->first();
            $this->file_upload($request,$training_activity['id']);
            return redirect('/training-activity')->with('toast_success','Training Activity data save Successfully.');
        }
        return back()->with('toast_error', $response)->withInput();
    }

    public function edit( $id)
    {
        $image_list=DB::select(" SELECT file_managers.`id`,file_managers.`file_path`
        FROM training_activities
        JOIN file_managers ON file_managers.`table_id`=training_activities.`id` AND file_managers.`fm_category_id`=1 AND file_managers.`is_image`=1
        WHERE training_activities.`id`=$id ");

        $file_list=DB::select(" SELECT file_managers.`id`,file_managers.`file_path`
        FROM training_activities
        JOIN file_managers ON file_managers.`table_id`=training_activities.`id` AND file_managers.`fm_category_id`=1 AND file_managers.`is_image`=0
        WHERE training_activities.`id`=$id ");
        //dd($file_list);
        $training_activity   = Training_activity::findOrFail($id);

        $training_categories = TrainingCategory::all();
        $training            = Training::where('training_category_id',$training_activity->training_category_id )->get();
        //return $training;
        return view('training.training_activity.edit',compact('training_activity','training_categories','training','image_list','file_list'));
    }


    public function update(Request $request, $id)
    {
        //return dd($request->all());
        $response = $this->validationWithJson($request->all(),$this->rules);
        //dd($response);
        if($response===true){
            $training = $this->getFormData($request->all(),$this->rules);
            Training_activity::updateOrCreate(['id'=>$id],$training);
            $this->file_upload($request,$id,true);
            return redirect('/training-activity')->with('toast_success','Training Activity Data  Updated Successfully.');
        }
        return back()->with('toast_error', $response)->withInput();
    }

    public function show($id)
    {
        $image_list=DB::select(" SELECT file_managers.`id`,file_managers.`file_path`
        FROM training_activities
        JOIN file_managers ON file_managers.`table_id`=training_activities.`id` AND file_managers.`fm_category_id`=1 AND file_managers.`is_image`=1
        WHERE training_activities.`id`=$id ");

        $file_list=DB::select(" SELECT file_managers.`id`,file_managers.`file_path`
        FROM training_activities
        JOIN file_managers ON file_managers.`table_id`=training_activities.`id` AND file_managers.`fm_category_id`=1 AND file_managers.`is_image`=0
        WHERE training_activities.`id`=$id ");
        //dd($id);
        $training_activity = DB::table('training_activities as at')
        ->leftJoin('training_categories as ct', 'ct.id', '=', 'at.training_category_id')
        ->leftJoin('trainings  as t', 't.id', '=', 'at.training_id')
        ->where('at.id', '=', $id)
        ->select('at.*','ct.name','t.title','at.reference')
        ->get()->toArray();
        //dd($training_activity);
        return view('training.training_activity.show',compact('training_activity','image_list','file_list'));
    }

    public function destroy($id)
    {
        $source = Training_activity::findOrFail($id);
        $file = DB::select("SELECT * FROM file_managers AS fm WHERE fm.`fm_category_id`=1 AND fm.`table_id`=$id");
        foreach ($file as $key => $value) {

            if (file_exists(public_path($value->file_path))) {
                unlink(public_path($value->file_path));
            }
            DB::table('file_managers')->where('id', $value->id)->where('table_id',$id)->delete();
        }
        $source->delete();

        return $this->responseWithSuccess('Data Deleted successfully','success');

    }

    public function get_training_name($id)
    {
        $training_name = Training::where('training_category_id',$id)->get();
        return $this->responseWithSuccess('message',$training_name);
    }

    /**  Training filtering  for index page*/
   /*public function search_trianing_activity(Request $request)
    {
        //dd($request->all());
        $response = $this->validationWithJson($request->all(),$this->filter);
        if($response===true){
            $search = $this->getFormData($request->all(),$this->filter);
        }
        $name=$search['training_name'];
        $training_cat_id=$search['training_category_id'];

        $training_activity = DB::table('training_activities as at')
            ->leftJoin('training_categories as ct', 'ct.id', '=', 'at.training_category_id')
            ->leftJoin('trainings  as t', 't.id', '=', 'at.training_id')
            ->where('t.title', 'LIKE', "%{$name}%")
            ->where('ct.id', 'LIKE' , "%{$training_cat_id}%" )
            ->select('at.id','ct.name','t.title','at.reference')
            ->paginate(20);
       // dd($training_activity);

        $training_category = TrainingCategory::all();
        return view('training.training_activity.index',compact('training_activity','training_category'));
    }
    */

    public function file_upload($request=[],$id,$isupdate=false)
    {
        //dd($request->all());   
        $training = Training::findOrFail($request->training_id);
        // dd($training['title']);
        $file_data = array();
        $file_data['name']           = $training['title'];
        $file_data['fm_category_id'] = 1;
        $file_data['table_id']       = $id;
        $file_data['is_image']       = 1;

        $fm_update_id = array();
        $index=0;
        $path = 'storage/training/';
        for($i=1; $i<20  ;$i++){
            $key = "image_".$i;
            $fm_id = "image_id_".$i;
            if( $request->file($key) ){
                if($request->has($fm_id) && $isupdate ){
                    $fm_id = $request->$fm_id;
                    $old_file  = File_manager::findOrFail($fm_id);
                    if (file_exists(public_path($old_file->file_path))) {
                        unlink(public_path($old_file->file_path));
                    }
                    //DB::table('file_managers')->where('is_image', 1)->where('table_id',$id)->delete();
                    $fileName = Str::random(25).'-.-'. $request->$key->getClientOriginalName();
                    //$fileName =  "image-".Str::random(25).'.'.$request->$key->getClientOriginalExtension();
                    request()->$key->move(public_path('storage/training'), $fileName);
                    $file_data['file_path'] = $path.$fileName;
                    File_manager::updateOrCreate(['id'=>$fm_id],$file_data);
                    $fm_update_id[$index++]=$fm_id;
                    
                }else{
                    $fileName = Str::random(25).'-.-'. $request->$key->getClientOriginalName();
                    //$fileName =  "image-".Str::random(25).'.'.$request->$key->getClientOriginalExtension();
                    request()->$key->move(public_path('storage/training'), $fileName);
                    $file_data['file_path'] = $path.$fileName;
                    File_manager::create($file_data);
                }
                
            }
            else if( $request->has($fm_id) && $isupdate){
                $fm_id = $request->$fm_id;
                $fm_update_id[$index++]=$fm_id;
                // if($has_image && $isupdate ){
                //     DB::table('file_managers')->where('is_image', 1)->where('table_id',$id)->delete();
                //     $has_image=false;
                // }
                // $file_data['file_path'] = $request->$key;
                // File_manager::create($file_data);

            }
        } 
        
        $file_data['is_image']  = 0;
        for($i=1; $i<20  ;$i++){
            $key = "file_".$i;
            $fm_id = "file_id_".$i;
            if( $request->file($key) ){
                if($request->has($fm_id) && $isupdate ){
                    $fm_id = $request->$fm_id;
                    $old_file  = File_manager::findOrFail($fm_id);
                    if (file_exists(public_path($old_file->file_path))) {
                        unlink(public_path($old_file->file_path));
                    }           
                    //DB::table('file_managers')->where('is_image', 1)->where('table_id',$id)->delete();
                    $fileName = Str::random(25).'-.-'. $request->$key->getClientOriginalName();
                    //$fileName =  "image-".Str::random(25).'.'.$request->$key->getClientOriginalExtension();
                    request()->$key->move(public_path('storage/training'), $fileName);
                    $file_data['file_path'] = $path.$fileName;
                    File_manager::updateOrCreate(['id'=>$fm_id],$file_data);
                    $fm_update_id[$index++]=$fm_id;
                    
                }else{
                    $fileName = Str::random(25).'-.-'. $request->$key->getClientOriginalName();
                    //$fileName =  "image-".Str::random(25).'.'.$request->$key->getClientOriginalExtension();
                    request()->$key->move(public_path('storage/training'), $fileName);
                    $file_data['file_path'] = $path.$fileName;
                    File_manager::create($file_data);
                }
                
            }
            else if( $request->has($fm_id) && $isupdate){
                $fm_id = $request->$fm_id;
                $fm_update_id[$index++]=$fm_id;
            }
        } 
        if($isupdate){
            $get_request_id = $request->file_id;
            $get_request_id=json_decode($get_request_id,true);
            $length = count($get_request_id);
            for($i=0;$i<$length;$i++){
                if(!in_array( $get_request_id[$i],$fm_update_id)){
                    $old_file  = File_manager::findOrFail($get_request_id[$i]);
                    if (file_exists(public_path($old_file->file_path))) {
                        unlink(public_path($old_file->file_path));
                    }
                    DB::table('file_managers')->where('id', $get_request_id[$i])->where('table_id',$id)->delete();
                }
            }
        }
       // dd('no');
        return true;
    }
}

/**image or file upload function for reponsive file manager */
/*
public function file_upload($request=[],$id,$isupdate=false)
{
    //dd($request->all());   
    $training = Training::findOrFail($request->training_id);
    // dd($training['title']);
    $file_data = array();
    $file_data['name']           = $training['title'];
    $file_data['fm_category_id'] = 1;
    $file_data['table_id']       = $id;

    if($request->image_1 !==null ){

        $file_data['is_image']       = 1;
       
        if($isupdate){
            DB::table('file_managers')->where('is_image', 1)->where('table_id',$id)->delete();
        }
    
        for($i=1;  ;$i++){
            $key = "image_".$i;
            //dd($key);
            if($request->has($key)){
                $file_path=$request->$key;
                //$file_path=explode('/',$request->$key);
                //dd($file_path[count($file_path)-1]);
                if($file_path!==null){
                    $file_data['file_path'] = $file_path;
                    File_manager::create($file_data);
                }
            }else{
                break;
            } 
        } 
    }
    if($request->file_1 !==null ){
        $file_data['is_image']       = 0;
        
        if($isupdate){
            DB::table('file_managers')->where('is_image', 0)->where('table_id',$id)->delete();
        }
        for($i=1;  ;$i++){
            $key = "file_".$i;
            //dd($key);
            if($request->has($key)){
                //$file_path=explode('/',$request->$key);
                $file_path=$request->$key;
                if($file_path!==null){
                    $file_data['file_path'] = $file_path;
                    File_manager::create($file_data);
                }
                //dd($file_path[count($file_path)-1]);
            }else{
                break;
            } 
        }
    
    }
    return true;
}

*/