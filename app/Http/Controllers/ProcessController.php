<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessController extends Controller
{
    public function saveJsonToDb()
    {

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

}
