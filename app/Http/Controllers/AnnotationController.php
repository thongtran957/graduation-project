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
        $file->move('files', $file->getClientOriginalName());
        $path = public_path() . '/files/' . $file->getClientOriginalName();
        $text = (new Pdf())
            ->setPdf($path)
            ->text();
        $text = trim($text);
        return view('annotation-label', compact('text'));
    }

    public function writeFile(Request $request){
        dd($request->all());
    }

    public function test()
    {
        dd(123);
        $result = shell_exec('/usr/bin/python3 /home/thongtran/projects/cv-extraction/main.py');
        dd($result);
    }

}
