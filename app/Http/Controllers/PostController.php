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
        // Adicione validação para garantir que o conteúdo não esteja vazio
        $request->validate([
            'content' => 'required',
        ]);

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
        return view('post.show', compact('post'));
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
            'content' => 'required',
        ]);

        $post->update([
            'content' => $request->content,
        ]);

        return redirect()->route('post.show', $post)->with('success', 'Post updated successfully!');
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
