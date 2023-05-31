<?php

namespace App\Http\Controllers\Api;

use App\Component;
use App\data_input_title;
use App\Http\Controllers\Controller;
use App\User;
use App\Validator\apiResponse;
use App\Validator\validatorForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    use apiResponse, validatorForm;
    protected $login_rules = array(
        'email' => 'required|email',
        'password' => 'required|min:6',
    );

    public function login(Request $request)
    {
        $login = $this->validationWithJson($request->all(), $this->login_rules);
        if ($login === true) {
            $login = $this->getFormData($request->all(), $this->login_rules);
            if (!Auth::attempt($login)) {
                return $this->responseApiWithError('Invalid Credential', $login);
            }

            $accesstoken = Auth::user()->createToken('authToken')->accessToken;
            $package = DB::table('components')->select('id', 'package_no', 'name_en as name')->orderby('package_no')->get();

            $p = [];
            $i = 0;
            foreach ($package as $r) {
                $p[$i]['id'] = $r->id;
                $p[$i]['package_no'] = $r->package_no . ' - ' . $r->name;
                $i++;
            }

            //$title = data_input_title::select('id','title','component_id')->orderBy('component_id')->get();

            $purpose = \App\Component::with('title:component_id,id,title as name')->select('id', 'package_no', 'name_en', DB::raw('CONCAT(package_no, \' \', name_en) AS package_no'))->where('type_id', '!=', 1)->get();

            $district = \App\District::with('unions:district_id,id,name')->select('id', 'name')->get();

            $data_acquisition = [];
            //$data_acquisition['title']=$purpose_data;
            $data_acquisition['package'] = $purpose;
            $data_acquisition['district'] = $district;
            //$data_acquisition['union']=$union_data;

            $permission = \App\PermissionRole::where('role_id', Auth::user()->role)->where('permission_id', 198)->get();

            if ($permission->isEmpty() && Auth::user()->name != 'Admin') {
                $package = [];
                $package[0]['id'] = 0;
                $package[0]['package_no'] = 'No Data Found';

            }

            $data['user'] = Auth::user();
            $data['token'] = $accesstoken;
            $data['drawer_menu'] = $package;
            $data['data_acquisition'] = $data_acquisition;

            return $this->responseApiWithSuccess('User login successfully', $data);
        } else {
            return $this->responseApiWithError('Error', $login);
        }

    }

    public function logout()
    {

    }

    public function index()
    {
        $data = array();

        $data[0]['id'] = 1;
        $data[0]['name'] = 'emcrp project information - dphe part';

        $data[1]['id'] = 2;
        $data[1]['name'] = 'procurement status';

        $data[2]['id'] = 3;
        $data[2]['name'] = 'Training Status';

        $data[3]['id'] = 4;
        $data[3]['name'] = 'Drawing & Design';

        $data[4]['id'] = 5;
        $data[4]['name'] = 'Report';

        $data[5]['id'] = 6;
        $data[5]['name'] = 'GIS';

        $data[6]['id'] = 7;
        $data[6]['name'] = 'Financial Status';

        $data[7]['id'] = 8;
        $data[7]['name'] = 'Monitoring and Supervision Status';

        $data[8]['id'] = 9;
        $data[8]['name'] = 'Data Acquisition';

        $permission_id_array = $this->permission();
        $p_data = [];
        $i = 0;

        foreach ($permission_id_array as $d) {
            $p_data[$i]['id'] = $data[$d]['id'];
            $p_data[$i]['name'] = $data[$d]['name'];
            $i++;
        }

        $data_1 = array();
        $data_1['dashboard_menu'] = $p_data;

        return $this->responseApiWithSuccess('Dashboard menu get successfully', $data_1);

    }

    public function permission()
    {
        $permission_id = array(199, 200, 201, 202, 203, 204, 205, 206, 207);
        $user = Auth::user();
        $permission = \App\PermissionRole::where('role_id', $user->role)->whereIn('permission_id', $permission_id)->get();
        $permission_array = [];
        $i = 0;
        foreach ($permission as $p) {
            $permission_array[$i++] = $p->permission_id - 199;
        }
        return $permission_array;
    }

    public function old_login(Request $request)
    {
        $login = $this->validationWithJson($request->all(), $this->login_rules);
        if ($login === true) {
            $login = $this->getFormData($request->all(), $this->login_rules);
            if (!Auth::attempt($login)) {
                return $this->responseApiWithError('Invalid Credential', $login);
            }

            $accesstoken = Auth::user()->createToken('authToken')->accessToken;
            $package = DB::table('components')->select('id', 'package_no', 'name_en as name')->orderby('package_no')->get();

            $p = [];
            $i = 0;
            foreach ($package as $r) {
                $p[$i]['id'] = $r->id;
                $p[$i]['package_no'] = $r->package_no . ' - ' . $r->name;
                $i++;
            }

            $title = data_input_title::select('id', 'title')->get();

            $data_acquisition = [];
            $data_acquisition['title'] = $title;
            $data_acquisition['package'] = $p;

            $data['user'] = Auth::user();
            $data['token'] = $accesstoken;
            $data['drawer_menu'] = $package;
            $data['data_acquisition'] = $data_acquisition;

            return $this->responseApiWithSuccess('User login successfully', $data);
        } else {
            return $this->responseApiWithError('Error', $login);
        }

    }

}