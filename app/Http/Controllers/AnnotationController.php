<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\PdfToText\Pdf;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class AnnotationController extends Controller
{
    public function index()
    {
        return view('annotation');
    }

    public function uploadFile(Request $request)
    {
        $file = $request->file;
        $arr_file_name = explode('.', $file->getClientOriginalName());
        $file_name = $arr_file_name[0] . '-' . time() . '.' . $arr_file_name[1];
        $file->move('files', $file_name);
        $path = public_path() . '/files/' . $file_name;
        $content = (new Pdf())
            ->setPdf($path)
            ->text();
        $content = trim($content);
        return view('annotation-label', compact('content', 'file_name'));
    }

    public function writeFile(Request $request)
    {
        $obj = new \stdClass();

        $content = trim((new Pdf())
            ->setPdf(public_path() . '/files/' . $request->file_name)
            ->text());
        $obj->content = $content;

        $annotations = [];
        foreach ($request->data as $annotation) {
            $obj_annotation = new \stdClass();
            $obj_annotation->label = [$annotation['label']];
            $obj_points = new \stdClass();
            $obj_points->start = (int) $annotation['start'];
            $obj_points->end = (int) $annotation['end'];
            $obj_points->text = $annotation['text_selection'];
            $obj_annotation->points = [$obj_points];
            array_push($annotations, $obj_annotation);
        }
        $obj->annotation = $annotations;

        $file_json_name = '/home/thongtran/projects/cv-extraction/traindata1.json';
        $file = fopen($file_json_name, 'w+');
        fwrite($file, json_encode($obj));
        fclose($file);

        dd('ok');


    }

    public function test()
    {
//        dd(123);
//        $result = shell_exec('/usr/bin/python3 /home/thongtran/projects/cv-extraction/main.py');
//        dd($result);
    }

}
