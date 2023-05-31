<?php

namespace App\Http\Controllers\Api;

use App\Type;
use App\Component;
use Illuminate\Http\Request;
use App\Validator\apiResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProcurementController extends Controller
{
    use apiResponse;
    public function index(Request $request,$type_id=null)
    {
        $type_id = 1;
        if( $request->type_id ){
            $type_id = $request->type_id;
        }
        //return $type_id;
        $all_package = [];
        $type  = Type::whereIn('id',[1,2,3])->select('id','name_en')->get();
        $goods = Component::where('type_id',$type_id)->orderby('package_no')->select('id','package_no','name_en','contract_price_act_bdt as amount')->get();

        $sum = DB::table('components')->where('type_id',$type_id)->sum('contract_price_act_bdt');
        $package_chart = $this->get_pie_chart_data_total_package($sum,$type_id);
       // dd($goods[0]->id);
        // $works= Component::where('type_id',2)->orderby('package_no')->select('id','package_no','name_en')->get();
        // $service= Component::where('type_id',3)->orderby('package_no')->select('id','package_no','name_en')->get();
        
        $all_package['package_type'] = $type;
        $all_package['package']   = $goods;
        $all_package['package_chart']   = $package_chart;
        //$all_package['service'] = $service;
        

        return $this->responseApiWithSuccess('succeessfully',$all_package);

    }

    public static function get_pie_chart_data_total_package($total_amount, $type_id)
    {
        $query_data= DB::select("SELECT SUM(cost_tk_est) AS cost,package_no FROM components where type_id=$type_id
                GROUP BY package_no");

        $amount= $total_amount;
        $data=[];
        $i=0;

        foreach($query_data as $item)
        {
            $data[$i]['name']= $item->package_no;
            $data[$i]['y']= ($item->cost / $amount)*100;
            $i++;
        }
        return $data;
        //return json_encode($data);
    }
}
