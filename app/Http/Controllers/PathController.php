<?php

namespace App\Http\Controllers;

use App\Models\Path;
use App\Models\Building;
use Taniko\Dijkstra\Graph;
use Illuminate\Http\Request;
use App\Models\BuildingEntrypoint;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\String\b;
use Illuminate\Support\Facades\Validator;

class PathController extends Controller
{
    public function index()
    {
        $paths = Path::all();
        return view('admin.paths.index', compact('paths'));
    }
    public function add()
    {
        return view('admin.paths.add');
    }
    public function add_submit(Request $request)
    {
        $path = new Path();
        $path->wp_a_lng = $request->input('wp_a_lng');
        $path->wp_a_lat = $request->input('wp_a_lat');
        $path->wp_a_code = $request->input('wp_a_code');
        $path->wp_b_lng = $request->input('wp_b_lng');
        $path->wp_b_lat = $request->input('wp_b_lat');
        $path->wp_b_code = $request->input('wp_b_code');
        $path->weight = $request->input('weight');
        $path->landmark = $request->input('landmark');
        $path->type = $request->input('type');
        $path->cardinal_direction = $request->input('cardinal_direction');
        if ($request->input('building_connection') == 'true') {
            if ($request->input('buildingConnectionA')) {
                $target = $request->input('buildingConnectionA');
                $entrypoint = BuildingEntrypoint::find($target);
                $building = $entrypoint->building;
                $building->connection_count += 1;
                if ($building->status == 'inactive') {
                    $building->status = 'active';
                }
                $path->entrance = 'true';
                $path->connected_building = $building->id;
                $building->save();
            }
        } else {
            $path->entrance = 'false';
        }
        $path->save();
        return response()->json(['success' => true]);
    }
    public function get()
    {
        $paths = Path::all();
        return response()->json(['paths' => $paths]);
    }
    public function find(Request $request)
    {
        if ($request->input('id_search')) {
            $target = Path::find($request->input('id'));
            return response()->json(['path' => $target]);
        }
        if ($request->input('half')) {
            $code = $request->input('code');
            $target_path = Path::where('wp_a_code', $code)
                ->orWhere('wp_b_code', $code)
                ->first();

            if ($target_path->wp_a_code == $code) {
                $result_path = [$target_path->wp_a_lng, $target_path->wp_b_lat];
            } else {
                $result_path = [$target_path->wp_b_lng, $target_path->wp_b_lat];
            }
            return response()->json(['result_path' => $result_path]);
        }
        if ($request->input('single_search')) {
            $code_a = $request->input('a');
            $code_b = $request->input('b');
            $paths = Path::all();
            foreach ($paths as $path) {
                if ($path->wp_a_code == $code_a || $path->wp_b_code == $code_a) {
                    if ($path->wp_a_code == $code_b || $path->wp_b_code == $code_b) {
                        $target = $path;
                    }
                }
            }
            if (isset($target)) {
                return response()->json(['path' => $target]);
            } else {
                return response()->json(['skip' => true]);
            }
            //     if ($request->input('gps')) {
            //         $gps_coords = $request->input('gps');
            //     }
            //     if ($request->input('npl')) {
            //         $npl_coords = $request->input('npl');
            //     }
            //     $path_a = Path::where('wp_a_code', $code_a)
            //         ->orWhere('wp_b_code', $code_a)
            //         ->first();
            //     $path_b = Path::where('wp_a_code', $code_b)
            //         ->orWhere('wp_b_code', $code_b)
            //         ->first();
            //     $exists = $path_a !== null || $path_b !== null;
            //     if ($exists) {
            //         if ($path_a) {
            //             if ($code_a == $path_a->wp_a_code) {
            //                 $wp_a_coords = [$path_a->wp_a_lng, $path_a->wp_a_lat];
            //             } else {
            //                 $wp_a_coords = [$path_a->wp_b_lng, $path_a->wp_b_lat];
            //             }
            //             if (isset($gps_coords)) {
            //                 return response()->json(['wp_a_coords' => $wp_a_coords, 'gps_coords' => $gps_coords]);
            //             } else {
            //                 return response()->json(['wp_a_coords' => $wp_a_coords, 'npl_coords' => $npl_coords]);
            //             }
            //         } else {
            //             if ($code_a == $path_b->wp_a_code) {
            //                 $wp_b_coords = [$path_b->wp_a_lng, $path_b->wp_a_lat];
            //             } else {
            //                 $wp_b_coords = [$path_b->wp_b_lng, $path_b->wp_b_lat];
            //             }
            //             if (isset($gps_coords)) {
            //                 return response()->json(['wp_b_coords' => $wp_b_coords, 'gps_coords' => $gps_coords]);
            //             } else {
            //                 return response()->json(['wp_b_coords' => $wp_b_coords, 'npl_coords' => $npl_coords]);
            //             }
            //         }
            //     } else {
            //         return response()->json(['gps_coords' => $gps_coords, 'npl_coords' => $npl_coords, 'raw_search' => true]);
            //     }
            // }
        }
        $target = $request->input('target');
        if ($request->input('editor')) {
            $path = Path::find($target);
            $codes = $path->wp_a_code . $path->wp_b_code;
            return response()->json(['codes' => $codes]);
        }
        $pathA = Path::where('wp_a_code', $target)->first();
        $pathB = Path::where('wp_b_code', $target)->first();

        if ($pathA) {
            $waypoint = true;
        } elseif ($pathB) {
            $waypoint = false;
        }

        $path = $pathA ?? $pathB;
        return response()->json(['path' => $path, 'waypoint' => $waypoint]);
    }
    public function validator(Request $request)
    {
        if ($request->input('landmarkWithType')) {
            $validator = Validator::make($request->all(), [
                'landmark' => 'nullable',
                'type' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false]);
            } else {
                return response()->json(['success' => true]);
            }
        }
        if ($request->input('redMarkers') == "true") {
            $entries = BuildingEntrypoint::all();
            $decodedEntries = [];

            foreach ($entries as $entry) {
                // Decode the JSON string from the entrypoints column
                $decodedEntry = json_decode($entry->entrypoints, true);

                // Check if decoding was successful
                if ($decodedEntry !== null) {
                    // Add decoded entrypoints to the array
                    $decodedEntries[] = $decodedEntry;
                } else {
                    // Handle the case where JSON decoding failed for a record
                    return response()->json(['error' => 'Failed to decode JSON for record with ID ' . $entry->id]);
                }
            }
            return response()->json(['success' => true, 'decodedEntries' => $decodedEntries]);
        } else if ($request->input('buildingConnection') == "true") {
            return response()->json(['success' => true, 'connection' => true]);
        } else if ($request->input('entrypoint_validation')) {
            if ($request->input('connection') !== "true") {
                $target = $request->input('code');
                $codes = $request->input('codes');
                foreach ($codes as $code) {
                    if ($code == $target) {
                        return response()->json(['success' => false, 'code' => $code]);
                    }
                }
            }
            return response()->json(['success' => true]);
        } else {
            $code = $request->input('code');
            $pathExists = Path::where('wp_a_code', $code)
                ->orWhere('wp_b_code', $code)
                ->exists();

            if ($pathExists) {
                return response()->json(['success' => false, 'code' => $code]);
            } else {
                $entries = BuildingEntrypoint::all();
                $decodedEntries = [];

                foreach ($entries as $entry) {
                    // Decode the JSON string from the entrypoints column
                    $decodedEntry = json_decode($entry->entrypoints, true);

                    // Check if decoding was successful
                    if ($decodedEntry !== null) {
                        // Add decoded entrypoints to the array
                        $decodedEntries[] = $decodedEntry;
                    } else {
                        // Handle the case where JSON decoding failed for a record
                        return response()->json(['error' => 'Failed to decode JSON for record with ID ' . $entry->id]);
                    }
                }
                return response()->json(['success' => true, 'decodedEntries' => $decodedEntries]);
            }
        }
    }
    public function edit()
    {
        return view('admin.paths.edit');
    }
    public function delete(Request $request)
    {
        $target = $request->input('target');
        $path = Path::find($target);
        $codes = $path->wp_a_code . $path->wp_b_code;
        if ($path->entrance == 'true') {
            $building_id = $path->connected_building;
            $building = Building::find($building_id);
            if ($building->connection_count <= 1) {
                $building->status = 'inactive';
            }
            $building->connection_count -= 1;
            $building->save();
        }
        $path->delete();
        return response()->json(['codes' => $codes]);
    }
    public function reset()
    {
        $paths = Path::all();
        foreach ($paths as $path) {
            if ($path->entrance == 'true') {
                $building = Building::find($path->connected_building);
                if ($building->connection_count <= 1) {
                    $building->status = 'inactive';
                }
                $building->connection_count -= 1;
                $building->save();
            }
            $path->delete();
        }
        return response()->json(['success' => true]);
    }
}
