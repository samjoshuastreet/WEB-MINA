<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProcedureController extends Controller
{
    public function index()
    {
        return view('admin.procedures.index');
    }
    public function add()
    {
        return view('admin.procedures.add');
    }
    public function add_validate(Request $request)
    {
        if ($request->input('waypoint')) {
            $validator = Validator::make($request->all(), [
                'step_no' => 'required',
                'instructions' => 'required',
                'building_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'msg' => $validator->errors()->toArray()]);
            } else {
                return response()->json(['success' => true]);
            }
        }
        $validator = Validator::make($request->all(), [
            'procedure_name' => 'required|unique:procedures',
            'procedure_description' => 'required',
            'initial_instructions' => 'required',
            'access_level' => 'required|numeric|min:1|max:4',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->toArray()]);
        } else {
            return response()->json(['success' => true]);
        }
    }
    public function add_submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'procedure_name' => 'required|unique:procedures',
            'procedure_description' => 'required',
            'initial_instructions' => 'required',
            'access_level' => 'required|numeric|min:1|max:4'
        ]);
        return response()->json(['success' => true]);
    }
}
