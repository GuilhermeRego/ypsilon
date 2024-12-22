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
        $existingReaction = Reaction::where('user_id', $request->id)
                                    ->where('post_id', $request->post_id)
                                    ->first();
        
        if ($request->is_like == 'true') {
            $request->is_like = true;
        } else {
            $request->is_like = false;
        }
        
        if ($existingReaction) {
            \Log::debug('Existing Reaction Found', ['existing_is_like' => $existingReaction->is_like, 'request_is_like' => $request->is_like]);

            if ($existingReaction->is_like != $request->is_like) {
                // Update the existing reaction
                \Log::debug('Condition 1');
                $existingReaction->is_like = $request->is_like;
                $existingReaction->save();
            } else {
                // Delete the existing reaction if the same reaction is being toggled
                \Log::debug('Condition 2');
                $existingReaction->delete();
                return redirect()->back();
            }
        } else {
            // Create a new reaction if it doesn't exist
            \Log::debug('Creating New Reaction');
            $reaction = new Reaction();
            $reaction->user_id = $request->user_id;
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
