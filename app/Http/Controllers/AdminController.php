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
            $users = User::orderByDesc('created_at')->paginate(10); 
            return view('admin.users', compact('users'));
        } else {
            abort(403);
        }
    }

    public function searchUsers(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            $query = strtolower($request->input('query'));
            $users = User::whereRaw('LOWER(username) LIKE ?', ["%{$query}%"])
                ->orWhereRaw('LOWER(email) LIKE ?', ["%{$query}%"])
                ->orWhereRaw('LOWER(nickname) LIKE ?', ["%{$query}%"])
                ->paginate(10);
            return view('admin.users', compact('users'));
        } else {
            abort(403);
        }
    }

    public function posts()
    {
        if (auth()->user()->isAdmin()) {
            $posts = Post::orderBy('date_time', 'desc')->paginate(10);
            return view('admin.posts', compact('posts'));
        } else
            abort(403);
    }

    public function searchPosts(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            $query = strtolower($request->input('query'));
            $posts = Post::whereRaw('LOWER(content) LIKE ?', ["%{$query}%"])
                ->orWhereHas('user', function ($q) use ($query) {
                    $q->whereRaw('LOWER(username) LIKE ?', ["%{$query}%"]);
                })
                ->paginate(10);
            return view('admin.posts', compact('posts'));
        } else {
            abort(403);
        }
    }

    public function groups()
    {
        if (auth()->user()->isAdmin()) {
            $groups = Group::orderByDesc('created_at')->paginate(10); 
            return view('admin.groups', compact('groups'));
        } else {
            abort(403);
        }
    }

    public function searchGroups(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            $query = strtolower($request->input('query'));
            $groups = Group::whereRaw('LOWER(name) LIKE ?', ["%{$query}%"])
                ->orWhereRaw('LOWER(description) LIKE ?', ["%{$query}%"])
                ->paginate(10);
            return view('admin.groups', compact('groups'));
        } else {
            abort(403);
        }
    }

    public function reports()
    {
        if (auth()->user()->isAdmin()) {
            $reports = Report::with(['reporter', 'reported_user', 'group', 'post', 'comment'])
                ->orderByDesc('date_time') 
                ->paginate(10); 
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