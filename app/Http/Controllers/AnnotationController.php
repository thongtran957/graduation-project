<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\PdfToText\Pdf;
use App\Models\FileResume;
use Illuminate\Support\Facades\DB;


class AnnotationController extends Controller
{
    public function index()
    {
        $list_file = FileResume::where('annotate', 0)->get()->toArray();
        return view('annotation', compact('list_file'));
    }

    public function uploadFile(Request $request)
    {
        $labels = DB::table('labels')->get()->toArray();
        $file = $request->file;
        $arr_file_name = explode('.', $file->getClientOriginalName());
        $file_name = $arr_file_name[0] . '-' . time() . '.' . $arr_file_name[1];
        $file->move('files', $file_name);
        $file_name = '/home/thongtran/projects/final-project/public/files/' . $file_name;

        $content = (new Pdf())
            ->setPdf($file_name)
            ->text();
        $content = trim($content);

        DB::table('files')->insert(
            [
                'file_name' => $file_name,
                'annotate' => 0,
                'train' => 0,
                'content' => $content,
            ]
        );

        return view('annotation-label', compact('content', 'file_name', 'labels'));
    }

    public function uploadFile2($file_name)
    {
        $file_name = '/home/thongtran/projects/final-project/public/files/' . $file_name;
        $file = FileResume::where('file_name', $file_name)->where('annotate', 0)->get()->toArray();

        if ($file) {
            $content = (new Pdf())
                ->setPdf($file_name)
                ->text();
            $content = trim($content);
            return view('annotation-label', compact('content', 'file_name'));
        } else {
            $list_file = FileResume::where('annotate', 0)->get()->toArray();
            return view('annotation', compact('list_file'));
        }
    }

    public function writeFile(Request $request)
    {
        $file = FileResume::where('file_name', $request->file_name)->where('annotate', 0)->get()->toArray();
        if ($file) {
            $arr = explode('/', $request->file_name);
            $file_train = explode('.', $arr[7])[0] . '.json';

            $obj = new \stdClass();
            $content = trim((new Pdf())
                ->setPdf($request->file_name)
                ->text());

            $obj->content = $content;

            $annotations = [];
            foreach ($request->data as $annotation) {
                $obj_annotation = new \stdClass();
                $obj_annotation->label = [$annotation['label']];
                $obj_points = new \stdClass();
                $obj_points->start = (int)$annotation['start'];
                $obj_points->end = (int)$annotation['end'];
                $obj_points->text = $annotation['text_selection'];
                $obj_annotation->points = [$obj_points];
                array_push($annotations, $obj_annotation);

                $label_id = DB::table('labels')->where('name', $annotation['label'])->select('id')->first();

                DB::table('content_file_trains')->insert([
                    'file_id' => $file[0]['id'],
                    'label_id' => $label_id->id,
                    'text' => $annotation['text_selection'],
                    'start' => (int)$annotation['start'],
                    'end' => (int)$annotation['end'],
                ]);
            }

            $obj->annotation = $annotations;

            $file_json_name = '/home/thongtran/projects/final-project/public/files/' . $file_train;
            $file = fopen($file_json_name, 'w+');
            fwrite($file, json_encode($obj));
            fclose($file);

            FileResume::where('file_name', $request->file_name)->update([
                'annotate' => 1,
                'file_train' => $file_json_name,
            ]);

            $msg = "You have annotated success";
            return response([
                'status' => 'success',
                'msg' => $msg,
            ], 200);
        } else {
            $list_file = FileResume::where('annotate', 0)->get()->toArray();
            return view('annotation', compact('list_file'));
        }
    }

}
