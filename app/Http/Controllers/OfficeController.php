<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::all();
        return view('admin.offices.index', compact('offices'));
    }

    public function add()
    {
        return view('admin.offices.add');
    }

    public function get(Request $request)
    {
        $target = Office::find($request->input('id'));
        return response()->json(['office' => $target]);
    }

    public function add_validate(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'office_name' => 'required|unique:offices',
            'office_description' => 'required',
            'building_id' => 'required',
            'office_image' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'msg' => $validate->errors()->toArray()]);
        } else if ($request->input('office_image') == 'undefined') {
            return response()->json(['success' => false, 'msg' => ['office_image' => 'Office Image is Required']]);
        } else {
            $image = $request->file('office_image')->store('offices', 'public');
            $event = Office::create([
                'office_name' => $request->input('office_name'),
                'description' => $request->input('office_description'),
                'building_id' => intval($request->input('building_id')),
                'office_image' => $image
            ]);
            return response()->json(['success' => true, 'event' => $event->office_name]);
        }
    }

    public function render()
    {
        $offices = Office::all();
        return view('admin.offices.ajax.list', compact('offices'))->render();
    }

    public function delete(Request $request)
    {
        $target = Office::find($request->input('id'));
        $target->delete();
        return response()->json(['office' => $target->office_name]);
    }
}
