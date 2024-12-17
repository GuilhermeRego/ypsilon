<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Group;

class ReportController extends Controller
{
    public function post(Post $post)
    {
        return view('report.post', compact('post'));
    }

    public function store(Request $request)
    {
        if ($request->reported_user_id != NULL) {
            $report = new Report();
            $report->reporter_user_id = auth()->user()->id;
            $report->reported_user_id = $request->reported_user_id;
            $report->justification = $request->justification;
            $report->date_time = now();
            $report->save();
        }
        else if ($request->reported_post_id != NULL) {
            $report = new Report();
            $report->reporter_user_id = auth()->user()->id;
            $report->reported_post_id = $request->reported_post_id;
            $report->justification = $request->justification;
            $report->date_time = now();
            $report->save();
        }
        else if ($request->reported_comment_id != NULL) {
            $report = new Report();
            $report->reporter_user_id = auth()->user()->id;
            $report->reported_comment_id = $request->reported_comment_id;
            $report->justification = $request->justification;
            $report->date_time = now();
            $report->save();
        }
        else if ($request->reported_group_id != NULL) {
            $report = new Report();
            $report->reporter_user_id = auth()->user()->id;
            $report->reported_group_id = $request->reported_group_id;
            $report->justification = $request->justification;
            $report->date_time = now();
            $report->save();
        }
        
        return redirect()->route('home')->with('success', 'Report submitted successfully!');
    }
}