<?php

namespace App\Http\Controllers\Admin;

use App\File_manager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Validator\validatorForm;
use App\Http\Controllers\Controller;

class DashboardDynamicImageController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'name_en' => 'nullable',
        'name_bn' => 'nullable',
        'image'   => 'nullable',
        'status'  => 'required'
    );

    public function index()
    {

        $images = File_manager::where('fm_category_id',37)->paginate(20);
        //dd($image);
        return view('admin.dashboard_dynamic_image.index',compact('images'));
    }

    public function create()
    {
        return view('admin.dashboard_dynamic_image.create');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $unit = $this->getFormData($request->all(),$this->rules);
            if($request->file('image')){
                $fileName = Str::random(25).'-.-'. $unit['image']->getClientOriginalName();
                //dd($fileName);
                $unit['image']->move(public_path('storage/dashboard_dynamic'), $fileName);

                $file_managers = new File_manager;
                $file_managers->name           = $unit['name_en'];
                $file_managers->fm_category_id = 37;
                $file_managers->file_path = 'storage/dashboard_dynamic/'.$fileName;
                $file_managers->description = $unit['name_bn'];
                $file_managers->is_image = 1;
                $file_managers->table_id = 0;
                $file_managers->is_approve = $unit['status'];

                $file_managers->save();

                return redirect('/dashboard_dynamic_image')->with('toast_success','Image added Successfully.');
            }
        }
        return back()->with('toast_error', $response)->withInput();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $image = File_manager::find($id);
        return view('admin.dashboard_dynamic_image.edit',compact('image'));
    }


    public function update(Request $request, $id)
    {
         //dd($request->all());
         $response = $this->validationWithJson($request->all(),$this->rules);
         if($response===true){
            $unit = $this->getFormData($request->all(),$this->rules);

                $file_managers = File_manager::find($id);
                 //dd($file_managers);
                $path = $file_managers->file_path;

                if($request->file('image')){
                    $fileName = Str::random(25).'-.-'. $unit['image']->getClientOriginalName();
                     //dd($fileName);
                    $unit['image']->move(public_path('storage/dashboard_dynamic'), $fileName);
                    $path = 'storage/dashboard_dynamic/'.$fileName;
                }

                $file_managers->name           = $unit['name_en'];
                $file_managers->fm_category_id = 37;
                $file_managers->file_path      = $path;
                $file_managers->description    = $unit['name_bn'];
                $file_managers->is_image       = 1;
                $file_managers->table_id       = 0;
                $file_managers->is_approve     = $unit['status']; //for active and In-Active

                $file_managers->save();

                return redirect('/dashboard_dynamic_image')->with('toast_success','Image added Successfully.');

         }
         return back()->with('toast_error', $response)->withInput();
    }

    public function destroy($id)
    {
        //dd('yws');
        $unit = File_manager::find($id);

        if (file_exists(public_path($unit->file_path))) {
            unlink(public_path($unit->file_path));
        }
        $unit->delete();
        return $this->responseWithSuccess('Data Deleted successfully','success');
    }
}
