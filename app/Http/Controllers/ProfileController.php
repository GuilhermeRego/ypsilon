<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class ProfileController extends Controller
{
    /**
     * Display the specified user's profile.
     */
    public function show($username)
    {
        // Find the user by its username
        $user = User::where('username', $username)->firstOrFail();
        return view('profile.show', compact('user'));
    }

    /**
     * Display the user's posts.
     */
    public function posts($username)
    {
        // Find the user by their username
        $user = User::where('username', $username)->first();

        if (!$user) {
            abort(404);
        }

        // Get the user's posts and return the posts view
        $posts = Post::where('user_id', $user->id)
                     ->orderBy('date_time', 'desc')
                     ->get();

        return view('profile.posts', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }
}
