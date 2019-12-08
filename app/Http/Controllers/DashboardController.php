<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $results = DB::table('content_resumes')
            ->join('labels', 'labels.id', '=', 'content_resumes.label_id')
            ->join('resumes', 'resumes.id', '=', 'content_resumes.resume_id')
            ->select('content_resumes.*', 'resumes.content', 'labels.name', 'labels.color')
            ->paginate(10);
        return view("dashboard", compact('results'));
    }
}
