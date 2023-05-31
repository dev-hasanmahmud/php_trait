<?php

namespace App\Http\Controllers;

use App\Proc_method;
use App\Settings;
use App\Type;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function index()
    {
        $records = Settings::with('types', 'procurement')->latest()->paginate(20);
        //dd($records);
        return view('settings.index', compact('records'));
    }

    public function create()
    {
        $procurement_types = Type::all();
        $procurement_methods = Proc_method::all();
        return view('settings.create', compact('procurement_types', 'procurement_methods'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $data = array();
        $data['type_id'] = $request->type_id;
        $data['procurement_method_id'] = $request->procurement_method_id;

        for ($i = 1; $i < 20; $i++) {
            $label_name = "label_name_" . $i;
            $identifier = "identifier_name_" . $i;
            $type = "type_" . $i;
            $is_mendatory = "is_mendatory_" . $i;
            $ordering = "ordering_" . $i;

            //dd($request->$identifier);
            if ($request->has($label_name) || $request->has($identifier) || $request->has($type) || $request->has($is_mendatory)) {

                $data['label_name'] = $request->$label_name;
                $data['identifier'] = $request->$identifier;
                $data['type'] = $request->$type;
                $data['is_mendatory'] = $request->$is_mendatory;
                $data['ordering'] = $request->$ordering;

                //dd($data);
                Settings::create($data);
            }

        }
        return redirect()->route('settings.index')->with('toast_success', 'Record Uploaded Successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $record = Settings::find($id);
        $procurement_types = Type::all();
        $procurement_methods = Proc_method::all();

        //dd($record);
        return view('settings.edit', compact('record', 'procurement_types', 'procurement_methods'));
    }

    public function update(Request $request, $id)
    {
        $record = Settings::findOrFail($id);

        $record->type_id = $request->type_id;
        $record->procurement_method_id = $request->procurement_method_id;
        $record->identifier = $request->identifier;
        $record->type = $request->type;
        $record->label_name = $request->label_name;
        $record->is_mendatory = $request->is_mendatory;
        $record->ordering = $request->ordering;

        $record->update();
        return redirect()->route('settings.index')->with('toast_success', 'Record Updated Successfully');
    }

    public function destroy($id)
    {
        $record = Settings::find($id);
        $record->delete();
        return redirect()->back()->with('toast_success', 'Record Deleted Successfully');
    }
}