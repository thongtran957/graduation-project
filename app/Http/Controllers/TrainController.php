<?php

namespace App\Http\Controllers;

use App\Models\FileResume;
use Illuminate\Http\Request;

class TrainController extends Controller
{
    public function index()
    {
        $list_file = FileResume::where('train', 0)->where('annotate', 1)->get()->toArray();
        return view('train', compact('list_file'));
    }

    public function train($file_train){
        dd($file_train);
    }

}
