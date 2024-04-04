<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use App\Models\ProcedureWaypoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProcedureController extends Controller
{
    public function index()
    {
        $procedures = Procedure::all();
        return view('admin.procedures.index', compact('procedures'));
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
        if ($request->input('final')) {
            $validator = Validator::make($request->all(), [
                'review_procedure_name' => 'required|unique:procedures,procedure_name',
                'review_procedure_description' => 'required',
                'review_initial_instructions' => 'required',
                'review_access_level' => 'required',
                '*_review_step_no' => 'required',
                '*_review_instructions' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'msg' => $validator->errors()->toArray()]);
            } else {
                $procedure = new Procedure();
                $procedure->procedure_name = $request->input('review_procedure_name');
                $procedure->procedure_description = $request->input('review_procedure_description');
                $procedure->initial_instructions = $request->input('review_initial_instructions');
                $procedure->access_level = $request->input('review_access_level');
                $procedure->save();
                foreach ($request->all() as $key => $value) {
                    if (strpos($key, '_review_step_no') !== false) {
                        $waypoint = new ProcedureWaypoint();
                        $waypoint->step_no = $value;
                        $waypoint->instructions = $request->input($value . '_review_instructions');
                        $waypoint->building_id = $request->input($value . '_review_building_id');
                        $waypoint->procedure_id = $procedure->id;
                        $waypoint->save();
                    }
                }
                return response()->json(['success' => true, 'procedure_name' => $procedure->procedure_name]);
            }
        }
        $validator = Validator::make($request->all(), [
            'procedure_name' => 'required|unique:procedures',
            'procedure_description' => 'required',
            'initial_instructions' => 'required',
            'access_level' => 'required|numeric|min:1|max:4'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false]);
        } else {
            return response()->json(['success' => true]);
        }
    }
    public function get(Request $request)
    {
        $target = Procedure::find($request->id);
        $waypoints = $target->waypoints;
        foreach ($waypoints as $key => $waypoint) {
            $waypoints[$key]->building = $waypoint->building;
            $waypoints[$key]->photo = $waypoint->building->buildingMarker->marker_image;
        }
        return response()->json(['success' => true, 'target_procedure' => $target, 'waypoints' => $waypoints]);
    }
}
