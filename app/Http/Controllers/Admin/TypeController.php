<?php

namespace App\Http\Controllers\Admin;
use App\Type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    
    public function index()
    {
        $types = Type::orderBy('id')->paginate(20);
        return view('admin.type.index',compact('types'));
    }

    public function create()
    {
        return view('admin.type.create');
    }

    public function store(Request $request)
    {
         $request->validate([
            'name_en' => 'required',
            'name_bn' => 'required',
        ]);
        //dd($request->all());
        Type::create($request->all());
   
        return redirect()->route('type.index')
               ->with('toast_success','Type created Successfully.'); 
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $type= Type::find($id);
        return view('admin.type.edit',compact('type'));
    }

   
    public function update(Request $request, $id)
    {
        $type= Type::find($id);
        
        $request->validate([
            'name_en' => 'required',
            'name_bn' => 'required',
        ]);

        $type->update($request->all());

        return redirect()->route('type.index')
               ->with('toast_success','Type Updated Successfully.');
    }

    public function destroy($id)
    {
        $type= Type::find($id);
        $type->delete();
        return redirect()->route('type.index')
               ->with('toast_success','Type Deleted Successfully.');
    }
}