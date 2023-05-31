<?php

namespace App\Http\Controllers;

use App\Component;
use App\Contactor;
use App\FinancialItem;
use App\Source_of_fund;
use App\Validator\validatorForm;
use App\Works_package_payment;
use DB;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'package_id' => 'required|numeric',
        'voucher_no' => 'required',
        'source_of_fund_id' => 'required|numeric',
        'contactor_id' => 'required|numeric',
        'amount' => 'required|numeric',
        'date' => 'required|date|date_format:Y-m-d',
        'details' => 'nullable',
        'quantity' => 'nullable|numeric',
    );
    public function index(Request $request)
    {
        // $payment = Works_package_payment::with('component', 'contactor', 'source_of_fund', 'fiancial_item')
        //     ->latest()->paginate(20);

        $payment = \DB::query()
            ->select(['r1.*', 'r2.*'])
            ->fromSub(function ($query) {
                $query->select(['c.id', 'c.contract_price_act_bdt', 'c.package_no', 'c.name_en', 'pa.id as payment_id', 'pa.amount', 'ca.name_en as contract_name', 'fa.name_en as source_name', 'pa.date'])
                    ->from('components as c')
                    ->leftJoin('works_package_payments as pa', 'pa.package_id', '=', 'c.id')
                    ->leftJoin('contactors as ca', 'pa.contactor_id', '=', 'ca.id')
                    ->leftJoin('source_of_funds as fa', 'pa.source_of_fund_id', '=', 'fa.id');
            }, 'r1')
            ->leftJoinSub(function ($query) {
                $query->select(['p.package_id', \DB::raw('sum(p.amount) as total_pay_amout')])
                    ->from('works_package_payments  as p')
                    ->groupBy('p.package_id');
            }, 'r2', 'r2.package_id', '=', 'r1.id')
            ->where('package_id', '!=', null)->orderBy('package_no')
            ->paginate(20);
        //return $payment;
        $package_no = $request->package_no;
        $name_en = $request->name_en;
        $date = $request->date;
        if ($request->package_no || $request->name_en || $request->date) {

            $payment = \DB::query()
                ->select(['r1.*', 'r2.*'])
                ->fromSub(function ($query) use ($date, $name_en, $package_no) {
                    $query->select(['c.id', 'c.contract_price_act_bdt', 'c.package_no', 'c.name_en', 'pa.id as payment_id', 'pa.amount', 'ca.name_en as contract_name', 'fa.name_en as source_name', 'pa.date'])
                        ->from('components as c')
                        ->leftJoin('works_package_payments as pa', 'pa.package_id', '=', 'c.id')
                        ->leftJoin('contactors as ca', 'pa.contactor_id', '=', 'ca.id')
                        ->leftJoin('source_of_funds as fa', 'pa.source_of_fund_id', '=', 'fa.id')
                        ->when($date, function ($q) use ($date) {
                            return $q->where('pa.date', $date);
                        })
                    //->where('pa.date', $date)
                        ->where('c.package_no', 'LIKE', "%{$package_no}%");
                    //->orWhere('c.name_en', 'LIKE', "%{$name_en}%");
                }, 'r1')
                ->leftJoinSub(function ($query) {
                    $query->select(['p.package_id', \DB::raw('sum(p.amount) as total_pay_amout')])
                        ->from('works_package_payments  as p')
                        ->groupBy('p.package_id');
                }, 'r2', 'r2.package_id', '=', 'r1.id')
                ->where('package_id', '!=', null)->orderBy('package_no')
                ->paginate(20);
            //return $payment;
        }
        $pre = '';
        $index = 1;
        $ind = 0;
        $count = [];
        foreach ($payment as $f) {
            $ind++;
            if ($pre == $f->package_no) {
                $count[$index] += 1;
            } else {
                $index = $ind;
                $count[$index] = 1;
            }

            $pre = $f->package_no;
        }

        //return $payment;

        // $total = Works_package_payment::select('package_id', \DB::raw('sum(amount) as amount'))->groupBy('package_id')->get();
        // $amountData = [];
        // foreach ($total as $key => $value) {
        //     $amountData[$value->package_id] = $value->amount;
        // }

        return view('payment.index', compact('payment', 'package_no', 'date', 'count'));

    }

    public function create()
    {
        // $indicator = Indicator::get();
        $component = Component::all();
        $financial_item = FinancialItem::all();
        return view('payment.create', compact('component', 'financial_item'));
    }

    public function store(Request $request)
    {
        $this->amount_convert($request);
        $response = $this->validationWithJson($request->all(), $this->rules);
        if ($response === true) {
            $payment_data = $this->getFormData($request->all(), $this->rules);
            //dd($source_of_fund);
            if ($payment_data['package_id'] == 0) {
                $payment_data['package_id'] = $request->financial_item_id;
                $payment_data['is_package'] = 0;
            }
            //dd($payment_data);
            Works_package_payment::create($payment_data);

            return redirect('/payment')->with('toast_success', 'Payment data save Successfully.');
        }
        return back()->with('toast_error', $response)->withInput();
    }

    public function edit($id)
    {
        $payment = Works_package_payment::findOrFail($id);
        $component = Component::all();
        $financial_item = FinancialItem::all();
        $payment_package = Component::where('id', $payment->package_id)->first();

        //dd($payment_package);
        if ($payment->is_package) {
            $contractor_id = json_decode($payment_package['contactors']);
            $source_id = json_decode($payment_package['source_of_fund_id']);
            $constractor = Contactor::whereIn('id', (array) $contractor_id)->get();
            $source_of_fund = Source_of_fund::whereIn('id', (array) $source_id)->get();
        } else {
            $constractor = Contactor::all();
            $source_of_fund = Source_of_fund::all();
        }
        return view('payment.edit', compact('payment', 'component', 'source_of_fund', 'constractor', 'financial_item'));
    }

    public function update(Request $request, $id)
    {
        $this->amount_convert($request);
        $response = $this->validationWithJson($request->all(), $this->rules);
        if ($response === true) {
            $indicator_data = $this->getFormData($request->all(), $this->rules);
            if ($indicator_data['package_id'] == 0) {
                $indicator_data['package_id'] = $request->financial_item_id;
                $indicator_data['is_package'] = 0;
            } else {
                $indicator_data['is_package'] = 1;
            }
            //dd($indicator_data);
            Works_package_payment::updateOrCreate(['id' => $id], $indicator_data);
            return redirect('/payment')->with('toast_success', 'Payment Data  Updated Successfully.');
        }
        return back()->with('toast_error', $response)->withInput();
    }

    public function show($id)
    {
        // $payment_data = Works_package_payment::where('package_id',$id)->get();
        // return $this->responseWithSuccess('message',$payment_data);
        $payment = Works_package_payment::find($id);
        //dd($payment);
        return view('payment.show', compact('payment'));
    }

    public function destroy($id)
    {
        $source = Works_package_payment::findOrFail($id);
        //$this->authorize('delete',$source);
        $source->delete();

        return $this->responseWithSuccess('Data Deleted successfully', 'success');
        // //return redirect('/indicator_data')->with('toast_success','Indicator Data Deleted Successfully.');

    }

    public function progress_details()
    {
        $component = Component::all();
        return view('worksPackagePayment.index', compact('component'));
    }

    public function amount_convert(&$request = [])
    {

        $amount = str_replace(",", '', $request['amount']);
        $amount = explode('.', $amount);
        $tk = (int) $amount[0];
        if (isset($amount[1])) {
            $poisha = (int) $amount[1] / 100;
            $tk += $poisha;
        }
        $request['amount'] = $tk;
    }

}