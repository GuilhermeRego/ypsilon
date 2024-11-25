<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Group;

class ResultsController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $type = $request->input('type', 'users');

        if ($type === 'posts') {
            $results = Post::where('content', 'LIKE', "%{$query}%")
                ->get();
        } elseif ($type === 'groups') {
            $results = Group::where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->get();
        } else {
            $results = User::where('username', 'LIKE', "%{$query}%")
                ->orWhere('nickname', 'LIKE', "%{$query}%")
                ->get();
        }

        return view('search.results', compact('query', 'results', 'type'));
    }
}