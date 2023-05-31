<?php

namespace App\Http\Controllers\Admin;

use App\Component;
use App\Financial_target;
use App\FinancialItem;
use Illuminate\Http\Request;
use App\Validator\validatorForm;
use App\Http\Controllers\Controller;

class FinancialTargetController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'package_id'    => 'required|numeric',
        'target_qty'    => 'required|numeric',
        'gov_amount'    => 'required|numeric',
        'pa_amount'     => 'required|numeric',
        'type'          => 'nullable|numeric',
        'date'          => 'required|date|date_format:Y-m-d',
    );
    public function index()
    {
        $financial = Financial_target::with('component')->latest()->paginate(20);
        //dd($financial);
        return view('admin.financial_target.index',compact('financial'));
    }

   
    public function create()
    {
        // $indicator = Indicator::get();
        $component = Component::all();
        $items= FinancialItem::all();
        return view('admin.financial_target.create',compact('component','items'));
    }

    
    public function store(Request $request)
    {
        //dd($request->all());
        $this->amount_convert($request);
        $response = $this->validationWithJson($request->all(),$this->rules);
        
        if($response===true){

        $record= new Financial_target();
        $package_id= $request->package_id;
        $item_id= $request->item_id;
        //dd($item_id);
        if($item_id)
        {
          $record->package_id = $item_id;
          $record->is_package= 0;
        }
        else
        {
         $record->package_id = $package_id;
         $record->is_package= 1;
        }
        $record->target_qty = $request->target_qty;
        $record->gov_amount = $request->gov_amount;
        $record->pa_amount  = $request->pa_amount;
        $record->date      = $request->date;
        $record->type      = 0;
       
        $record->save();
        //     //dd($source_of_fund);
        // Financial_target::create($financial_data);
            
        return redirect('/financial-target')->with('toast_success','Financial Target save Successfully.');
        }
        return back()->with('toast_error', $response)->withInput();
    }

    public function edit( $id)
    {
        $financial  = Financial_target::findOrFail($id);
        $items= FinancialItem::all();
        $component  = Component::all();

        return view('admin.financial_target.edit',compact('financial','component','items'));
    }

    
    public function update(Request $request, $id)
    {
        //return dd($request->all());
        $this->amount_convert($request);
        $response = $this->validationWithJson($request->all(),$this->rules);
        if($response===true){
            $financial_data = $this->getFormData($request->all(),$this->rules);
            Financial_target::updateOrCreate(['id'=>$id],$financial_data); 
            
            return redirect('/financial-target')->with('toast_success','Financial Target  Updated Successfully.');
        }
        return back()->with('toast_error', $response)->withInput();
    }

    public function show($id)
    {
        
    }
    
    public function destroy($id)
    {
        $source = Financial_target::findOrFail($id);
        //$this->authorize('delete',$source);
        $source->delete();
    
        return $this->responseWithSuccess('Data Deleted successfully','success');
        // //return redirect('/indicator_data')->with('toast_success','Indicator Data Deleted Successfully.');
    }

    public function amount_convert(&$request=[])
    {
        $amount =  str_replace(",", '',$request['gov_amount'] );
        $amount = explode('.',$amount);
        $tk = (int) $amount[0];
        if(isset($amount[1])){
            $poisha = (int) $amount[1]/100;
            $tk +=$poisha;
        }
        $request['gov_amount'] = $tk;

        $amount =  str_replace(",", '',$request['pa_amount'] );
        $amount = explode('.',$amount);
        $tk = (int) $amount[0];
        if(isset($amount[1])){
            $poisha = (int) $amount[1]/100;
            $tk +=$poisha;
        }
        $request['pa_amount'] = $tk;
    }
}
