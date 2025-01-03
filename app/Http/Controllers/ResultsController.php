<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Group;

class ResultsController extends Controller
{
    public function index(Request $request)
    {
        $query = strtolower($request->input('query'));
        $type = $request->input('type', 'users'); // Default to 'users' if type is not specified

        if ($type === 'posts') {
            $results = Post::WhereRaw('LOWER(content) LIKE ?', ["%{$query}%"])
                ->paginate(10);
        } elseif ($type === 'groups') {
            $results = Group::whereRaw('LOWER(name) LIKE ?', ["%{$query}%"])
                ->orWhereRaw('LOWER(description) LIKE ?', ["%{$query}%"])
                ->paginate(10);
        } else {
            $results = User::whereRaw('LOWER(username) LIKE ?', ["%{$query}%"])
                ->orWhereRaw('LOWER(nickname) LIKE ?', ["%{$query}%"])
                ->paginate(10);
        }

        return view('search.results', compact('query', 'results', 'type'));
    }
}