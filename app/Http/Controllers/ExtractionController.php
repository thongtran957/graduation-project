<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\PdfToText\Pdf;

class ExtractionController extends Controller
{
    public function index()
    {
        return view('extraction');
    }

    public function uploadFile(Request $request)
    {
        $file = $request->file;
        $arr_file_name = explode('.', $file->getClientOriginalName());
        $file_name = $arr_file_name[0] . '-' . time() . '.' . $arr_file_name[1];
        $file->move('files', $file_name);
        $file_name = '/home/thongtran/projects/final-project/public/files/' . $file_name;

        DB::table('files')->insert(
            [
                'file_name' => $file_name,
                'annotate' => 0,
                'train' => 0,
            ]
        );

        $cmd_NER = '/usr/bin/python3 /home/thongtran/projects/cv-extraction/test.py' . ' ' . $file_name;
        $result_NER = shell_exec($cmd_NER);
        str_replace('\n', '<br>', $result_NER);

        $cmd_main = '/usr/bin/python3 /home/thongtran/projects/cv-extraction/main.py' . ' ' . $file_name;
        $result_main = shell_exec($cmd_main);
        str_replace('\n', '<br>', $result_main);

        return view('extraction', compact('result_main', 'result_NER'));
    }

}
