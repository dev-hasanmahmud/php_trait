<?php

namespace App\Http\Controllers\Api;

use App\File_manager;
use App\data_acquisition;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Validator\apiResponse;
use App\Validator\validatorForm;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;


class ImageUploadController extends Controller
{
    use apiResponse;
    use validatorForm;
    protected $rules = array(
        'data_input_title_id'=> 'required',
        'component_id'       => 'required',
        'description'        => 'nullable',
        'date'               => 'nullable',
        'location'           => 'nullable',
        'user_id'            => 'nullable',
        'upazila_id'         => 'nullable',
        'area_id'            => 'nullable',
        'is_publish'         => 'nullable'

    );
    public function index()
    {
        $data = array();
        $file = File_manager::where('fm_category_id',38)->where('created_by',Auth::user()->id)->select('file_path','created_at')->get();

        $data['image']=$file;
        return $this->responseApiWithSuccess('Image information get succeessfully',$data);
    }

    public function image_list(Request $request)
    {
        $user = Auth::user();
       // return $request->all();
        $are_id = [];
        $i=0;
        $approve = [];

        if($user->teamlead_id){
            if( $user->role == 14){  //only for are or are role id 14
                $are_id[$i] = $user->id;
            }
            else{
                // Tl dtl and other which is similar to dtl
                $are = \App\User::where('teamlead_id',$user->teamlead_id)->select('id')->get();
                foreach($are as $a ){
                    $are_id[$i++] = $a->id;
                }

                if( $user->role == 16 ){    //for team lead special for iwm
                    if($user->is_consultant==19) $approve = [0,2]; // for shushilon dtl
                    else $approve = [1,2];
                }else{
                    // for deputy team and other user show similar
                    $approve = [0,1];  // for iwm dtl
                }
            }

        }else{
            //other persion admin or without iwm and shushilon
            $approve=[2];
        }

        $image_list = data_acquisition::with('data_input_title:id,title')
            ->when($request->package_id,function($q) use($request) {
                return $q->where('component_id',$request->package_id);
            })
            ->when($request->user_id,function($q) use($request) {
                return $q->where('user_id',$request->user_id);
            })
            ->when($request->title_id,function($q) use($request) {
                return $q->where('data_input_title_id',$request->title_id);
            })
            ->when($request->from_date,function($q) use($request) {
                return $q->whereBetween('date',[$request->from_date,$request->to_date]);
            })
            ->when($are_id,function($q) use($are_id) {
                return $q->whereIn('user_id',$are_id);
            })
            ->when($approve,function($q) use($approve) {
                return $q->whereIn('is_publish',$approve);
            })
            ->latest()
            ->select('id','data_input_title_id','date','is_publish')
            ->limit(70)
            ->get();

        //return $data;
        $permission = \App\PermissionRole::where('role_id',$user->role)->where('permission_id',211)->get();
        $da = [];
        $i=0;
        $editPermission = '';
        $approve        = '';
        foreach($image_list as $d){

            if( $d->is_publish==0 && $user->role==15 )         $editPermission  = true;   //show edit button and approve button
            elseif( ($d->is_publish==1 && $user->role==16 && $user->is_consultant=18) || ($d->is_publish==0 && $user->role==16 && $user->is_consultant=19) )     $editPermission  = true;  // tL id=16
            elseif( $user->role ==1 || !$permission->isEmpty()) $editPermission  = true;
            else $editPermission = false;

            $da[$i] = $d;

            if( $user->role == 14){
                if( $d->is_publish==1 || $d->is_publish==2 )
                    $approve = true;
                else $approve = false;
            }else{
                $approve = !$editPermission;
            }

            $da[$i] = collect($da[$i])->merge([
                'editPermission'  => $editPermission,
                'approve'         => $approve
            ])->toArray();
            $i++;
        }
        $image_list = $da;
        //return dd($image_list);
        $search=[];
        // $search[0] = $request->package_id;
        // $search[1] = $request->user_id;
        // $search[2] = $request->title_id;
        $search['from_date'] = $request->from_date;
        $search['to_date'] = $request->to_date;

        $data = [];
        $data['image_list'] = $image_list;
        $data['filtering']  = $search;

        return $this->responseApiWithSuccess('Image information get succeessfully',$data);


    }

    public function create()
    {
        //
    }

