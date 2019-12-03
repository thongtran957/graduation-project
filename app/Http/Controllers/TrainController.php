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

    public function train($file_train)
    {
        $cmd = '/usr/bin/python3 /home/thongtran/projects/cv-extraction/train.py' . ' ' . $file_train;
        $result = shell_exec($cmd);
        dd($result);
    }

    public function test($path)
    {
        $cmd = '/usr/bin/python3 /home/thongtran/projects/cv-extraction/train.py' . ' ' . $path;
        $result = shell_exec($cmd);
        dd($result);
    }
}
