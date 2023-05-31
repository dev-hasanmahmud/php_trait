<?php

namespace App\Http\Controllers;

use App\data_acquisition;
use App\File_manager;
use App\Validator\validatorForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AppImageController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'data_input_title_id' => 'required',
        'component_id' => 'required',
        'description' => 'nullable',
        'location' => 'nullable',
        'date' => 'nullable',
        'is_publish' => 'nullable',
        'upazila_id' => 'nullable',
        'area_id' => 'nullable',
        'user_id' => 'nullable',
    );
    public function index(Request $request)
    {
        $user = Auth::user();
        //return $request->all();
        $are_id = [];
        $i = 0;
        $approve = [];

        // if( $user->role == 15 ){    //for deputy team lead
        //     $are = \App\User::where('teamlead_id',$user->id)->select('id')->get();
        //     foreach($are as $a ){
        //         $are_id[$i++] = $a->id;
        //     }
        //     //return $are_id;
        // }
        // else if( $user->role == 14){   // role_id 14 for Are
        //     $are_id[$i] = $user->id;
        // }else if( $user->role == 16 || $user->role==1){   // for teamd lead
        //     $approve = [1,2];
        // }else{
        //     $approve=[2];
        // }

        if ($user->teamlead_id) {
            if ($user->role == 14) { //only for are or are role id 14
                $are_id[$i] = $user->id;
            } else {
                // Tl dtl and other which is similar to dtl
                $are = \App\User::where('teamlead_id', $user->teamlead_id)->select('id')->get();
                foreach ($are as $a) {
                    $are_id[$i++] = $a->id;
                }

                if ($user->role == 16) { //for team lead special for iwm
                    if ($user->is_consultant == 19) {
                        $approve = [0, 2];
                    }
                    // for shushilon dtl
                    else {
                        $approve = [1, 2];
                    }

                    //dd($approve);
                } else {
                    // for deputy team and other user show similar
                    $approve = [0, 1, 2]; // for iwm dtl
                }
            }

        } else {
            //other persion admin or without iwm and shushilon
            $approve = [2];
        }

        $data = data_acquisition::with('files:table_id,file_path,is_approve', 'data_input_title:id,title', 'component:id,package_no,name_en', 'upload_by:id,name', 'upazila:id,name', 'union:id,name')
            ->when($request->package_id, function ($q) use ($request) {
                return $q->where('component_id', $request->package_id);
            })
            ->when($request->user_id, function ($q) use ($request) {
                return $q->where('user_id', $request->user_id);
            })
            ->when($request->title_id, function ($q) use ($request) {
                return $q->where('data_input_title_id', $request->title_id);
            })
            ->when($request->from_date, function ($q) use ($request) {
                return $q->whereBetween('created_at', [$request->from_date, $request->to_date]);
            })
            ->when($are_id, function ($q) use ($are_id) {
                return $q->whereIn('user_id', $are_id);
            })
            ->when($approve, function ($q) use ($approve) {
                return $q->whereIn('is_publish', $approve);
            })
            ->latest()->paginate(20);

        //return $data;

        $user = Auth::user();
        $permission = \App\PermissionRole::where('role_id', $user->role)->where('permission_id', 211)->get(); //edit delte permission id 211

        $editPermission = [];

        foreach ($data as $d) {
            if ($d->is_publish == 0 && $user->role == 15) {
                $editPermission[$d->id] = 1;
            }
            //for  dtl id=15
            elseif (($d->is_publish == 1 && $user->role == 16 && $user->is_consultant = 18) || ($d->is_publish == 0 && $user->role == 16 && $user->is_consultant = 19)) {
                $editPermission[$d->id] = 1;
            }
            // tl id=16
            elseif ($user->role == 1 || !$permission->isEmpty()) {
                $editPermission[$d->id] = 1;
            }
            //others
            else {
                $editPermission[$d->id] = 0;
            }

        }

        //return $permission;
        $search = [];
        $search[0] = $request->package_id;
        $search[1] = $request->user_id;
        $search[2] = $request->title_id;
        $search[3] = $request->from_date;
        $search[4] = $request->to_date;
        $package = \App\Component::select('id', 'package_no', 'name_en')->where('type_id', '!=', 1)->get();
        if ($user->teamlead_id) {
            $user = \App\User::select('id', 'name')->where('role', 14)->where('teamlead_id', $user->teamlead_id)->get();
        } else {
            $user = \App\User::select('id', 'name')->where('role', 14)->get();
        }
        $title = \App\data_input_title::select('id', 'title')->get();
        return view('app_image.index', compact('data', 'package', 'search', 'user', 'title', 'editPermission'));
    }

    public function all_notification()
    {
        $user = Auth::user();
        $notification = \App\Notification::where('to_user_id', $user->id)->latest()->paginate(20);
        //return $notification;
        return view('app_image.all_notification', compact('notification'));
    }

    public function create()
    {

        //return $data;
        $package = \App\Component::select('id', 'package_no', 'name_en')->get();
        $title = \App\data_input_title::select('id', 'title')->get();
        $upazila = \App\District::get();
        $unions = \App\Union::select('id', 'name')->get();
        //return  $unions; // $data->upazila_id;
        $upazila = \App\District::get();

        return view('app_image.create', compact('package', 'title', 'upazila', 'unions'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $response = $this->validationWithJson($request->all(), $this->rules);
        if ($response === true) {
            $data = $this->getFormData($request->all(), $this->rules);
            //dd($source_of_fund);
            $data['is_publish'] = 1;
            $data['user_id'] = Auth::user()->id;
            \App\data_acquisition::create($data);
            $data_acquisition = \App\data_acquisition::latest()->first();
            $this->file_upload($request, $data_acquisition['id']);
            return redirect('/app-image')->with('toast_success', 'Data Acquisition uploded Successfully.');
        }
        return back()->with('toast_error', $response)->withInput();
    }

    public function show($id)
    {
        // return $id;

        $data = data_acquisition::with('files:table_id,file_path,is_approve', 'data_input_title:id,title', 'component:id,package_no,name_en', 'upload_by:id,name', 'upazila:id,name', 'union:id,name')->findOrFail($id);
        $recommend = \App\Recommendation::with('users')->whereIn('data_acquisition_id', [$id])->latest()->get();
        //return $data;
        // $data = \DB::select("select `r1`.*, `r2`.* from (select `d`.`id`, `d`.`description`, `d`.`created_at` as `date`, `c`.`package_no`, `c`.`name_en`, `t`.`title` from `data_acquisitions` as `d` left join `components` as `c` on `c`.`id` = `d`.`component_id` left join `data_input_titles` as `t` on `t`.`id` = `d`.`data_input_title_id` where `d`.`id` = $id) as `r1` left join (select `u`.`name` as `created`, `f`.`file_path`, `f`.`is_approve`, `f`.`fm_category_id`, `f`.`table_id` as `table_id`, `ap`.`name` as `approved` from `file_managers` as `f` left join `users` as `u` on `u`.`id` = `f`.`created_by` left join `users` as `ap` on `ap`.`id` = `f`.`approval_by` where `f`.`fm_category_id` = 38) as `r2` on `r2`.`table_id` = `r1`.`id`");

        //dd($data);
        return view('app_image.show', compact('data', 'recommend'));
    }

    public function edit($id)
    {
        $data = \App\data_acquisition::with('component', 'data_input_title', 'upload_by')->findOrFail($id);
        //return $data;
        $package = \App\Component::select('id', 'package_no', 'name_en')->get();
        $title = \App\data_input_title::where('component_id', $data->component_id)->select('id', 'title')->get();
        $upazila = \App\District::get();
        $unions = \App\Union::where('district_id', $data->upazila_id)->select('id', 'name')->get();
        //return  $unions; // $data->upazila_id;
        $upazila = \App\District::get();

        $recommend = \App\Recommendation::with('users')->whereIn('data_acquisition_id', [$id])->latest()->get();

        // return $recommendation;
        $image_list = \App\File_manager::where([['table_id', $id], ['fm_category_id', 38]])->get();
        //dd($file);
        return view('app_image.edit', compact('data', 'package', 'title', 'image_list', 'upazila', 'unions', 'recommend'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $response = $this->validationWithJson($request->all(), $this->rules);
        if ($response === true) {
            $data = $this->getFormData($request->all(), $this->rules);
            //dd($source_of_fund);
            $recent_data = \App\data_acquisition::findOrFail($id);
            $data['is_publish'] = $recent_data->is_publish;
            $data['user_id'] = $recent_data->user_id;
            \App\data_acquisition::updateOrcreate(['id' => $id], $data);
            $this->file_upload($request, $id, true);
            if ($request->recommendation != null) {
                \App\Recommendation::create([
                    'data_acquisition_id' => $id,
                    'user_id' => Auth::user()->id,
                    'comment' => $request->recommendation,
                ]);

                //$this->recommend( $data['user_id'] );
            }

            return redirect('/app-image')->with('toast_success', 'Data Acquisition Updated Successfully.');
        }
        return back()->with('toast_error', $response)->withInput();
    }

    public function recommendation(Request $request, $id)
    {
        //dd($request->all() );
        //dd($id);
        $data_acquisition = \App\data_acquisition::findOrfail($id);
        $data_acquisition_user = \App\User::findOrfail($data_acquisition->user_id);
        //dd($data_acquisition_user);
        $user = Auth::user();

        \App\Recommendation::create([
            'data_acquisition_id' => $id,
            'user_id' => $user->id,
            'comment' => $request->recommendation,
        ]);

        //for notification purpase
        /* theamlead id have means those roole include this bt null means those user are irregular */
        $message = $user->name . ' ' . get_notificaton_message(7);
        $link = "http://139.59.91.209/app-image/" . $id;

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

        if ($data_acquisition->is_publish == 0) {
            if ($user->is_consultant == 19) { /// if status 0 means data upload by are
                $role_id = [16]; //shusiloan tl receive rrecommendation
            } else {
                $role_id = [15]; //receive message dtl
            }
            //$dtl_id = \App\User::where([['teamlead_id',$user->teamlead_id],['role',15]])->get();  //15 for dtl
        } elseif ($data_acquisition->is_publish == 1) { // status 1 means data approved bby dtl
            $role_id = [15, 16]; // receive message dtl and tl
        } else { // data approved by tl
            $role_id = [15, 16, 6]; //receive message dtl and tl and pd
        }

        $to_user_id = \App\User::whereIn('role', $role_id)->where('id', '!=', $user->id)->get(); //->where('teamlead_id',$data_acquisition_user->teamlead_id)
        //dd($to_user_id->toArray());
        foreach ($to_user_id as $to) {
            if ($data_acquisition_user->teamlead_id == $to->teamlead_id || $to->role == 6) { /// this condition avoid sent message login user
                $this->recommendation_notification($user->id, $to->id, $link, $message);
            }
        }

        if ($user->role != 14) {
            $this->recommendation_notification($user->id, $data_acquisition->user_id, $link, $message);
        }
        //dd($to_user_id->toarray());
        return redirect('/app-image/' . $id)->with('toast_success', 'Recommendation Created Successfully.');
    }
    public function recommendation_notification($from, $to, $link, $message)
    {
        $messege = $message;
        $link = $link;
        $from_user_id = $from;
        $to_user_id = $to;
        save_notification_data($messege, $link, $from_user_id, $to_user_id, $executed = 0, $created_by = null, $updated_by = null, $type = null, $button = 0, $button_value = null, $button_link = null);
        //dd('yses');
        return true;
    }

    public function recommend($to_id, $data_id)
    {

        $messege = get_notificaton_message(6);
        $link = "http://139.59.91.209/app-image/" . $data_id;
        $from_user_id = Auth::user()->id;
        $to_user_id = $to_id;
        save_notification_data($messege, $link, $from_user_id, $to_user_id, $executed = 0, $created_by = null, $updated_by = null, $type = null, $button = 0, $button_value = null, $button_link = null);
        //dd('yses');
        return true;

    }

    public function destroy($id)
    {
        $source = \App\data_acquisition::findOrFail($id);
        $file = \DB::select("SELECT * FROM file_managers AS fm WHERE fm.`fm_category_id`=38 AND fm.`table_id`=$id");
        foreach ($file as $key => $value) {

            if (file_exists(public_path($value->file_path))) {
                unlink(public_path($value->file_path));
            }
            \DB::table('file_managers')->where('id', $value->id)->where('table_id', $id)->delete();
        }
        $source->delete();

        return $this->responseWithSuccess('Data Deleted successfully', 'success');
    }

    public function image_approve($id)
    {
        //return $id;
        $data_acuisition_data = data_acquisition::findOrFail($id);

        if (Auth::user()->is_consultant == 19) { // for shushilon deputy temad as there is no teamlead.
            $data_acuisition_data->is_publish = 2; //status 1 is for dpt and status 2 for tl
        } else {
            $data_acuisition_data->is_publish = 1;
        }

        $data_acuisition_data->save();

        $id_list = File_manager::where([['fm_category_id', 38], ['table_id', $id]])->get();

        $this->recommend($data_acuisition_data['user_id'], $id);

        foreach ($id_list as $r) {
            $indicator_data = File_manager::find($r->id);
            //dd($indicator_data);
            $user = Auth::user();
            $indicator_data->is_approve = 1;
            $indicator_data->approval_by = $user->id;
            $indicator_data->save();
        }

        return $this->responseWithSuccess('Data approved successfully', $data_acuisition_data);

        // if( $indicator_data->save() ){
        //     $messege      = get_notificaton_message(2);
        //     $link         = "dashboard/package-wise-report/".$id;
        //     $from_user_id = $user->id;
        //     $to_user_id   = $indicator_data->created_by;
        //     save_notification_data($messege,$link,$from_user_id,$to_user_id,$executed=0,$created_by=null,$updated_by=null,$type=null,$button=0,$button_value=null,$button_link=null);
        //     //dd('yses');
        //     return true ;
        // }

    }
    public function image_approve_second_layer($id)
    {
        $data_acuisition_data = data_acquisition::findOrFail($id);
        $data_acuisition_data->is_publish = 2;
        $data_acuisition_data->save();

        return redirect('/app-image')->with('toast_success', 'Data Publish Successfully.');

    }
    // public function second_approve($id)
    // {
    //     $data_acuisition_data = data_acquisition::findOrFail($id);
    //     $data_acuisition_data->is_publish = 2;
    //     $data_acuisition_data->save();

    //     return $this->responseWithSuccess('Second Layer Data approved successfully','success');
    // }

    public function get_activity_list($id)
    {
        $title = \App\data_input_title::where('component_id', $id)->select('id', 'title')->get();
        return $this->responseWithSuccess('Second Layer Data approved successfully', $title);
    }

    public function get_union_list($id)
    {
        $union = \App\Union::where('district_id', $id)->select('id', 'name')->get();
        return $this->responseWithSuccess('Second Layer Data approved successfully', $union);
    }
    public function file_upload($request = [], $id, $isupdate = false)
    {
        //dd($request->all());
        $file_data = array();
        $file_data['name'] = 'App-Image';
        $file_data['fm_category_id'] = 38;
        $file_data['table_id'] = $id;
        $file_data['is_image'] = 1;
        $file_data['created_by'] = Auth::user()->id;

        $fm_update_id = array();
        $index = 0;
        $path = "storage/AppImage/";
        for ($i = 1; $i < 20; $i++) {
            $key = "image_" . $i;
            $fm_id = "image_id_" . $i;
            if ($request->file($key)) {
                if ($request->has($fm_id) && $isupdate) {
                    $fm_id = $request->$fm_id;
                    $old_file = File_manager::findOrFail($fm_id);
                    if (file_exists(public_path($old_file->file_path))) {
                        unlink(public_path($old_file->file_path));
                    }
                    //DB::table('file_managers')->where('is_image', 1)->where('table_id',$id)->delete();
                    $fileName = Str::random(25) . '-.-' . $request->$key->getClientOriginalName();
                    //$fileName =  "image-".Str::random(25).'.'.$request->$key->getClientOriginalExtension();
                    request()->$key->move(public_path('storage/AppImage'), $fileName);
                    $file_data['file_path'] = $path . $fileName;
                    File_manager::updateOrCreate(['id' => $fm_id], $file_data);
                    $fm_update_id[$index++] = $fm_id;

                } else {
                    $fileName = Str::random(25) . '-.-' . $request->$key->getClientOriginalName();
                    //$fileName =  "image-".Str::random(25).'.'.$request->$key->getClientOriginalExtension();
                    request()->$key->move(public_path('storage/AppImage'), $fileName);
                    $file_data['file_path'] = $path . $fileName;
                    File_manager::create($file_data);
                }

            } else if ($request->has($fm_id) && $isupdate) {
                $fm_id = $request->$fm_id;
                $fm_update_id[$index++] = $fm_id;
                // if($has_image && $isupdate ){
                //     DB::table('file_managers')->where('is_image', 1)->where('table_id',$id)->delete();
                //     $has_image=false;
                // }
                // $file_data['file_path'] = $request->$key;
                // File_manager::create($file_data);

            }
        }

        if ($isupdate) {
            $get_request_id = $request->file_id;
            $get_request_id = json_decode($get_request_id, true);
            $length = count($get_request_id);
            for ($i = 0; $i < $length; $i++) {
                if (!in_array($get_request_id[$i], $fm_update_id)) {
                    $old_file = File_manager::findOrFail($get_request_id[$i]);
                    if (file_exists(public_path($old_file->file_path))) {
                        unlink(public_path($old_file->file_path));
                    }
                    \DB::table('file_managers')->where('id', $get_request_id[$i])->where('table_id', $id)->delete();
                }
            }
        }
        // dd('no');
        return true;
    }

    public function searching($request = [])
    {

        $user = Auth::user();

        if ($user->role == 14) {
            $data = \DB::query()
                ->select(['r1.*', 'r2.*'])
                ->fromSub(function ($query) {
                    $query->select(['d.id', 'd.description', 'd.created_at as date', 'd.user_id', 'd.component_id', 'c.package_no', 'c.name_en', 't.title'])
                        ->from('data_acquisitions as d')
                        ->leftJoin('components as c', 'c.id', '=', 'd.component_id')
                        ->leftJoin('data_input_titles as t', 't.id', '=', 'd.data_input_title_id');
                }, 'r1')
                ->leftJoinSub(function ($query) {
                    $query->select(['u.name as created', 'f.file_path', 'f.is_approve', 'f.fm_category_id', 'f.table_id as table_id'])
                        ->from('file_managers  as f')->where('f.fm_category_id', 38)
                        ->leftJoin('users as u', 'u.id', '=', 'f.created_by');
                    // ->leftJoin('users as ap','ap.id','=','f.approval_by');
                }, 'r2', 'r2.table_id', '=', 'r1.id')->where([['r1.component_id', $request->package_id], ['r1.user_id', $user->id]])
                ->paginate(20);
        } else if ($user->role == 15) {
            if ($request->user_id != 0 && $request->package_id != 0) {
                $data = \DB::query()
                    ->select(['r1.*', 'r2.*'])
                    ->fromSub(function ($query) {
                        $query->select(['d.id', 'd.description', 'd.created_at as date', 'd.user_id', 'd.component_id', 'c.package_no', 'c.name_en', 't.title'])
                            ->from('data_acquisitions as d')
                            ->leftJoin('components as c', 'c.id', '=', 'd.component_id')
                            ->leftJoin('data_input_titles as t', 't.id', '=', 'd.data_input_title_id');
                    }, 'r1')
                    ->leftJoinSub(function ($query) {
                        $query->select(['u.name as created', 'u.teamlead_id', 'f.file_path', 'f.is_approve', 'f.fm_category_id', 'f.table_id as table_id', 'u.id as user_id'])
                            ->from('file_managers  as f')->where('f.fm_category_id', 38)
                            ->leftJoin('users as u', 'u.id', '=', 'f.created_by');
                        // ->leftJoin('users as ap','ap.id','=','f.approval_by');
                    }, 'r2', 'r2.table_id', '=', 'r1.id')->where('r2.teamlead_id', $user->id)->where([['r2.user_id', $request->user_id], ['r1.component_id', $request->package_id]])
                    ->paginate(20);
            } else if ($request->user_id != 0) {
                $data = \DB::query()
                    ->select(['r1.*', 'r2.*'])
                    ->fromSub(function ($query) {
                        $query->select(['d.id', 'd.description', 'd.created_at as date', 'd.user_id', 'd.component_id', 'c.package_no', 'c.name_en', 't.title'])
                            ->from('data_acquisitions as d')
                            ->leftJoin('components as c', 'c.id', '=', 'd.component_id')
                            ->leftJoin('data_input_titles as t', 't.id', '=', 'd.data_input_title_id');
                    }, 'r1')
                    ->leftJoinSub(function ($query) {
                        $query->select(['u.name as created', 'u.teamlead_id', 'f.file_path', 'f.is_approve', 'f.fm_category_id', 'f.table_id as table_id', 'u.id as user_id'])
                            ->from('file_managers  as f')->where('f.fm_category_id', 38)
                            ->leftJoin('users as u', 'u.id', '=', 'f.created_by');
                        // ->leftJoin('users as ap','ap.id','=','f.approval_by');
                    }, 'r2', 'r2.table_id', '=', 'r1.id')->where('r2.teamlead_id', $user->id)->where('r2.user_id', $request->user_id)
                    ->paginate(20);
            } else if ($request->package_id != 0) {
                $data = \DB::query()
                    ->select(['r1.*', 'r2.*'])
                    ->fromSub(function ($query) {
                        $query->select(['d.id', 'd.description', 'd.created_at as date', 'd.user_id', 'd.component_id', 'c.package_no', 'c.name_en', 't.title'])
                            ->from('data_acquisitions as d')
                            ->leftJoin('components as c', 'c.id', '=', 'd.component_id')
                            ->leftJoin('data_input_titles as t', 't.id', '=', 'd.data_input_title_id');
                    }, 'r1')
                    ->leftJoinSub(function ($query) {
                        $query->select(['u.name as created', 'u.teamlead_id', 'f.file_path', 'f.is_approve', 'f.fm_category_id', 'f.table_id as table_id', 'u.id as user_id'])
                            ->from('file_managers  as f')->where('f.fm_category_id', 38)
                            ->leftJoin('users as u', 'u.id', '=', 'f.created_by');
                        // ->leftJoin('users as ap','ap.id','=','f.approval_by');
                    }, 'r2', 'r2.table_id', '=', 'r1.id')->where('r2.teamlead_id', $user->id)->where('r1.component_id', $request->package_id)
                    ->paginate(20);
            }
        } else {
            //dd($request->all());
            if ($request->user_id != 0 && $request->package_id != 0) {
                $data = \DB::query()
                    ->select(['r1.*', 'r2.*'])
                    ->fromSub(function ($query) {
                        $query->select(['d.id', 'd.description', 'd.created_at as date', 'd.component_id', 'c.package_no', 'c.name_en', 't.title', 'd.user_id'])
                            ->from('data_acquisitions as d')
                            ->leftJoin('components as c', 'c.id', '=', 'd.component_id')
                            ->leftJoin('data_input_titles as t', 't.id', '=', 'd.data_input_title_id');
                    }, 'r1')
                    ->leftJoinSub(function ($query) {
                        $query->select(['u.name as created', 'f.file_path', 'f.is_approve', 'f.fm_category_id', 'f.table_id as table_id', 'u.id as user_id'])
                            ->from('file_managers  as f')->where([['f.fm_category_id', 38], ['is_approve', 1]])
                            ->leftJoin('users as u', 'u.id', '=', 'f.created_by');
                        // ->leftJoin('users as ap','ap.id','=','f.approval_by');
                    }, 'r2', 'r2.table_id', '=', 'r1.id')->where([['r2.user_id', $request->user_id], ['r1.component_id', $request->package_id]])
                    ->paginate(20);
            } else if ($request->user_id != 0) {
                // dd('u');
                $data = \DB::query()
                    ->select(['r1.*', 'r2.*'])
                    ->fromSub(function ($query) {
                        $query->select(['d.id', 'd.description', 'd.created_at as date', 'd.component_id', 'c.package_no', 'c.name_en', 't.title', 'd.user_id'])
                            ->from('data_acquisitions as d')
                            ->leftJoin('components as c', 'c.id', '=', 'd.component_id')
                            ->leftJoin('data_input_titles as t', 't.id', '=', 'd.data_input_title_id');
                    }, 'r1')
                    ->leftJoinSub(function ($query) {
                        $query->select(['u.name as created', 'f.file_path', 'f.is_approve', 'f.fm_category_id', 'f.table_id as table_id', 'u.id as user_id'])
                            ->from('file_managers  as f')->where([['f.fm_category_id', 38], ['is_approve', 1]])
                            ->leftJoin('users as u', 'u.id', '=', 'f.created_by');
                        // ->leftJoin('users as ap','ap.id','=','f.approval_by');
                    }, 'r2', 'r2.table_id', '=', 'r1.id')->where('r2.user_id', $request->user_id)
                    ->paginate(20);
            } else if ($request->package_id != 0) {
                //dd('ye');
                $data = \DB::query()
                    ->select(['r1.*', 'r2.*'])
                    ->fromSub(function ($query) {
                        $query->select(['d.id', 'd.description', 'd.created_at as date', 'd.component_id', 'c.package_no', 'c.name_en', 't.title', 'd.user_id'])
                            ->from('data_acquisitions as d')
                            ->leftJoin('components as c', 'c.id', '=', 'd.component_id')
                            ->leftJoin('data_input_titles as t', 't.id', '=', 'd.data_input_title_id');
                    }, 'r1')
                    ->leftJoinSub(function ($query) {
                        $query->select(['u.name as created', 'f.file_path', 'f.is_approve', 'f.fm_category_id', 'f.table_id as table_id', 'u.id as user_id'])
                            ->from('file_managers  as f')->where([['f.fm_category_id', 38], ['is_approve', 1]])
                            ->leftJoin('users as u', 'u.id', '=', 'f.created_by');
                        // ->leftJoin('users as ap','ap.id','=','f.approval_by');
                    }, 'r2', 'r2.table_id', '=', 'r1.id')->where('r1.component_id', $request->package_id)
                    ->paginate(20);
            }
        }
        $search = [];
        $search[0] = $request->package_id;
        $search[1] = $request->user_id;
        $package = \App\Component::select('id', 'package_no', 'name_en')->get();
        $user = \App\User::select('id', 'name')->where('role', 14)->get();
        return view('app_image.index', compact('data', 'package', 'search', 'user'));
    }

    public function old_index(Request $request)
    {
        // return \App\data_acquisition::with(['file_managers'=>function($q){
        //     $q->where('id',442);
        // }])->find(40);

        if ($request->package_id || $request->user_id) {
            return $this->searching($request);
        }
        $user = Auth::user();

        if ($user->role == 14) {
            // dd($user->role);
            $data = \DB::query()
                ->select(['r1.*', 'r2.*'])
                ->fromSub(function ($query) {
                    $query->select(['d.id', 'd.description', 'd.created_at as date', 'd.user_id', 'c.package_no', 'c.name_en', 't.title'])
                        ->from('data_acquisitions as d')
                        ->leftJoin('components as c', 'c.id', '=', 'd.component_id')
                        ->leftJoin('data_input_titles as t', 't.id', '=', 'd.data_input_title_id');
                }, 'r1')
                ->leftJoinSub(function ($query) {
                    $query->select(['u.name as created', 'f.file_path', 'f.is_approve', 'f.fm_category_id', 'f.table_id as table_id'])
                        ->from('file_managers  as f')->where('f.fm_category_id', 38)
                        ->leftJoin('users as u', 'u.id', '=', 'f.created_by');
                    // ->leftJoin('users as ap','ap.id','=','f.approval_by');
                }, 'r2', 'r2.table_id', '=', 'r1.id')->where('r1.user_id', $user->id)
                ->paginate(20);
        } else if ($user->role == 15) {
            $data = \DB::query()
                ->select(['r1.*', 'r2.*'])
                ->fromSub(function ($query) {
                    $query->select(['d.id', 'd.description', 'd.created_at as date', 'd.user_id', 'c.package_no', 'c.name_en', 't.title'])
                        ->from('data_acquisitions as d')
                        ->leftJoin('components as c', 'c.id', '=', 'd.component_id')
                        ->leftJoin('data_input_titles as t', 't.id', '=', 'd.data_input_title_id');
                }, 'r1')
                ->leftJoinSub(function ($query) {
                    $query->select(['u.name as created', 'u.teamlead_id', 'f.file_path', 'f.is_approve', 'f.fm_category_id', 'f.table_id as table_id'])
                        ->from('file_managers  as f')->where('f.fm_category_id', 38)
                        ->leftJoin('users as u', 'u.id', '=', 'f.created_by');
                    // ->leftJoin('users as ap','ap.id','=','f.approval_by');
                }, 'r2', 'r2.table_id', '=', 'r1.id')->where('r2.teamlead_id', $user->id)
                ->paginate(20);
        } else {

            $data = \DB::query()
                ->select(['r1.*', 'r2.*'])
                ->fromSub(function ($query) {
                    $query->select(['d.id', 'd.description', 'd.created_at as date', 'c.package_no', 'c.name_en', 't.title', 'd.user_id'])
                        ->from('data_acquisitions as d')
                        ->leftJoin('components as c', 'c.id', '=', 'd.component_id')
                        ->leftJoin('data_input_titles as t', 't.id', '=', 'd.data_input_title_id');
                }, 'r1')
                ->leftJoinSub(function ($query) {
                    $query->select(['u.name as created', 'f.file_path', 'f.is_approve', 'f.fm_category_id', 'f.table_id as table_id'])
                        ->from('file_managers  as f')->where('f.fm_category_id', 38)
                        ->leftJoin('users as u', 'u.id', '=', 'f.created_by');
                    // ->leftJoin('users as ap','ap.id','=','f.approval_by');
                }, 'r2', 'r2.table_id', '=', 'r1.id')->where('r2.is_approve', 1)
                ->paginate(20);

            //dd($data);
        }
        $search = [];
        $search[0] = '';
        $search[1] = '';
        $package = \App\Component::select('id', 'package_no', 'name_en')->get();
        $user = \App\User::select('id', 'name')->where('role', 14)->get();
        return view('app_image.index', compact('data', 'package', 'search', 'user'));

    }
}