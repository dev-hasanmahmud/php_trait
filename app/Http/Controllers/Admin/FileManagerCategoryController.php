<?php

namespace App\Http\Controllers\Admin;

use App\File_manager_category;
use App\Http\Controllers\Controller;
use App\Validator\validatorForm;
use Illuminate\Http\Request;

class FileManagerCategoryController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'title' => 'required',
        'parent_id' => 'nullable',
    );
    public function index()
    {
        $categories = File_manager_category::with('parent')->orderBy('parent_id')
            ->paginate(20);
        // return $categories;
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        $parentcategories = File_manager_category::all();
        return view('admin.category.create', compact('parentcategories'));
    }

    public function store(Request $request)
    {
        //return $request->all();
        $response = $this->validationWithJson($request->all(), $this->rules);
        if ($response === true) {
            $category = $this->getFormData($request->all(), $this->rules);
            File_manager_category::create($category);
            return redirect('/file-manager-category')->with('toast_success', 'Category created Successfully.');
        }
        return back()->with('toast_error', $response)->withInput();
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $category = File_manager_category::findOrfail($id);
        //return $category;
        $parentcategories = File_manager_category::all();
        return view('admin.category.edit', compact('category', 'parentcategories'));
    }

    public function update(Request $request, $id)
    {
        $response = $this->validationWithJson($request->all(), $this->rules);
        if ($response === true) {
            $category = $this->getFormData($request->all(), $this->rules);
            File_manager_category::updateOrCreate(['id' => $id], $category);
            return redirect('/file-manager-category')->with('toast_success', 'Category Updated Successfully.');
        }
        return back()->with('toast_error', $response)->withInput();
    }

    public function destroy(File_manager_category $file_manager_category)
    {
        if ($file_manager_category->delete()) {
            return redirect('/file-manager-category')->with('toast_success', 'Category Deleted Successfully.');
        }
    }
}