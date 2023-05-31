<?php

namespace App\Http\Controllers\Admin;

use App\Contactor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactsController extends Controller
{

    public function index()
    {

        $contactors = Contactor::latest()->paginate(20);
        return view('admin.contactor.index', compact('contactors'));
    }

    public function create(Request $request)
    {
        $type = $request->type;
        //dd($request->all());
        if ($type == 1) {
            $typeName = 'Contractor';
        } else if ($type == 2) {
            $typeName = 'Consultant';
        } else if ($type == 3) {
            $typeName = 'Consulting Firm';
        } else if ($type == 4) {
            $typeName = 'Supplier';
        }

        return view('admin.contactor.create', compact('type', 'typeName'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name_en' => 'required',
            //'contact_number' => 'required|numeric|digits:11|unique:contactors,contact_number|starts_with:013,014,015,016,017,018,019',
        ]);

        $contactor = new Contactor();
        $contactor->name_en = $request->name_en;
        $contactor->name_bn = $request->name_bn;
        $contactor->type = $request->type;
        $contactor->contact_number = $request->contact_number;
        $contactor->address = $request->address;
        $contactor->details = $request->details;
        $contactor->created_by = 1;
        $contactor->updated_by = 1;
        $contactor->save();

        return redirect('/contactor')->with('toast_success', 'Contactor Created Successfully.');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $contactor = Contactor::find($id);
        if ($contactor->type == 'Contractor') {
            $type = 1;
        } else if ($contactor->type == 'Consultant') {
            $type = 2;
        } else if ($contactor->type == 'Consulting Firm') {
            $type = 3;
        } else if ($contactor->type == 'Supplier') {
            $type = 4;
        } else {
            $type = '';
        }

        //dd($contactor);
        return view('admin.contactor.edit', compact('contactor', 'type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_en' => 'required',
            //'contact_number' => 'required|numeric|digits:11|starts_with:013,014,015,016,017,018,019',
        ]);

        $contactor = Contactor::find($id);
        $contactor->name_en = $request->name_en;
        $contactor->name_bn = $request->name_bn;
        $contactor->type = $request->type;
        $contactor->contact_number = $request->contact_number;
        $contactor->address = $request->address;
        $contactor->details = $request->details;
        $contactor->created_by = 1;
        $contactor->updated_by = 1;
        $contactor->save();
        return redirect('/contactor')->with('toast_success', 'Contactor Updated Successfully.');

    }

    public function destroy($id)
    {
        $contactor = Contactor::findOrFail($id);
        $contactor->delete();
        return redirect('/contactor')->with('toast_success', 'Contactor Deleted Successfully.');
    }
}
