<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Group;
use Carbon\Carbon;
use App\Models\Reaction;

class AdminController extends Controller
{

    public function index()
    {
        $users = User::all();
        $posts = Post::all()->sortByDesc('date_time');
        $groups = Group::all();
        return view('admin.home', compact('users', 'posts', 'groups'));
    }
}