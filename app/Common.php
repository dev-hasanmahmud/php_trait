<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Component;
use DB;

class Common extends Model
{
    public static function get_menu_item_for_package()
    {
        $data=Component::orderBy('package_no')->get();
        $menu=[];
        foreach($data as $r)
        {
            $menu[$r->id]['name']=($r->package_no)?$r->package_no:$r->name_en;
        }
        return $menu;
    }
    //total package
    public static function get_total_package_data()
    {
        $results= DB::table('components')
                 ->orderby('id','ASC')
                 ->select('id','package_no','name_en','contract_price_act_bdt as  cost_tk_est')
                 ->paginate(10);
                //  $results = DB::select("SELECT c.id,c.package_no,c.name_en,c.contract_price_act_bdt AS cost_tk_est,p.* FROM components AS c LEFT JOIN (SELECT r.package_id,SUM(r.amount) AS payment FROM (SELECT * FROM works_package_payments AS w WHERE w.is_package=1) AS r GROUP BY r.package_id) AS p ON c.id=p.package_id LIMIT 10 OFFSET 10
                //  ");
        $results = DB::query()
            ->select(['train.*','at.*'])
            ->fromSub(function($query){
                $query->select(['t.id','t.package_no','t.name_en','t.contract_price_act_bdt as  cost_tk_est'])
                        ->from('components as t');
                         //->where('t.id','=',1);
                 },'train')
            ->leftJoinSub(function($query){
                $query->select(['ta.package_id', DB::raw( 'sum(ta.amount) as payment ' )])
                    ->from('works_package_payments as ta')
                    ->where('ta.is_package',1)
                    ->groupBy(['ta.package_id']);
            },'at','train.id','=','at.package_id')
            //->toSql();
            ->paginate(10);
        //dd($results);
        return $results;
    }

    public static function sum_of_total_package_amount()
    {
        $sum = DB::table('components')->sum('contract_price_act_bdt');//cost_tk_est
        return $sum;
    }

