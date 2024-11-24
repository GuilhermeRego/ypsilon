<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nickname' => 'required|string|max:255',
            'username' => 'required|string|max:16|unique:User',
            'password' => 'required|string|min:8',
            'birth_date' => 'required|date',
            'email' => 'required|string|email|max:255|unique:User',
        ]);

        $user = User::create([
            'nickname' => $validatedData['nickname'],
            'username' => $validatedData['username'],
            'password' => ($validatedData['password']),
            'birth_date' => $validatedData['birth_date'],
            'email' => $validatedData['email'],
        ]);

        return redirect()->route('users.show', $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $posts = $user->posts;
        $followers = $user->followers;
        $following = $user->following;
        return view('user.show', compact('user', 'posts', 'followers', 'following'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'nickname' => 'required|string|max:255',
            'username' => 'required|string|max:16|unique:User,username,' . $user->id,
            'password' => 'nullable|string|min:8',
            'birth_date' => 'required|date',
            'email' => 'required|string|email|max:255|unique:User,email,' . $user->id,
        ]);

        $user->update([
            'nickname' => $validatedData['nickname'],
            'username' => $validatedData['username'],
            'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password,
            'birth_date' => $validatedData['birth_date'],
            'email' => $validatedData['email'],
        ]);

        return redirect()->route('users.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Check if the user is an admin or the owner of the profile
        if (auth()->user()->id != $user->id && !(auth()->user()->admin())) abort(403);

        $user->delete();
        return redirect()->back();
    }
}
