<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Group;
use App\Models\Report;

class HomeAdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
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

            $postActivityData = Post::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                                    ->groupBy('date')
                                    ->orderBy('date')
                                    ->get()
                                    ->pluck('count', 'date')
                                    ->toArray();

            return view('admin.home', compact('users', 'posts', 'groups', 'reports', 'userGrowthData', 'postActivityData'));
        }
        else abort(403);
    }
}
