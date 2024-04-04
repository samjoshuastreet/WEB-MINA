<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Procedure;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $procedures = Procedure::all();
        return view('home.map', compact('procedures'));
    }
}
