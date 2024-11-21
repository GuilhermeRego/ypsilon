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
        $posts = Post::orderBy('date_time', 'desc')->get();
        return view('home', compact('posts'));
    }
}