    public static function get_pie_chart_data_total_package($total_amount)
    {
        $query_data= DB::select("SELECT SUM(contract_price_act_bdt) AS cost,package_no FROM components
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
        return json_encode($data);
    }
    //end total package

    //total package tender call
    public static function get_total_package_tender_call_data()
    {
        // $results= DB::table('components')
        //          ->orderby('id','ASC')
        //          ->select('id','package_no','name_en','cost_tk_est')
        //          ->paginate(10);
        $results = DB::query()
            ->select(['train.*','at.*'])
            ->fromSub(function($query){
                $query->select(['t.id','t.package_no','t.name_en','t.contract_price_act_bdt as  cost_tk_est'])
                        ->from('components as t');
                         //->where('t.id','=',1);
                 },'train')
            ->leftJoinSub(function($query){
                $query->select(['ta.package_id', DB::raw( 'sum(ta.amount) as payment ' )])
                    ->from('works_package_payments as ta')
                    ->where('ta.is_package',1)
                    ->groupBy(['ta.package_id']);
            },'at','train.id','=','at.package_id')
            //->toSql();
            ->paginate(10);
        return $results;
    }

    public static function sum_of_total_package_tender_call_amount()
    {
        $sum = DB::table('components')->sum('contract_price_act_bdt');
        return $sum;
    }

    public static function get_pie_chart_data_total_package_tender_call($total_amount)
    {
        $query_data= DB::select("SELECT SUM(contract_price_act_bdt) AS cost,package_no FROM components
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
        return json_encode($data);
    }
    //end total package tender call

     //tender call
    public static function get_tender_call_data()
    {
        // $results= DB::table('components')
        //          ->orderby('id','ASC')
        //          ->select('id','package_no','name_en','cost_tk_est')
        //          ->paginate(10);
        $results = DB::query()
            ->select(['train.*','at.*'])
            ->fromSub(function($query){
                $query->select(['t.id','t.package_no','t.name_en','t.contract_price_act_bdt as  cost_tk_est'])
                        ->from('components as t');
                         //->where('t.id','=',1);
                 },'train')
            ->leftJoinSub(function($query){
                $query->select(['ta.package_id', DB::raw( 'sum(ta.amount) as payment ' )])
                    ->from('works_package_payments as ta')
                    ->where('ta.is_package',1)
                    ->groupBy(['ta.package_id']);
            },'at','train.id','=','at.package_id')
            //->toSql();
            ->paginate(10);
        return $results;
    }

    public static function sum_of_tender_call_amount()
    {
        $sum = DB::table('components')->sum('contract_price_act_bdt');
        return $sum;
    }

    public static function get_pie_chart_data_tender_call($total_amount)
    {
        $query_data= DB::select("SELECT SUM(contract_price_act_bdt) AS cost,package_no FROM components
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
        return json_encode($data);
    }
    //end total package tender call

    //tender call
    public static function contract_in_progress()
    {
        // $results= DB::table('components')
        //          ->orderby('id','ASC')
        //          ->select('id','package_no','name_en','cost_tk_est')
        //          ->paginate(10);
        $results = DB::query()
            ->select(['train.*','at.*'])
            ->fromSub(function($query){
                $query->select(['t.id','t.package_no','t.name_en','t.contract_price_act_bdt as  cost_tk_est'])
                        ->from('components as t');
                         //->where('t.id','=',1);
                 },'train')
            ->leftJoinSub(function($query){
                $query->select(['ta.package_id', DB::raw( 'sum(ta.amount) as payment ' )])
                    ->from('works_package_payments as ta')
                    ->where('ta.is_package',1)
                    ->groupBy(['ta.package_id']);
            },'at','train.id','=','at.package_id')
            //->toSql();
            ->paginate(10);
        return $results;
    }

    public static function sum_of_contract_in_progress_amount()
    {
        $sum = DB::table('components')->sum('contract_price_act_bdt');
        return $sum;
    }

    public static function get_pie_chart_data_contract_in_progress($total_amount)
    {
        $query_data= DB::select("SELECT SUM(contract_price_act_bdt) AS cost,package_no FROM components
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
        return json_encode($data);
    }
    //end total package tender call

    public static function procurement_management_dashboard()
    {
          //total package
        $dynamic_images = File_manager::where('fm_category_id',37)->where('is_approve',1)->orderBy('id','DESC')->get();
        $package= Common::get_total_package_data();
        $total_amount= Common::sum_of_total_package_amount();
        $total_package_chart= Common::get_pie_chart_data_total_package($total_amount);

        //Total Package Tender Call
        $package_tender_call= Common::get_total_package_tender_call_data();
        $total_amount_tender_call= Common::sum_of_total_package_tender_call_amount();
        $total_package_tender_call_chart= Common::get_pie_chart_data_total_package_tender_call($total_amount_tender_call);

        //tender call
        $tender_call= Common::get_tender_call_data();
        $amount_tender_call= Common::sum_of_tender_call_amount();
        $total_package_tender_call_chart= Common::get_pie_chart_data_tender_call($amount_tender_call);

         //contract in progress
        $contract_in_progress= Common::contract_in_progress();
        $total_amount_contract_in_progress= Common::sum_of_contract_in_progress_amount();
        $contract_in_progress_chart= Common::get_pie_chart_data_contract_in_progress($amount_tender_call);
        //dd($package);
        return view('dashboard.index',['dynamic_images'=>$dynamic_images,'package'=>$package,'total_amount'=>$total_amount,'total_package_chart'=>$total_package_chart,
                                      'package_tender_call'=>$package_tender_call,'total_amount_tender_call'=>$total_amount_tender_call,'total_package_tender_call_chart'=>$total_package_tender_call_chart,
                                      'tender_call'=>$tender_call,'amount_tender_call'=>$amount_tender_call,'total_package_tender_call_chart'=>$total_package_tender_call_chart,
                                      'contract_in_progress'=>$contract_in_progress,'total_amount_contract_in_progress'=>$total_amount_contract_in_progress,'contract_in_progress_chart'=>$contract_in_progress_chart ]);
    }
}
