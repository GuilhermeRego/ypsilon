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
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'date_time' => 'required|date',
            'content' => 'required|string|max:255',
            'group_id' => 'nullable|integer'
        ]);

        Post::create($validatedData);

        return redirect()->back()->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Check if the user is the owner of the post
        if (auth()->user()->id != $post->user_id) abort(403);

        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Check if the user is the owner of the post
        if (auth()->user()->id != $post->user_id) abort(403);

        // Validate the request
        $validatedData = $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $post->content = $validatedData['content'];
        $post->save();

        return redirect()->route('profile.show', ['username' => auth()->user()->username])
                         ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
