<?php

namespace App\Http\Controllers;

use App\Models\Path;
use App\Models\Building;
use Illuminate\Http\Request;
use App\Models\BuildingMarker;
use App\Models\BuildingDetails;
use App\Models\BuildingBoundary;
use App\Models\BuildingEntrypoint;
use App\Models\BuildingType;
use Illuminate\Support\Facades\Storage;
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
        $types = BuildingType::all();
        return view('admin.buildings.add', compact('types'));
    }
    public function edit($id)
    {
        $target = Building::find($id);
        return view('admin.buildings.edit', compact('target'));
    }
    public function delete(Request $request)
    {
        $target = Building::find($request->input('id'));
        $target_name = $target->building_name;
        // Delete Building Details
        if (isset($target->buildingDetails)) {
            $target_details = $target->buildingDetails;
            $target_details->delete();
        }
        // Delete Building Entrypoints
        $target_entrypoints = $target->buildingEntrypoint;
        $target_entrypoints->delete();
        // Delete Building Boundary
        $target_boundaries = $target->buildingBoundary;
        $target_boundaries->delete();
        // Delete Building Marker
        $target_marker = $target->buildingMarker;
        $target_marker_image = $target_marker->marker_image;
        Storage::delete('public/' . $target_marker_image);
        $target_marker->delete();
        // Delete Building
        $target->delete();
        return response()->json([
            'success' => true,
            'bldg_name' => $target_name,
        ]);
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

                    $pathExists = Path::where('wp_a_code', $value)
                        ->orWhere('wp_b_code', $value)
                        ->exists();

                    $entryExists = BuildingEntrypoint::where('entrypoints', 'LIKE', '%"code":"' . $value . '"%')->exists();

                    if ($pathExists || $entryExists) {
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
                    $building_details->building_type = $request->input('building_type');
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
        if ($request->input('names')) {
            $buildings = Building::all();
            $building_names = [];
            foreach ($buildings as $key => $building) {
                $building_names[] = $building->building_name;
            }
            if ($request->input('active')) {
                $building_names = $buildings->filter(function ($building) {
                    return $building->status === 'active';
                })->pluck('building_name')->toArray();
                return response()->json(['names' => $building_names]);
            }
            return response()->json(['names' => $building_names]);
        }
        $results = [];
        if ($request->input('building')) {
            $buildings = Building::all();
            $results['buildings'] = $buildings;
        }

        if ($request->input('marker')) {
            $markers = BuildingMarker::all();
            foreach ($markers as $marker) {
                $building_names = $marker->building;
            }
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
            // Assuming BuildingBoundary has a relationship with Building
            $boundaries = $boundaries->map(function ($boundary) {
                // Access building_details through the building relationship
                $buildingDetails = $boundary->building->buildingDetails->buildingType;
                // Assuming $boundary->building is an instance of Building model
                // You can access building_details like this
                $boundary->building_details = $buildingDetails;
                // Decode corners if necessary
                $boundary->corners = json_decode($boundary->corners, true);
                return $boundary;
            });
            $results['boundaries'] = $boundaries;

            if ($request->input('boundary_with_name')) {
                // No need to map here, as we're not transforming the data
                $building_names = $boundaries->map(function ($boundary) {
                    // Assuming you need building details here
                    $results['building'] = $boundary->building;
                    $results['marker'] = $boundary->building->buildingMarker;
                });
            }
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
    public function delete_validator(Request $request)
    {
        $target = Building::find($request->input('id'));
        if ($target->status == 'active') {
            return response()->json(['success' => false, 'bldg_name' => $target->building_name, 'count' => $target->connection_count]);
        } else {
            return response()->json(['success' => true, 'bldg_name' => $target->building_name]);
        }
    }
    public function reload()
    {
        $buildings = Building::all();
        return view('admin.buildings.ajax.building_list', compact('buildings'))->render();
    }
    public function types()
    {
        $types = BuildingType::all();
        return view('admin.buildings.types', compact('types'));
    }
    public function types_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:building_types,name',
            'color' => 'required|unique:building_types,color'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->toArray()]);
        } else {
            $type = BuildingType::create([
                'name' => $request->input('name'),
                'color' => $request->input('color')
            ]);
            return response()->json(['success' => true, 'name' => $type->name]);
        }
    }
    public function types_reload()
    {
        $types = BuildingType::all();
        return view('admin.buildings.ajax.types_list', compact('types'))->render();
    }
    public function types_delete(Request $request)
    {
        $target = BuildingType::find($request->input('id'));
        if ($request->input('confirm')) {
            $target->delete();
        }
        return response()->json(['success' => true, 'name' => $target->name]);
    }
}
