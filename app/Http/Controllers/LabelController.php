<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LabelController extends Controller
{
    public function index()
    {
        $labels = DB::table('labels')->get()->toArray();
        return view('labels', compact('labels'));
    }
}