    public function recommendation(Request $request)
    {
        //return $request->all() ;
        //dd($id);
        $data_acquisition      = \App\data_acquisition::findOrfail($request->id);
        $data_acquisition_user = \App\User::findOrfail($data_acquisition->user_id);
        //dd($data_acquisition_user);
        $user = Auth::user();

        \App\Recommendation::create([
            'data_acquisition_id' => $request->id,
            'user_id'             => $user->id,
            'comment'             => $request->recommendation
        ]);

        //for notification purpase
        /* theamlead id have means those roole include this bt null means those user are irregular */
        $message      = $user->name.' '.get_notificaton_message(7);
        $link         = "http://139.59.91.209/app-image/".$request->id;

        $role_id = [];
        //dd($messege);

        // if( $data_acquisition->is_publish == 0 ){             /// if status 0 means data upload by are
        //     $role_id = [15];                                  //receive message dtl
        //     //$dtl_id = \App\User::where([['teamlead_id',$user->teamlead_id],['role',15]])->get();  //15 for dtl
        // }elseif( $data_acquisition->is_publish == 1 ){        // status 1 means data approved bby dtl
        //     $role_id = [15,16];                              // receive message dtl and tl
        // }else{                                               // data approved by tl
        //     $role_id = [15,16,6];                           //receive message dtl and tl and pd
        // }


        if( $data_acquisition->is_publish == 0 ){
            if($user->is_consultant == 19){          /// if status 0 means data upload by are
                $role_id = [16];         //shusiloan tl receive rrecommendation
            }else{
                $role_id = [15];     //receive message dtl
            }
            //$dtl_id = \App\User::where([['teamlead_id',$user->teamlead_id],['role',15]])->get();  //15 for dtl
        }elseif( $data_acquisition->is_publish == 1 ){        // status 1 means data approved bby dtl
            $role_id = [15,16];                              // receive message dtl and tl
        }else{                                               // data approved by tl
            $role_id = [15,16,6];                           //receive message dtl and tl and pd
        }



        $to_user_id = \App\User::whereIn('role',$role_id)->where('id','!=',$user->id)->get(); //->where('teamlead_id',$data_acquisition_user->teamlead_id)
        //dd($to_user_id->toArray());
        foreach($to_user_id as $to){
            if( $data_acquisition_user->teamlead_id == $to->teamlead_id || $to->role==6 ){ /// this condition avoid sent message login user
                $this->recommendation_notification($user->id , $to->id , $link, $message);
            }
        }

        if( $user->role !=14 ){
            $this->recommendation_notification($user->id , $data_acquisition->user_id , $link, $message);
        }
        //dd($to_user_id->toarray());
        return $this->responseApiWithSuccess('Recommendation saved successfully.',true);
        //return redirect('/app-image/'.$id)->with('toast_success','Recommendation Created Successfully.');
    }
    public function recommendation_notification($from , $to , $link, $message)
    {
        $messege      = $message;
        $link         = $link;
        $from_user_id = $from;
        $to_user_id   = $to;
        save_notification_data($messege,$link,$from_user_id,$to_user_id,$executed=0,$created_by=null,$updated_by=null,$type=null,$button=0,$button_value=null,$button_link=null);
            //dd('yses');
        return true ;
    }



