<?php

namespace App\Http\Controllers;

use App\Jobs\TrainNerModelJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessController extends Controller
{
    public function test()
    {
        $this->setColorForLabel();
    }

    public function convert_to_pdf()
    {
        $file_json_name = '/home/thongtran/projects/final-project/public/testdata.json';
        $fh = fopen($file_json_name, 'r');
        $arr = [];
        while ($line = fgets($fh)) {
            $obj = json_decode($line);
            $content = $obj->content;
            array_push($arr, $content);
        }
        fclose($fh);
        return view('test', compact('arr'));
    }

    public function insertLabel()
    {
        DB::table('labels')->truncate();
        $file_json_name = '/home/thongtran/projects/final-project/public/traindata.json';
        $fh = fopen($file_json_name, 'r');
        while ($line = fgets($fh)) {
            $obj = json_decode($line);
            $annotations = $obj->annotation;
            foreach ($annotations as $value) {
                if (isset($value->label[0])) {
                    DB::table('labels')->insert([
                        'name' => trim($value->label[0])
                    ]);
                }
            }
        }
        fclose($fh);
        $labels = array_unique(DB::table('labels')->pluck('name')->toArray());
        DB::table('labels')->truncate();
        foreach ($labels as $value) {
            DB::table('labels')->insert([
                'name' => $value
            ]);
        };
    }

    public function insertResume()
    {
        DB::table('resumes')->truncate();
        DB::table('content_resumes')->truncate();
        $file_json_name = '/home/thongtran/projects/final-project/public/traindata.json';
        $fh = fopen($file_json_name, 'r');
        while ($line = fgets($fh)) {
            $obj = json_decode($line);
            $annotations = $obj->annotation;
            $content = $obj->content;
            $resume_id = DB::table('resumes')->insertGetId([
                'content' => $content,
            ]);

            foreach ($annotations as $value) {
                if (isset($value->label[0])) {
                    $label_id = DB::table('labels')->where('name', $value->label[0])->pluck('id')->toArray()[0];
                    $point = $value->points[0];
                    DB::table('content_resumes')->insert([
                        'text' => $point->text,
                        'start' => $point->start,
                        'end' => $point->end,
                        'resume_id' => $resume_id,
                        'label_id' => $label_id,
                    ]);

                }
            }
        }
        fclose($fh);
    }

    public function setColorForLabel()
    {
        $arr_color = [
            '#E52B50',
            '#9966CC',
            '#4F41F8',
            '#94F841',
            '#B4C902',
            '#FF4500',
            '#FF33F6',
            '#FF7F50',
            '#7FFFD4',
            '#7B3F00',
            '#008080',
        ];

        foreach ($arr_color as $key_color => $color) {
            DB::table('labels')->where('id', $key_color + 1)->update([
                'color' => $color
            ]);
        }
    }

}
