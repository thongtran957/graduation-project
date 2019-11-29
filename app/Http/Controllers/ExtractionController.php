<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExtractionController extends Controller
{
    public function index(){
        return view('extraction');
    }

    public function uploadFile(Request $request){
        dd($request);
    }
}
