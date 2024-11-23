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

    public function following()
    {
        // Obtenha os posts que o usuário está seguindo
        $posts = Post::whereHas('user', function ($query) {
            $query->whereIn('id', auth()->user()->following()->pluck('id'));
        })->orderBy('date_time', 'desc')->get();

        return view('homefollowing', compact('posts'));
    }
}