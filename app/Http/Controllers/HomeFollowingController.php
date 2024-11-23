<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class HomeFollowingController extends Controller
{
    /**
     * Display the home following page.
     */
    public function index()
    {
        // Get the users the current user is following
        $following = auth()->user()->following;
        return view('homefollowing', [
            'following' => $following,
        ]);
    }

    public function following()
    {
        $followingIds = auth()->user()->following()->pluck('followed_id');
        $posts = Post::whereIn('user_id', $followingIds)
                     ->orderBy('date_time', 'desc')
                     ->get();

        return view('homefollowing', compact('posts'));
    }
}
