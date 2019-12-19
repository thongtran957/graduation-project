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
        $current_time = time();
        $file = $request->file;
        $arr_file_name = explode('.', $file->getClientOriginalName());
        $file_name = $arr_file_name[0] . '-' . time() . '.' . $arr_file_name[1];
        $file->move('files', $file_name);
        $file_name = '/home/thongtran/projects/final-project/public/files/' . $file_name;

        $content = trim((new Pdf())
            ->setPdf($file_name)
            ->text());

        $cmd_NER = '/usr/bin/python3 /home/thongtran/projects/cv-extraction/test.py' . ' ' . $file_name;
        $result_NER = shell_exec($cmd_NER);
        $duration = time() - $current_time;

        $result = [];
        $arr = explode('enter', $result_NER);
        foreach ($arr as $value) {
            $extract_result = explode(':', $value);
            if (isset($extract_result[0]) && isset($extract_result[1])) {
                $result[trim($extract_result[0])] = trim($extract_result[1]);

            }
        }

        return view('extraction', compact('result', 'duration', 'file_name', 'content'));
    }

    public function saveDB(Request $request)
    {
        $data = $request->all();

        $content = trim((new Pdf())
            ->setPdf($data['file_name'])
            ->text());

        $resume_id = DB::table('resumes')->insertGetId([
            'content' => $content,
        ]);

        foreach ($data as $key => $value) {
            $label = DB::table('labels')->where('name', trim($key))->first();
            if (isset($label)) {
                DB::table('result_resumes')->insert([
                    'resume_id' => $resume_id,
                    'label_id' => $label->id,
                    'text' => $value,
                ]);
            }
        }

        $msg = "Save database success";
        return redirect()->route('extraction.index', compact('msg'));
    }

}
