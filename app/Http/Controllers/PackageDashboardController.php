<?php

namespace App\Http\Controllers;

use DB;
use App\Component;
use App\Indicator;
use App\Indicator_data;
use Illuminate\Http\Request;
use App\Works_package_payment;

class PackageDashboardController extends Controller
{
    public function index($id,$isclass=false)
    {
        $total_perchantage = $this->total_percentage($id);
        $details=Component::find($id);
        $total_payment = DB::table('works_package_payments')->where('package_id',$id)->where('is_package',1)->sum('amount');
        // $total_payment = DB::select("SELECT SUM(r.amount) AS payment FROM
        //     (SELECT * FROM works_package_payments AS w WHERE w.is_package=1 AND w.`package_id`=$id) AS r
        //     GROUP BY r.package_id");
        //if($total_payment)
        if($details->contract_price_act_bdt){
            $total_payment_percentage = ($total_payment/$details->contract_price_act_bdt)*100;
        }else{
            $total_payment_percentage=0;
        }
        //dd($total_payment[0]->payment);
        $jquery_css=false;
        //$id=$request->id;
        $indicator_list=Indicator::where('component_id',$id)->where('indicator_category_id',1)->get();
        $indicator_data=[];
        //dd($details->contract_price_act_bdt);
        if($indicator_list)
        {
            $indicator_keys=[];
            foreach($indicator_list as $r)
            {
                $indicator_keys[$r->id]=$r->id;
            }
            //dd($indicator_keys);
            $indicator_str=implode(',',array_keys($indicator_keys));
            if($indicator_str == "")
            {
                $indicator_str=0;
            }
            $sql=" SELECT indicator_id,SUM(progress_value) AS achivement,SUM(achievement_quantity) AS qty FROM `indicator_datas`
            WHERE ( indicator_id IN ($indicator_str)
            and is_approve=1)
            GROUP BY indicator_id ";
            $indicator_data_query=DB::select(DB::raw($sql));
            //dd($indicator_data_query);
            foreach($indicator_data_query as $r)
            {
                $indicator_data[$r->indicator_id]['achivement']=$r->achivement;
                $indicator_data[$r->indicator_id]['qty']=$r->qty;
            }
        }
        if($isclass){
            return  view('packageDashboard.work_in_progress_table',compact('details','indicator_list','indicator_data','jquery_css'));
        }
        //dd($indicator_data);
        return  view('packageDashboard.index',compact('details','indicator_list','indicator_data','total_perchantage','total_payment_percentage',  'jquery_css'));

    }
    public function get_file(Request $request)
    {
        //dd($request->all());
        $package_id = $request->component_id;
        if($request->tab_id==3){
            $file_list=DB::select(" SELECT * FROM file_managers AS f WHERE f.`table_id`=$request->component_id AND f.`fm_category_id`=5 ");
            return view('packageDashboard.file_upload_table',compact('file_list','package_id'));
        }
        if($request->tab_id==1){
            return $this->index($request->component_id,true);
            //return  view('packageDashboard.work_in_progress_table',compact('details','indicator_list','indicator_data','jquery_css'));
        }
    }

    public function indicator_details(Request $request)
    {
       // dd($request->indicator_id);
       $indicator_id= $request->indicator_id;
    //    DB::table('indicator_datas')
    //                        ->where('indicator_id',$indicator_id)
    //                        ->get()
       $indicator_details= Indicator_data::with('indicator')->where('indicator_id',$indicator_id)->where('is_approve',1)->get();
       //dd($indicator_details);
       return response()->json($indicator_details);
    }

    public function total_percentage($id)
    {

        // $data = DB::query()
        // ->fromSub(function($query){
        //     $query->select(['data.indicator_id', DB::raw('sum(data.achievement_quantity) as quantity'),DB::raw( 'sum(data.progress_value) as progress ' )])
        //             ->from('indicator_datas as data')
        //             ->where('data.component_id',8)
        //             ->groupBy(['data.indicator_id']);
        //     },'at')
        // ->leftJoinSub(function($query){
        //     $query->select(['ind.id','ind.ave_weightage','ind.target'])
        //     ->from('indicators as ind')
        //     ->where('ind.ave_weightage','!=',null);
        // },'in','in.id','=','at.indicator_id')
        // //->toSql();
        // ->get();
        // dd($data);
        $sql = "select * from (select `data`.`indicator_id`, sum(data.achievement_quantity) as quantity, sum(data.progress_value) as progress  from `indicator_datas` as `data` where `data`.`component_id` = $id AND `data`.`is_approve`=1  group by `data`.`indicator_id`) as `at` left join (select `ind`.`id`, `ind`.`ave_weightage`, `ind`.`target` from `indicators` as `ind` where `ind`.`ave_weightage` is not null) as `in` on `in`.`id` = `at`.`indicator_id`";
        $data=DB::select($sql);
        //dd($data);
        $total_perchantage=0;
        foreach($data as $r)
        {
            if($r->ave_weightage){
                $total_perchantage += ($r->ave_weightage * $r->progress)/100;
            }
        }
        return $total_perchantage;

    }

    public function all_payment(Request $request)
    {
        //dd($request->indicator_id);
        $payment = Works_package_payment::with('contactor','source_of_fund')->where('package_id',$request->indicator_id)->where('is_package',1)->get();
        return response([
            'data'=> $payment
        ]);
       // return view('packageDashboard.payment_details',compact('payment'));
    }
}
