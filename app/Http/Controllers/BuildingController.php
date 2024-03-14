<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BuildingController extends Controller
{
    public function index()
    {
        return view('admin.buildings');
    }
    public function add()
    {
        return view('admin.buildings_add');
    }
    public function add_submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
            'building_name' => 'required|unique:buildings',
            'marker_image' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->toArray()]);
        } else {
            $building = Building::create([
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'building_name' => $request->input('building_name')
            ]);
            return response()->json(['success' => true, 'new_building' => $request->input('building_name')]);
        }
    }
    public function get()
    {
        $buildings = Building::all();
        return response()->json(['buildings' => $buildings]);
    }
}
