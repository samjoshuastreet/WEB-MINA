<?php

namespace App\Http\Controllers;

use App\Models\Path;
use Taniko\Dijkstra\Graph;
use Illuminate\Http\Request;
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
        $path = Path::create([
            'wp_a_lng' => $request->input('wp_a_lng'),
            'wp_a_lat' => $request->input('wp_a_lat'),
            'wp_a_code' => $request->input('wp_a_code'),
            'wp_b_lng' => $request->input('wp_b_lng'),
            'wp_b_lat' => $request->input('wp_b_lat'),
            'wp_b_code' => $request->input('wp_b_code'),
            'weight' => $request->input('weight'),
        ]);
        return response()->json(['success' => true]);
    }
    public function get()
    {
        $paths = Path::all();
        return response()->json(['paths' => $paths]);
    }
    public function find(Request $request)
    {
        $target = $request->input('target');
        $path = Path::where('wp_a_code', $target)
            ->orWhere('wp_b_code', $target)
            ->first();

        $waypoint = false;
        $pathTemp = Path::where('wp_a_code', $target)->first();
        if ($pathTemp && $pathTemp->wp_a_code === $target) {
            $waypoint = true;
        }
        return response()->json(['path' => $path, 'waypoint' => $waypoint]);
    }
    public function validator(Request $request)
    {
        if ($request->input('redMarkers') == "true") {
            return response()->json(['success' => true]);
        } else {
            $code = $request->input('code');
            $existing = Path::where('wp_a_code', $code)
                ->orWhere('wp_b_code', $code)
                ->exists();


            if ($existing) {
                return response()->json(['success' => false, 'code' => $code]);
            } else {
                return response()->json(['success' => true]);
            }
        }
    }
}
