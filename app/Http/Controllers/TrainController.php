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

        foreach ($list_file as $key => $value) {
            $list_file[$key]['content_file_trains'] = DB::table('content_file_trains')
                ->join('labels', 'labels.id', 'content_file_trains.label_id')
                ->where('file_id', $value['id'])
                ->get()
                ->toArray();
        }
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

    public function delete($id)
    {
         DB::table('content_file_trains')->where('file_id', $id)->delete();
        DB::table('files')->where('id', $id)->delete();
        $msg = "Delete success";

        $list_file = FileResume::where('train', 0)->where('annotate', 1)->get()->toArray();

        foreach ($list_file as $key => $value) {
            $list_file[$key]['content_file_trains'] = DB::table('content_file_trains')
                ->join('labels', 'labels.id', 'content_file_trains.label_id')
                ->where('file_id', $value['id'])
                ->get()
                ->toArray();
        }

        return view('train', compact('list_file', 'msg'));
    }
}
