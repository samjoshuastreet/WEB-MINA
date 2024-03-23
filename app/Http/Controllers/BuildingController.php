<?php

namespace App\Http\Controllers;

use App\Models\Path;
use App\Models\Building;
use App\Models\BuildingBoundary;
use App\Models\BuildingDetails;
use App\Models\BuildingEntrypoint;
use App\Models\BuildingMarker;
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
            'building_name' => 'required'
        ]);
        $hasEntryErrors = false;
        $entryInputs = request()->only(
            preg_grep('/^entry/', array_keys(request()->all()))
        );
        // Initialize an array to store unique values
        $uniqueValues = [];

        foreach ($entryInputs as $key => $value) {
            if (empty($value)) {
                $entryInputs[$key . '_error'] = "A code name for this entry point is required.";
                $hasEntryErrors = true;
            } else {
                // Check if the value already exists in the unique values array
                if (in_array($value, $uniqueValues)) {
                    $entryInputs[$key . '_error'] = "Duplicate value found: $value";
                    $hasEntryErrors = true;
                } else {
                    // Add the value to the unique values array
                    $uniqueValues[] = $value;

                    $existing = Path::where('wp_a_code', $value)
                        ->orWhere('wp_b_code', $value)
                        ->exists();
                    if ($existing) {
                        $entryInputs[$key . '_error'] = "$value is already taken.";
                        $hasEntryErrors = true;
                    } else {
                        // Your logic if other a value is same on 2 or more keys
                    }
                }
            }
        }
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->getMessages(), 'entryErrors' => $entryInputs]);
        } else {
            if ($hasEntryErrors) {
                return response()->json(['success' => false, 'entryErrors' => $entryInputs]);
            } else {
                $building = new Building();
                $building->building_name = $request->input('building_name');
                $building->status = $request->input('status');
                $building->save();
                $building_id = $building->id;
                $building_boundaries = new BuildingBoundary();
                $building_boundaries->corners = json_encode($request->input('corners'));
                $building_boundaries->building_id = $building_id;
                $building_boundaries->save();
                if ($request->input('building_description')) {
                    $building_details = new BuildingDetails();
                    $building_details->building_description = $request->input('building_description');
                    $building_details->building_id = $building_id;
                    $building_details->save();
                }
                $building_entrypoints = new BuildingEntrypoint();
                $building_entrypoints->entrypoints = json_encode($request->input('entrypoints'));
                $building_entrypoints->building_id = $building_id;
                $building_entrypoints->save();
                $bulding_markers = new BuildingMarker();
                $bulding_markers->markers = json_encode($request->input('markers'));
                $bulding_markers->building_id = $building_id;
                if ($request->hasFile('marker_image')) {
                    $marker_image = $request->file('marker_image')->store('marker_images', 'public');
                    $bulding_markers->marker_image = $marker_image;
                }
                $bulding_markers->save();

                return response()->json(['success' => true, 'building' => $request->input('building_name')]);
            }
        }
    }
    public function get(Request $request)
    {
        $results = [];
        if ($request->input('building')) {
            $buildings = Building::all();
            $results['buildings'] = $buildings;
        }

        if ($request->input('marker')) {
            $markers = BuildingMarker::all();
            $results['markers'] = $markers->map(function ($marker) {
                $marker->markers = json_decode($marker->markers, true);
                return $marker;
            });
        }

        if ($request->input('entrypoint')) {
            $entrypoints = BuildingEntrypoint::all();
            $results['entrypoints'] = $entrypoints->map(function ($entrypoint) {
                $entrypoint->entrypoint_column = json_decode($entrypoint->entrypoint_column, true);
                return $entrypoint;
            });
        }

        if ($request->input('boundary')) {
            $boundaries = BuildingBoundary::all();
            $results['boundaries'] = $boundaries->map(function ($boundary) {
                $boundary->corners = json_decode($boundary->corners, true);
                return $boundary;
            });
        }

        return response()->json($results);

        if ($request->input('details')) {
            $details = BuildingDetails::all();
            $results['details'] = $details;
        }
        return response()->json($results);
    }
    public function find(Request $request)
    {
        $target = $request->input('target');
        $marker = BuildingMarker::find($target);
        $building = $marker->building;
        $details = $building->buildingDetails;
        return response()->json(['building' => $building, 'marker' => $marker, 'details' => $details]);
    }
}
