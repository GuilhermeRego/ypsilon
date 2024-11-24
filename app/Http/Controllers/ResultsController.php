<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ResultsController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('username', 'LIKE', "%{$query}%")
            ->orWhere('nickname', 'LIKE', "%{$query}%")
            ->get();

        return view('search.results', compact('query', 'users'));
    }
}