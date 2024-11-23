<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
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
        // Check if the user has already reacted to this post
        $existingReaction = Reaction::where('user_id', auth()->user()->id)
                                    ->where('post_id', $request->post_id)
                                    ->first();
        
        if ($existingReaction) {
            // Update the existing reaction
            $existingReaction->is_like = $request->is_like;
            $existingReaction->save();
        } else {
            // Create a new reaction
            $reaction = new Reaction;
            $reaction->user_id = auth()->user()->id;
            $reaction->post_id = $request->post_id;
            $reaction->is_like = $request->is_like;
            $reaction->save();
        }

        // Redirect back to the previous page
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Reaction $reaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reaction $reaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reaction $reaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reaction $reaction)
    {
        //
    }
}
