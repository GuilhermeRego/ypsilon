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

        $trimmedContent = trim(preg_replace('/<p><br><\/p>/', '', $request->content));
        $trimmedContentWithoutTags = trim(strip_tags($trimmedContent, '<img>'));

        if ($trimmedContentWithoutTags == '') {
            return redirect()->back()->with('error', 'Comment cannot be empty!');
        }

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id, // Assuming you have a post_id field
            'content' => $request->content,
            'date_time' => now(),
        ]);

        return redirect()->route('post.show', $request->post_id)->with('success', 'Comment submitted successfully!');
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