    public function store(Request $request)
    {

        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $data = $this->getFormData($request->all(),$this->rules);
            //dd($source_of_fund);
            $data['user_id']    = Auth::user()->id;
            //$data['date']       = date('Y-m-d');
            $data['is_publish'] = 0;
            $data['upazila_id'] = $request->district_id;
            data_acquisition::create($data);
            $data = data_acquisition::latest()->first();

            $file_data = array();
            $file_data['fm_category_id'] = 38;
            $file_data['table_id']       = $data->id;
            $file_data['is_image']       = 1;
            $file_data['is_approve']     = 0;
            $file_data['created_by']     = Auth::user()->id;
            $path = "storage/AppImage/";
            for($i=1; $i<10 ;$i++){
                $key = "image_".$i;
                if( $request->file($key) ){
                    //return $this->responseApiWithSuccess('Image',$data);
                    $fileName = Str::random(25).'-.-'. $request->$key->getClientOriginalName();
                    // request()->$key->move(public_path('storage/AppImage'), $fileName);
                    //image resize by image intervantion pkg
                    $img = $request->$key;
                    $resize_image = Image::make($img)->resize(300,200)->save(public_path('storage/AppImage/') . $fileName);

                    $file_data['file_path'] = $path.$fileName;
                    $file_data['name']      = 'App-Image';
                    File_manager::create($file_data);
                }else{
                    break;
                }
            }
            $user = Auth::user();
            if($user->is_consultant==19){
                $dtl_id = \App\User::where([['teamlead_id',Auth::user()->teamlead_id],['role',16]])->get(); //tl_id for shusilon
            }else{
                $dtl_id = \App\User::where([['teamlead_id',Auth::user()->teamlead_id],['role',15]])->get(); //dtl_id 15
            }

            foreach($dtl_id as $d){
                $to_dtl_id = $d->id;
                $this->recommend($to_dtl_id,$data->id,Auth::user()->name);
            }
            //Auth::user()->teamlead_id

            return $this->responseApiWithSuccess('Data Acquisition uploded Successfully.',$data);
        }
        return $this->responseApiWithError('Found Something wrong',$response);
    }
    //backup store method
    public function storeOld(Request $request)
    {

        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $data = $this->getFormData($request->all(),$this->rules);
            //dd($source_of_fund);
            $data['user_id']    = Auth::user()->id;
            //$data['date']       = date('Y-m-d');
            $data['is_publish'] = 0;
            $data['upazila_id'] = $request->district_id;
            data_acquisition::create($data);
            $data = data_acquisition::latest()->first();

            $file_data = array();
            $file_data['fm_category_id'] = 38;
            $file_data['table_id']       = $data->id;
            $file_data['is_image']       = 1;
            $file_data['is_approve']     = 0;
            $file_data['created_by']     = Auth::user()->id;
            $path = "storage/AppImage/";
            for($i=1; $i<10 ;$i++){
                $key = "image_".$i;
                if( $request->file($key) ){
                    //return $this->responseApiWithSuccess('Image',$data);
                    $fileName = Str::random(25).'-.-'. $request->$key->getClientOriginalName();
                    request()->$key->move(public_path('storage/AppImage'), $fileName);

                    $file_data['file_path'] = $path.$fileName;
                    $file_data['name']      = 'App-Image';
                    File_manager::create($file_data);
                }else{
                    break;
                }
            }
            $user = Auth::user();
            if($user->is_consultant==19){
                $dtl_id = \App\User::where([['teamlead_id',Auth::user()->teamlead_id],['role',16]])->get(); //tl_id for shusilon
            }else{
                $dtl_id = \App\User::where([['teamlead_id',Auth::user()->teamlead_id],['role',15]])->get(); //dtl_id 15
            }

            foreach($dtl_id as $d){
                $to_dtl_id = $d->id;
                $this->recommend($to_dtl_id,$data->id,Auth::user()->name);
            }
            //Auth::user()->teamlead_id

            return $this->responseApiWithSuccess('Data Acquisition uploded Successfully.',$i);
        }
        return $this->responseApiWithError('Found Something wrong',$response);
    }




    public function show($id)
    {
        $image = data_acquisition::with('files:table_id,id,file_path,is_approve','data_input_title:id,title','component:id,package_no,name_en', 'upload_by:id,name','upazila:id,name','union:id,name')->findOrFail($id);
        $recommend = \App\Recommendation::with('users:id,name')->whereIn('data_acquisition_id',[$id])->select('comment','user_id','created_at')->latest()->get();

        $data = [];
        $user = Auth::user();
        $permissions = \App\PermissionRole::where('role_id',$user->role)->where('permission_id',211)->get();

        $buttonPermission = false;
        if( $image->is_publish==0 && $user->role==15 )         $buttonPermission  = true;   //show edit button and approve button
        elseif( ($image->is_publish==1 && $user->role==16 && $user->is_consultant=18) || ($image->is_publish==0 && $user->role==16 && $user->is_consultant=19) )     $buttonPermission  = true;
        elseif($user->role ==1 || !$permissions->isEmpty())    $buttonPermission  = true;
        else $buttonPermission = false;

        $data['image']      = $image;
        $data['buttonPermission'] = $buttonPermission;
        $data['recommend']  = $recommend;

        return $this->responseApiWithSuccess('Image get succeessfully',$data);
    }


    public function edit($id)
    {
        $image = data_acquisition::with('files:table_id,id,file_path,is_approve','data_input_title:id,title','component:id,package_no,name_en', 'upload_by:id,name','upazila:id,name','union:id,name')->findOrFail($id);

        return $this->responseApiWithSuccess('Image get succeessfully',$image);
    }


    public function update(Request $request)
    {
        $image_id = $request->image_id;
        //return $request->all();
       // return $image_id;

        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $data = $this->getFormData($request->all(),$this->rules);

            $current_data       = data_acquisition::findOrfail($request->id);
            $data['user_id']    = $current_data->user_id;
            $data['date']       = $current_data->date;
            $data['is_publish'] = $current_data->is_publish;
            $data['upazila_id'] = $request->district_id;
            //data_acquisition::updateOrcreate($data);
            //return $current_data;
            data_acquisition::updateOrCreate(['id'=>$request->id],$data);

            $file = \DB::select("SELECT * FROM file_managers AS fm WHERE fm.`fm_category_id`=38 AND fm.`table_id`=$request->id");

            foreach ($file as $key => $value) {
                if( !in_array( $value->id , $image_id )){
                    //return 'yes';
                   // return $value->id;
                    if (file_exists(public_path($value->file_path))) {
                        unlink(public_path($value->file_path));
                    }
                    \DB::table('file_managers')->where('id', $value->id)->delete();
                }
                //return 'no';


            }

            return $this->responseApiWithSuccess('Data Acquisition Updated Successfully.',true);
        }
        return $this->responseApiWithError('Found Something wrong',$response);
    }


    public function destroy($id)
    {
       // return $id;
        $source = \App\data_acquisition::findOrFail($id);
        $file = \DB::select("SELECT * FROM file_managers AS fm WHERE fm.`fm_category_id`=38 AND fm.`table_id`=$id");
        foreach ($file as $key => $value) {

            if (file_exists(public_path($value->file_path))) {
                unlink(public_path($value->file_path));
            }
            \DB::table('file_managers')->where('id', $value->id)->where('table_id',$id)->delete();
        }
        $source->delete();

        return $this->responseWithSuccess('Data Deleted successfully','success');
    }

    public function image_approve($id)
    {
        //return $id;
        $data_acuisition_data = data_acquisition::findOrFail($id);

        if( Auth::user()->is_consultant == 19){ // for shushilon deputy temad as there is no teamlead.
            $data_acuisition_data->is_publish = 2; //status 1 is for dpt and status 2 for tl
        }elseif( Auth::user()->role == 16){ // for iwm team lead
            $data_acuisition_data->is_publish = 2;
        }else{
            $data_acuisition_data->is_publish = 1; //for iwm dtl
        }

        $data_acuisition_data->save();

        $id_list =  File_manager::where([['fm_category_id',38],['table_id',$id]])->get();

        //$this->recommend( $data_acuisition_data['user_id'] );
        if( $data_acuisition_data->is_publish == 1 || ($data_acuisition_data->is_publish==2 &&
        Auth::user()->is_consultant == 19 ) ){
            $messege      = get_notificaton_message(6) ;  // get ARE message from dtl
            $link         = "http://139.59.91.209/app-image/".$id;
            $from_user_id = Auth::user()->id;
            $to_user_id   = $data_acuisition_data->user_id;
            save_notification_data($messege,$link,$from_user_id,$to_user_id,$executed=0,$created_by=null,$updated_by=null,$type=null,$button=0,$button_value=null,$button_link=null);
        }

        foreach($id_list as $r){
            $indicator_data = File_manager::find($r->id);
            //dd($indicator_data);
            $user = Auth::user();
            $indicator_data->is_approve  =1;
            $indicator_data->approval_by = $user->id;
            $indicator_data->save();
        }

        return $this->responseWithSuccess('Data approved successfully',$id);

    }

    public function recommend($to_id,$data_id,$user_name)
    {

        //return $to_dtl_id;
        $messege      = get_notificaton_message(5).'from '.$user_name ;  // get dtl message from are
        $link         = "http://139.59.91.209/app-image/".$data_id;
        $from_user_id = Auth::user()->id;
        $to_user_id   = $to_id;
        save_notification_data($messege,$link,$from_user_id,$to_user_id,$executed=0,$created_by=null,$updated_by=null,$type=null,$button=0,$button_value=null,$button_link=null);
            //dd('yses');
        return true ;

    }

    public function dynamic_image()
    {
        $data = array();
        $data['about']="The Government of the People’s Republic of Bangladesh (GoB) has received a grant from the International Development Association (IDA) towards the cost of Emergency Multi-Sector Rohingya Crisis Response Project (EMRCRP). Component 1A and 3B of the project will be implemented by Department of Public Health Engineering (DPHE) under Ministry of Local Government, Rural Development and Cooperatives (MLGRD&C). The PMU is mandated to manage the project in keeping with the Borrower’s obligation to use the project fund with due regard to economy and efficiency and only for the purpose for which project financing was provided.";


        $file = File_manager::where('fm_category_id',37)->select('file_path')->latest()->first();

        $data['image']=$file->file_path;
        return $this->responseApiWithSuccess('Image information get succeessfully',$data);
    }
}
