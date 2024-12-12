<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /*
    * Display a listing of the resource.
    */
    public function index()
    {
        //
    }

    /*
    * Show the form for creating a new resource.
    */
    public function create()
    {
        //
    }

    /*
    * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'date_time' => now(),
            'content' => $request->content,
            'post_id' => $request->post_id
        ]);

        return redirect()->back()->with('success', 'Comment created successfully!');
    }

    /*
    * Display the specified resource.
    */
    public function show(Comment $comment)
    {
        //
    }

    /*
    * Show the form for editing the specified resource.
    */
    public function edit(Comment $comment)
    {
        if (auth()->user()->id != $comment->user_id && !(auth()->user()->isAdmin()))
            abort(403);
        return view('comment.edit', compact('comment'));
    }

    /*
    * Update the specified resource in storage.
    */
    public function update(Request $request, Comment $comment)
    {
        if (auth()->user()->id != $comment->user_id && !(auth()->user()->isAdmin()))
            abort(403);

        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('post.show', $comment->post_id)->with('success', 'Comment updated successfully!');
    }

    /*
    * Remove the specified resource from storage.
    */
    public function destroy(Comment $comment)
    {
        if (auth()->user()->id != $comment->user_id && !(auth()->user()->isAdmin()))
            abort(403);

        $comment->delete();

        return redirect()->route('post.show', $comment->post_id)->with('success', 'Comment deleted successfully!');
    }
}