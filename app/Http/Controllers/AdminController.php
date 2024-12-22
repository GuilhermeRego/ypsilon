<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Group;
use Carbon\Carbon;
use App\Models\Reaction;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        if (auth()->user()->isAdmin()) {
            $users = User::all();
            $users = $users->sortByDesc('created_at');
            return view('admin.users', compact('users'));
        }
        else abort(403);
    }

    public function searchUsers(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            $query = $request->input('query');
            $users = User::where('username', 'LIKE', "%{$query}%")
                        ->orWhere('email', 'LIKE', "%{$query}%")
                        ->orWhere('nickname', 'LIKE', "%{$query}%")
                        ->get();
            return view('admin.users', compact('users'));
        } else {
            abort(403);
        }
    }

    public function posts()
    {
        if (auth()->user()->isAdmin()) {
            $posts = Post::all();
            $posts = $posts->sortByDesc('date_time');
            return view('admin.posts', compact('posts'));
        }
        else abort(403);
    }

    public function groups()
    {
        if (auth()->user()->isAdmin()) {
            $groups = Group::all();
            $groups = $groups->sortByDesc('created_at');
            return view('admin.groups', compact('groups'));
        } else {
            abort(403);
        }
    }

    public function reports()
    {
        if (auth()->user()->isAdmin()) {
            $reports = Report::with(['reporter', 'reported_user', 'group', 'post', 'comment'])->get();
            $reports = $reports->sortByDesc('created_at');
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