<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::all();
        return view('admin.buildings.index', compact('buildings'));
    }
    public function add()
    {
        return view('admin.buildings.add');
    }
    public function edit($id)
    {
        $target = Building::find($id);
        return view('admin.buildings.edit', compact('target'));
    }
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $target = Building::find($id);
        $target->delete();
        $buildings = Building::all();
        return view('admin.buildings.ajax.building_list', compact('buildings'))->render();
    }
    public function view($id)
    {
        $target = Building::find($id);
        return view('admin.buildings.view', compact('target'));
    }
    public function add_submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
            'building_name' => 'required|unique:buildings',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->toArray()]);
        } else {
            $building = new Building();
            $building->latitude = $request->input('latitude');
            $building->longitude = $request->input('longitude');
            $building->building_name = $request->input('building_name');
            if ($request->hasFile('marker_image')) {
                $marker_image = $request->file('marker_image')->store('marker_images', 'public');
                $building->marker_photo = $marker_image;
            }
            $building->save();
            return response()->json(['success' => true, 'new_building' => $request->input('building_name')]);
        }
    }
    public function get()
    {
        $buildings = Building::all();
        return response()->json(['buildings' => $buildings]);
    }
}
