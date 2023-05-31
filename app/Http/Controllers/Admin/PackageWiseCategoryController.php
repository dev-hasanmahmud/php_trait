<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Validator\validatorForm;
use Illuminate\Http\Request;

class PackageWiseCategoryController extends Controller
{

    use validatorForm;
    protected $rules = array(
        'package_id' => 'nullable',
        'file_category_id' => 'required',
    );

    public function index()
    {
        //$categories = \DB::table('package_report_category_order')->get();
        ///return $categories;
        $packages = \App\Component::orderBy('package_no')->paginate(20);
        return view('admin.packageCategory.index', compact('packages'));
    }

    public function create()
    {
        $categories = \App\File_manager_category::whereParent_id(15)->get();
        $packages = \App\Component::orderBy('package_no')->get();
        //  return $categories;
        return view('admin.packageCategory.create', compact('categories', 'packages'));
    }

    public function store(Request $request)
    {
        $categoryId = json_encode($request['file_category_id'], true);
        $packageId = $request->package_id;
        //dd($categoryId);
        $sql = "UPDATE `package_report_category_order` SET `file_category_id` = '$categoryId', `created_at` = NULL, `updated_at` = NULL WHERE `package_report_category_order`.`package_id` = $packageId;
            ";
        \DB::select($sql);

        return response()->json([
            'status' => 'ok',
        ]);

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        
        $categories = \App\File_manager_category::whereParent_id(15)->get();
        //return $id;
        $package = \App\Component::whereId($id)->first();
        $categiryList = \DB::table('package_report_category_order')->wherePackage_id($id)->get();
       
        if( !$categiryList->isEmpty()){
            $list = $categiryList[0]->file_category_id; 
        }else{
            $packageId = $id;
            $categoryId= [];
            foreach($categories as $item){
                
                array_push($categoryId,$item->id);
            }
            $categoryId = json_encode($categoryId);
            $sql = "INSERT INTO `package_report_category_order` (`id`, `package_id`, `file_category_id`, `created_at`, `updated_at`) VALUES (NULL, '$packageId', '$categoryId', NULL, NULL);";
            \DB::select($sql);
            
            $categiryList = \DB::table('package_report_category_order')->wherePackage_id($id)->get();
            $list = $categiryList[0]->file_category_id;
        }
       // return $list;
        $package_category_order_id = json_decode($list);
        $order_id = '';
        foreach ($package_category_order_id as $key => $value) {
            $order_id = $order_id . $value . ',';
        }
        $order_id = $order_id . '0';

        $ownCategory = \App\File_manager_category::whereIn('id', $package_category_order_id)->orderByRaw("FIELD(id,$order_id)")->get();
        //return $ownCategory;
        return view('admin.packageCategory.create', compact('package','categories', 'ownCategory', 'categiryList', 'list'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $response = $this->validationWithJson($request->all(), $this->rules);
        if ($response === true) {
            $category = $this->getFormData($request->all(), $this->rules);

            $categoryId = json_encode($category['file_category_id'], true);
            $packageId = $id;
            // dd($category);
            $sql = "UPDATE `package_report_category_order` SET `file_category_id` = '$categoryId', `created_at` = NULL, `updated_at` = NULL WHERE `package_report_category_order`.`package_id` = $id;
            ";
            \DB::select($sql);
            return redirect('/package-category-order')->with('toast_success', 'Report Category Order Updated Successfully.');
        }
        return back()->with('toast_error', $response)->withInput();
    }

    public function destroy($id)
    {
        //
    }

    // public function store(Request $request)
    // {
    //     return $request->all();
    //     $response = $this->validationWithJson($request->all(), $this->rules);
    //     if ($response === true) {
    //         $category = $this->getFormData($request->all(), $this->rules);

    //         $categoryId = json_encode($category['file_category_id'], true);
    //         $packageId = $category['package_id'];
    //         //dd($category);
    //         $sql = "INSERT INTO `package_report_category_order` (`id`, `package_id`, `file_category_id`, `created_at`, `updated_at`) VALUES (NULL, '$packageId', '$categoryId', NULL, NULL);";
    //         \DB::select($sql);
    //         return redirect('/package-category-order')->with('toast_success', 'Report Category Order Successfully.');
    //     }
    //     return back()->with('toast_error', $response)->withInput();
    // }
}