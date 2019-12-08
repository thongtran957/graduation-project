<?php

namespace App\Http\Controllers;

use App\Jobs\TrainNerModelJob;
use App\Models\FileResume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainController extends Controller
{
    public function index()
    {
        $list_file = FileResume::where('train', 0)->where('annotate', 1)->get()->toArray();
        return view('train', compact('list_file'));
    }

    public function train($file_train)
    {
        $file = '/home/thongtran/projects/cv-extraction/trains/' . $file_train;
        $cmd = '/usr/bin/python3 /home/thongtran/projects/cv-extraction/train.py' . ' ' . $file;
        DB::table('files')->where('file_name', explode('.', $file)[0] . '.pdf')->update([
            'train' => 1
        ]);
        TrainNerModelJob::dispatch($cmd);
        return redirect()->route('train.index');
    }
}
