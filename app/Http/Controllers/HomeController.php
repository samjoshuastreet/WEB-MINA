<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.map');
    }
}
