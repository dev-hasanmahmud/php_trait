<?php

namespace App\Http\Controllers;

use App\Common;
use App\Component;
use App\Source_of_fund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcurementController extends Controller
{
    public function index(Request $request)
    {
        //total package
        // $total_component = \App\Component::select(['type_id',\DB::raw('COUNT(*) as type_package')])->groupBy('type_id')->get();
        // return $total_component;
        if ($request->type_id) {
            $type_id = $request->type_id;
        } else {
            $type_id = 0;
        }
        //dd('ok');
        $packageName = ["0", "Goods", "Works", "Consulting Services","Non Consulting Service"];
        $packageName = $packageName[$type_id];
        $type_id = 0;
        $total_amount = DB::table('components')->sum('contract_price_act_bdt');
        if ($request->type_id) {
            $type_id = $request->type_id;
            $total_amount = DB::table('components')->where('type_id', $type_id)->sum('contract_price_act_bdt');
        }
        $package = $this->total_package_data($type_id);
        $total_package_chart = $this->get_pie_chart_data_total_package($total_amount, $type_id);

        $s = $this->chart();
        //dd($package);
        if ($request->page) {
            return view('procurement.new_table_1', compact('package'));
        }
        // dd($pie_chart_data);

        if ($request->type_id == 1 || $request->type_id == 2 || $request->type_id == 3 || $request->type_id == 4) {
            $data = $this->packageDetails($request->type_id);
            //if ($request->type_id == 3) {
            $consulting = $this->packageDetails(3);

            $nonConsulting = $this->packageDetails(4);
            //return $data;
            //}
            return view('procurement.index', compact('consulting', 'nonConsulting', 'data', 'package', 'total_amount', 'total_package_chart', 's', 'type_id', 'packageName'));
        }
        $newGraphData = $this->newGraph();
        $typeDetails = $newGraphData['typeDetails'];
        $paymentDetails = $newGraphData['paymentDetails'];

        $packageAmount = \DB::query()
            ->select(['in.type_id', \DB::raw('sum(in.contract_price_act_bdt) as amount ')])
            ->from('components as in')
            ->groupBy('in.type_id')
            ->get();
        $typeAmount = [0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($packageAmount as $p) {
            $typeAmount[$p->type_id] = $p->amount;
        }
        $totalPackage = \App\Component::select('type_id', DB::raw('count(*) as typePackage'))->groupBy('type_id')->get();
        $totalTypePackege = [0, 0, 0, 0, 0, 0, 0, 0, 0];
        $totalSumPackage = 0;
        foreach ($totalPackage as $key => $p) {
            $totalTypePackege[$p->type_id] = $p->typePackage;
            $totalSumPackage += $p->typePackage;
        }
        //return $totalPackage;

        return view('procurement.type_index', compact('typeAmount', 'typeDetails', 'paymentDetails', 'package', 'total_amount', 'total_package_chart', 's', 'type_id', 'totalTypePackege', 'totalSumPackage', 'packageName'));
    }
    public function packageDetails($type_id)
    {
        $packageTypeAmounts = \DB::query()
            ->select(['in.type_id', \DB::raw('sum(in.contract_price_act_bdt) as contactAmount '),
                \DB::raw('sum(in.cost_tk_act) as estimateCost ')])
            ->from('components as in')
            ->where('in.type_id', $type_id)
            ->groupBy('in.type_id')
            ->first();
        $components = Component::where('type_id', $type_id)
            ->select('id')
            ->get();
        $component_id = [];
        $cnt = 0;
        foreach ($components as $index => $c) {
            $component_id[$index] = $c->id;
            $cnt++;
        }

        $payment = \App\Works_package_payment::whereIn('package_id', $component_id)->sum('amount');

        $data['count'] = $cnt;
        $data['payment'] = $payment;
        if ($packageTypeAmounts) {
            $data['estimate'] = $packageTypeAmounts->estimateCost;
            $data['contact'] = $packageTypeAmounts->contactAmount;
        } else {
            $data['estimate'] = 0;
            $data['contact'] = 0;

        }
        //dd($data);
        return $data;
    }
    public function newGraph()
    {
        $type = \App\Type::select('id', 'name_en')->get();
        $typeDetails = [];
        $packageDetails = [];
        $colorArray = ["#7cb5ee","#C31A7F", "#1dda48", "orange", "#FFDF00", "#e02f40"];
        foreach ($type as $key => $value) {
            $component = Component::where('type_id', $value->id)
                ->select('id', 'package_no', 'contract_price_act_bdt')
                ->get();

            $component_id = [];
            $contractAmount = [];
            $packageName = [];
            $contractAmountSum = 0;

            foreach ($component as $index => $c) {
                $component_id[$index] = $c->id;
                $contractAmount[$c->id] = $c->contract_price_act_bdt;
                $contractAmountSum += $c->contract_price_act_bdt;
                $packageName[$c->id] = $c->package_no;
            }

            $payment = \App\Works_package_payment::whereIn('package_id', $component_id)
                ->select('package_id', \DB::raw('sum(amount) as totalAmount'))
                ->groupBy('package_id')
                ->get();

            /*starting package payment for graph data */
            $paymentAmountSum = 0;
            $packageGraphPayment = [];
            $test = [];
            foreach ($payment as $p_key => $p) {

                //dd($contractAmount[$p->package_id]);
                if ($contractAmount[$p->package_id] != 0) {
                    $y = ($p->totalAmount / $contractAmount[$p->package_id]) * 100;
                } else {
                    $y = 0;
                }
                //$packageGraphPayment[$p_key][0] = $packageName[$p->package_id];
                //$packageGraphPayment[$p_key][1] = $y;
                $test[$p->package_id] = $y;
                $paymentAmountSum += $p->totalAmount;
            }

            $packageGraphPayment = [];
            $amount = 0;
            foreach ($component as $index => $c) {

                if (array_key_exists($c->id, $test)) {
                    $amount = $test[$c->id];
                } else {
                    $amount = 0;
                }
                $packageGraphPayment[$index][0] = $c->package_no;
                $packageGraphPayment[$index][1] = $amount;
            }

            //dd($packageGraphPayment);

            $packageDetails[$key]['name'] = $value->name_en;
            $packageDetails[$key]['id'] = $value->name_en;
            $packageDetails[$key]['data'] = $packageGraphPayment;

            //dd($packageDetails);
            /*ending package payment for graph data */

            //type details for grap
            $typeDetails[$key]['name'] = $value->name_en;
            if ($contractAmountSum != 0) {
                $y = ($paymentAmountSum / $contractAmountSum) * 100;
                $typeDetails[$key]['y'] = (int) round($y, 3);
            } else {
                $typeDetails[$key]['y'] = 0;
            }
            $typeDetails[$key]['drilldown'] = $value->name_en;
            $typeDetails[$key]['color'] = $colorArray[$key];
            /**ending type deatials */

        }
        //dd($packageDetails);
        $data = [];
        $data['typeDetails'] = json_encode($typeDetails);
        $data['paymentDetails'] = json_encode($packageDetails);

        return $data;

    }

    public function total_package_data($type_id = null)
    {
        if ($type_id) {
            $results = DB::table('components as t')
                ->where([['t.type_id', $type_id], ['t.deleted_at', null],
                ])
                ->select(['t.*', 'at.*'])
            //->select(['train.*','at.*'])
            // ->fromSub(function($query){
            //     $query->select(['t.id','t.package_no','t.name_en','t.contract_price_act_bdt as  cost_tk_est'])
            //             ->from('components as t');
            //              //->where('t.id','=',1);
            //      },'train')
                ->leftJoinSub(function ($query) {
                    $query->select(['ta.package_id', DB::raw('sum(ta.amount) as payment ')])
                        ->from('works_package_payments as ta')
                        ->where('ta.is_package', 1)
                        ->groupBy(['ta.package_id']);
                }, 'at', 't.id', '=', 'at.package_id')
            //->toSql();
                ->orderby('t.package_no')
                ->paginate(3);
        } else {
            $results = DB::table('components as t')
                ->select(['t.*', 'at.*'])
                ->leftJoinSub(function ($query) {
                    $query->select(['ta.package_id', DB::raw('sum(ta.amount) as payment ')])
                        ->from('works_package_payments as ta')
                        ->where('ta.is_package', 1)
                        ->groupBy(['ta.package_id']);
                }, 'at', 't.id', '=', 'at.package_id')
            //->toSql();
                ->orderby('t.package_no')
                ->paginate(3);
        }
        return $results;
    }
    public function chart()
    {
        $wd = DB::select("SELECT SUM(contract_price_act_bdt) AS cost,package_no FROM components where type_id=2 GROUP BY package_no");
        $sb = DB::select("SELECT SUM(contract_price_act_bdt) AS cost,package_no FROM components where type_id=3 GROUP BY package_no");
        $gd = DB::select("SELECT SUM(contract_price_act_bdt) AS cost,package_no FROM components where type_id=1 GROUP BY package_no");

        $wd_a = DB::table('components')->where('type_id', 2)->sum('contract_price_act_bdt');
        $sb_a = DB::table('components')->where('type_id', 3)->sum('contract_price_act_bdt');
        $gd_a = DB::table('components')->where('type_id', 1)->sum('contract_price_act_bdt');

        $t_a = DB::table('components')->sum('contract_price_act_bdt');

        $data = [];
        $f_data = [];
        $categories = [];
        $i = 0;

        foreach ($wd as $item) {
            $categories[$i] = $item->package_no;
            $data[$i] = ($item->cost / $wd_a) * 100;
            $i++;
        }
        $f_data[0]['y'] = ($wd_a / $t_a) * 100;
        //$f_data[0]['color']=' colors[2]';
        $drilldown = array("name" => "work", "categories" => $categories, "data" => $data);
        $f_data[0]['drilldown'] = $drilldown;

        $data = [];
        $categories = [];
        $i = 0;
        foreach ($gd as $item) {
            $categories[$i] = $item->package_no;
            $data[$i] = ($item->cost / $gd_a) * 100;
            $i++;
        }
        $f_data[1]['y'] = ($gd_a / $t_a) * 100;
        // $f_data[1]['color']=' colors[1]';
        $drilldown = array("name" => "Good", "categories" => $categories, "data" => $data);
        $f_data[1]['drilldown'] = $drilldown;

        $data = [];
        $categories = [];
        $i = 0;
        foreach ($sb as $item) {
            $categories[$i] = $item->package_no;
            $data[$i] = ($item->cost / $sb_a) * 100;
            $i++;
        }
        $f_data[2]['y'] = ($sb_a / $t_a) * 100;
        // $f_data[1]['color']=' colors[1]';
        $drilldown = array("name" => "Good", "categories" => $categories, "data" => $data);
        $f_data[2]['drilldown'] = $drilldown;

        //return $f_data;
        return json_encode($f_data);

    }
    public static function get_pie_chart_data_total_package($total_amount, $id = null)
    {
        if ($id) {
            $query_data = DB::select("SELECT SUM(contract_price_act_bdt) AS cost,package_no FROM components where type_id=$id GROUP BY package_no");
        } else {
            $query_data = DB::select("SELECT SUM(contract_price_act_bdt) AS cost,package_no FROM components GROUP BY package_no");
        }

        $amount = $total_amount;
        $data = [];
        $i = 0;

        foreach ($query_data as $item) {
            $data[$i]['name'] = $item->package_no;
            $data[$i]['y'] = ($item->cost / $amount) * 100;
            $i++;
        }

        return json_encode($data);
    }
    // public function index()
    // {
    //     //total package
    //     $package= Common::get_total_package_data();
    //     $total_amount= Common::sum_of_total_package_amount();
    //     $total_package_chart= Common::get_pie_chart_data_total_package($total_amount);

    //     //Total Package Tender Call
    //     $package_tender_call= Common::get_total_package_tender_call_data();
    //     $total_amount_tender_call= Common::sum_of_total_package_tender_call_amount();
    //     $total_package_tender_call_chart= Common::get_pie_chart_data_total_package_tender_call($total_amount_tender_call);

    //     //tender call
    //     $tender_call= Common::get_tender_call_data();
    //     $amount_tender_call= Common::sum_of_tender_call_amount();
    //     $total_package_tender_call_chart= Common::get_pie_chart_data_tender_call($amount_tender_call);

    //      //contract in progress
    //     $contract_in_progress= Common::contract_in_progress();
    //     $total_amount_contract_in_progress= Common::sum_of_contract_in_progress_amount();
    //     $contract_in_progress_chart= Common::get_pie_chart_data_contract_in_progress($amount_tender_call);
    //     // dd($pie_chart_data);
    //     return view('procurement.index',compact('package','total_amount','total_package_chart','package_tender_call','total_amount_tender_call','total_package_tender_call_chart','tender_call','amount_tender_call','total_package_tender_call_chart','contract_in_progress','total_amount_contract_in_progress','contract_in_progress_chart'));
    // }

    public function get_package(Request $request)
    {
        $details = Component::with('type', 'unit', 'proc_method', 'approving_authority', 'source_of_fund')->find($request->id);
        return response([
            'data' => $details,
        ]);

    }
    public function pagination(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            if ($request->tabid == 1) {
                $package = Common::get_total_package_data();
                return view('procurement.table1', compact('package'))->render();
            }
            if ($request->tabid == 2) {
                $package_tender_call = Common::get_total_package_tender_call_data();
                return view('procurement.table2', compact('package_tender_call'))->render();
            }
            if ($request->tabid == 3) {
                $tender_call = Common::get_tender_call_data();
                return view('procurement.table3', compact('tender_call'))->render();
            }
            if ($request->tabid == 4) {
                $contract_in_progress = Common::contract_in_progress();
                return view('procurement.table4', compact('contract_in_progress'))->render();
            }

        }
    }

    /* generate  procurement report function  */

    public function report()
    {
        return view('report.procurement_report.index');
    }
    public function set_report_view()
    {
        $source = Source_of_fund::get();
        $component = Component::with('type', 'unit', 'proc_method', 'approving_authority')->orderby('package_no')->get();
        $fund_name = array();
        $source_name = array();
        foreach ($source as $r) {
            $fund_name[$r->id] = $r->name_en;
        }
        foreach ($component as $r) {
            $source_id = json_decode($r->source_of_fund_id);
            $name = '';
            if ($source_id != null) {
                for ($i = 0; $i < count($source_id); $i++) {
                    $name = $name . '  ' . $fund_name[$source_id[$i]];
                }

            } else {
                $name = '-';
            }
            $source_name[$r->id] = $name;
        }
        //dd($source_name);
        return view('report.procurement_report.report_table', compact('component', 'source_name'));

    }
    /* end of generate  procurement report function */
}
