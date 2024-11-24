<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Image;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the specified user's profile.
     */
    public function show($username)
    {
        // Find the user by its username
        $user = User::where('username', $username)->firstOrFail();
        $isFollowedByAuth = Follow::where('follower_id', Auth::id())
            ->where('followed_id', $user->id)
            ->exists();

        return view('profile.show', compact('user','isFollowedByAuth'));
    }

    /**
     * Edit user profile
     */
    public function edit($username)
    {
        // Check if the current user is the owner of the profile
        if (auth()->user()->username != $username && !(auth()->user()->isAdmin())) abort(403);
        
        // Find the user by its username
        $user = User::where('username', $username)->firstOrFail();

        return view('profile.edit', compact('user'));
    }

    /**
     * Update user profile
     */
    public function update(Request $request, $username)
    {
        // Check if the current user is the owner of the profile
        if (auth()->user()->username != $username && !(auth()->user()->isAdmin())) abort(403);

        // Find the user by its username
        $user = User::where('username', $username)->firstOrFail();

        // Validate Data
        $validatedData = $request->validate([
            'nickname' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
        ]);

        // Handle profile image
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
            $profileImage = Image::create([
                'url' => $profileImagePath,
                'type' => 'user_profile',
            ]);
            $profileImageId = $profileImage->id;
        }

        // Handle banner image
        if ($request->hasFile('banner_image')) {
            $bannerImagePath = $request->file('banner_image')->store('banner_images', 'public');
            $bannerImage = Image::create([
                'url' => $bannerImagePath,
                'type' => 'banner_image',
            ]);
            $bannerImageId = $bannerImage->id;
        }

        // Update user profile
        $user->update([
            'nickname' => $validatedData['nickname'],
            'bio' => $validatedData['bio'],
            'profile_image' => $profileImageId ?? $user->profile_image,
            'banner_image' => $bannerImageId ?? $user->banner_image,
        ]);

        return redirect()->route('profile.show', $user->username);
    }

    public function destroy($username)
    {
        // Check if the current user is the owner of the profile or an admin
        if (Auth::user()->id != auth()->user()->id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        // Find the user by its username
        $user = User::where('username', $username)->firstOrFail();

        // Delete user's posts and then the account
        foreach ($user->posts as $post) {
            $post->reactions()->delete();
        }

        for ($i = 0; $i < count($user->posts); $i++) {
            $user->posts[$i]->delete();
        }

        $user->delete();

        return redirect()->route('home')->with('status', 'User deleted successfully');
    }

    public function toggleFollow($id)
    {
        $authUserId = Auth::id();

        $existingFollow = Follow::where('follower_id', $authUserId)
            ->where('followed_id', $id)
            ->first();

        if ($existingFollow) {
            $existingFollow->delete();
            return response()->json(['message' => 'Unfollowed successfully']);
        } else {
            Follow::create([
                'follower_id' => $authUserId,
                'followed_id' => $id,
            ]);
            return response()->json(['message' => 'Followed successfully']);
        }
    }

}