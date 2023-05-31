<?php

namespace App\Http\Controllers\Finance;
use App\Contactor;
use App\FinancialItem;
use App\Source_of_fund;
use Illuminate\Http\Request;
use App\Validator\validatorForm;
use App\Http\Controllers\Controller;

class FinancialItemController extends Controller
{
  
    use validatorForm;
    public function index()
    {
        $financial_items= FinancialItem::latest()->paginate(20);

        //dd($financial_items);
        return view('financialitem.index',compact('financial_items'));
    }


    public function create()
    {
        return view('financialitem.create');
    }


    public function store(Request $request)
    {
        FinancialItem::create($request->all());
        return redirect()->route('financialitem.index')->with('toast_success','Financial Item Added Successfully');
    }
   
    public function edit($id)
    {
        $item= FinancialItem::find($id);
        return view('financialitem.edit',compact('item'));
    }


    public function update(Request $request, $id)
    {
        $item= FinancialItem::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('financialitem.index')->with('toast_success','Financial Item updated Successfully');
    }

 
    public function destroy($id)
    {
        $item= FinancialItem::find($id);
        $item->delete();
        return redirect()->back()->with('toast_success','Item Deleted Successfully');
    }

    public function report()
    {
        return view('financialitem.report');
    }
    public function get_contractor($id)
    {

        $contractor = Contactor::all();
        $source     = Source_of_fund::all();

        $data=array();
        $data['contractor']=$contractor;
        //$data['package']=$package;
        $data['source']=$source;

        return $this->responseWithSuccess('message',$data);
    }
}
