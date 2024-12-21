<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|min:1',
        ]);

        // Check if the post is not empty
        $trimmedContent = trim(preg_replace('/<p><br><\/p>/', '', $request->content));
        $trimmedContentWithoutTags = trim(strip_tags($trimmedContent, '<img>'));

        if ($trimmedContentWithoutTags == '') {
            return redirect()->back()->with('error', 'Post cannot be empty!');
        }

        $post = Post::create([
            'user_id' => auth()->id(),
            'date_time' => now(),
            'content' => $request->content,
            'group_id' => $request->group_id
        ]);

        return redirect()->back()->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = Post::with(['comments' => function ($query) {
            $query->orderBy('date_time', 'desc');
        }])->findOrFail($post->id);

        $user = auth()->user();

        // If post is in a group, its always visible, unless its from a private group I'm not a member of
        if ($post->group) {
            if (!$post->group->is_private) {
                return view('post.show', compact('post'));
            }

            if ($user && $post->group->members->contains($user->id)) {
                return view('post.show', compact('post'));
            }

            abort(403, 'Private group, you do not have access to this post.');
        }

        // If its not from a group, I can see it unless it's from a private account I don't follow
        if (!$post->group) {
            if (!$post->user->is_private) {
                return view('post.show', compact('post'));
            }

            if ($user && $user->following->contains('followed_id', $post->user_id)) {
                return view('post.show', compact('post'));
            }

            abort(403, 'Private account, you do not have access to this post.');
        }

        abort(403, 'You do not have access to this post.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|min:1',
        ]);

        $post->update([
            'content' => $request->content,
        ]);

        return redirect()->route('post.show', $post->id)->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        if ($post->group_id == null) {
            return redirect()->route('home')->with('success', 'Post deleted successfully!');
        }
        else {
            return redirect()->route('group.show', $post->group_id)->with('success', 'Post deleted successfully!');
        }
        
    }
}
