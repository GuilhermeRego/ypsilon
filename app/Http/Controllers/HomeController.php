<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $posts = Post::whereNull('group_id')->orderBy('date_time', 'desc')->get();
        return view('home', compact('posts'));
    }

    public function following()
    {
        // Get the posts of the users the current user is following
        $posts = Post::whereHas('user', function ($query) {
            $query->whereIn('id', auth()->user()->following()->pluck('id'));
        })->orderBy('date_time', 'desc')->get();

        return view('homefollowing', compact('posts'));
    }
}