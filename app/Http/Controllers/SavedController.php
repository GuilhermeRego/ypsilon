<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Saved_Post;
use Illuminate\Http\Request;

class SavedController extends Controller
{
    public function index($username)
{
    if (auth()->user()->username != $username) {
        abort(403);  
        }
    $user = User::where('username', $username)->firstOrFail();
    $posts = $user->savedPosts()
    ->with('post')  
    ->orderBy('date_time', 'desc')  
    ->get()
    ->pluck('post');
    return view("saved.index", ['posts' => $posts]);
}
    public function create($post)
    {
        $post = Post::findOrFail($post);
        if($post->group_id !== null) {
            abort(403);
        }
        Saved_Post::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'date_time' => now(),
        ]);
        return redirect()->back()->with('success', 'Post saved successfully!');
    }
    public function destroy($post)
    {
        
        $post = Post::findOrFail($post);
        if($post->group_id !== null) {
            abort(403);
        }
        $saved = Saved_Post::where('user_id', auth()->user()->id)->where('post_id', $post->id)->first();
        $saved->delete();
        return redirect()->back()->with('success', 'Post removed successfully!');
    }

}
