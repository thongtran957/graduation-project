<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $count_resume = DB::table('resumes')->get()->count();
        $count_label = DB::table('labels')->get()->count();
        $labels = DB::table('labels')->get()->toArray();

        $results = DB::table('content_resumes')
            ->join('labels', 'labels.id', '=', 'content_resumes.label_id')
            ->join('resumes', 'resumes.id', '=', 'content_resumes.resume_id')
            ->select('content_resumes.*', 'resumes.content', 'labels.name', 'labels.color')
            ->paginate(10);
        return view("dashboard", compact('results', 'count_resume', 'count_label', 'labels'));
    }

    public function search(Request $request)
    {
        $count_resume = DB::table('resumes')->get()->count();
        $count_label = DB::table('labels')->get()->count();
        $labels = DB::table('labels')->get()->toArray();

        $data = $request->all();

        $arr_label_id = [];
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                array_push($arr_label_id, $key);
            };
        }
        $results = DB::table('content_resumes')
            ->join('labels', 'labels.id', '=', 'content_resumes.label_id')
            ->join('resumes', 'resumes.id', '=', 'content_resumes.resume_id')
            ->select('content_resumes.*', 'resumes.content', 'labels.name', 'labels.color');
        if (!empty($arr_label_id)) {
            $results = $results->whereIn('label_id', $arr_label_id);
        }
        if ($request->search != "") {
            $results = $results->where('text', 'LIKE', '%' . $request->search . '%');
        }
        $results = $results->paginate(10);
        return view("dashboard", compact('results', 'count_resume', 'count_label', 'labels'));
    }
}
