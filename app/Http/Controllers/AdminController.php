<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Group;
use Carbon\Carbon;
use App\Models\Reaction;
use App\Models\Report;

class AdminController extends Controller
{
    public function users()
    {
        if (auth()->user()->isAdmin()) {
            $users = User::all();
            return view('admin.users', compact('users'));
        }
        else abort(403);
    }

    public function posts()
    {
        if (auth()->user()->isAdmin()) {
            $posts = Post::all();
            return view('admin.posts', compact('posts'));
        }
        else abort(403);
    }

    public function groups()
    {
        if (auth()->user()->isAdmin()) {
            $groups = Group::all();
            return view('admin.groups', compact('groups'));
        } else {
            abort(403);
        }
    }

    public function reports()
    {
        if (auth()->user()->isAdmin()) {
            $reports = Report::all();
            return view('admin.reports', compact('reports'));
        } else {
            abort(403);
        }
    }

    public function index()
    {
        $users = User::all();
        $posts = Post::all();
        $groups = Group::all();
        $reports = Report::all();

        // Example data for charts
        $userGrowthData = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                              ->groupBy('date')
                              ->orderBy('date')
                              ->get()
                              ->pluck('count', 'date')
                              ->toArray();

        $postActivityData = Post::selectRaw('DATE(date_time) as date, COUNT(*) as count')
                                ->groupBy('date')
                                ->orderBy('date')
                                ->get()
                                ->pluck('count', 'date')
                                ->toArray();

        return view('admin.home', compact('users', 'posts', 'groups', 'reports', 'userGrowthData', 'postActivityData'));
    }
}