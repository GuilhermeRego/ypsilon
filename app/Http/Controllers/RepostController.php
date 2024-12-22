<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Repost;

class RepostController extends Controller
{
    public function store(Request $request, $post)
    {
        $post = Post::findOrFail($post);

        $repost = new Repost();
        $repost->user_id = auth()->id();
        $repost->post_id = $post->id;
        $repost->created_at = now();
        $repost->save();

        return redirect()->back()->with('success', 'Reposted successfully!');
    }

    public function destroy($post)
    {
        $repost = Repost::where('post_id', $post)->where('user_id', auth()->id())->firstOrFail();
        $repost->delete();

        return redirect()->back()->with('success', 'Repost removed successfully!');
    }
}