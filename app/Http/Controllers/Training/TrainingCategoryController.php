<?php

namespace App\Http\Controllers\Training;

use App\TrainingCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class TrainingCategoryController extends Controller
{
    public function index()
    {
         $training_categories = TrainingCategory::latest()->paginate(20);
        return view('training.training_category.index',compact('training_categories'));
    }

    public function create()
    {
        return view('training.training_category.create');
    }

    public function store(Request $request)
    {
         $request->validate([
            'serial_no' => 'required',
            'name' => 'required',
        ]);
        //dd($request->all());
        TrainingCategory::create($request->all());
        return redirect()->route('training-category.index')
               ->with('toast_success','Training Category created Successfully.'); 
        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $training_category= TrainingCategory::find($id);
        $training_categories = TrainingCategory::all();
        return view('training.training_category.edit',compact('training_category','training_categories'));
    }

   
    public function update(Request $request, $id)
    {
        $training_category= TrainingCategory::find($id);
        
        $request->validate([
            'serial_no' => 'required',
            'name' => 'required',
        ]);

        $training_category->update($request->all());

        return redirect()->route('training-category.index')
               ->with('toast_success','Training Category updated Successfully.'); 
    }

    public function destroy($id)
    {
        $training_category= TrainingCategory::find($id);
        $training_category->delete();
       return redirect()->route('training-category.index')
               ->with('toast_success','Training Category deleted Successfully.'); 
    }
}
