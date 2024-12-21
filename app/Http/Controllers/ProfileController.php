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
            'nickname' => 'required|string|max:16',
            'bio' => 'nullable|string|max:1000',
        ]);

        $user->nickname = $request->nickname;
        $user->bio = $request->bio;
        $user->is_private = $request->has('is_private') ? 1 : 0;

        // Handle profile image
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
            if ($user->profile_image) {
                // Update the existing profile image
                $user->profileImage->update(['url' => $profileImagePath]);
            } else {
                // Create a new profile image
                $profileImage = Image::create([
                    'url' => $profileImagePath,
                    'type' => 'user_profile',
                ]);
                $user->profile_image = $profileImage->id; // Associate new image
            }
        }

    // Handle banner image
        if ($request->hasFile('banner_image')) {
            $bannerImagePath = $request->file('banner_image')->store('banner_images', 'public');
            if ($user->banner_image) {
                // Update the existing banner image
                $user->bannerImage->update(['url' => $bannerImagePath]);
            } else {
                // Create a new banner image
                $bannerImage = Image::create([
                    'url' => $bannerImagePath,
                    'type' => 'user_banner',
                ]);
                $user->banner_image = $bannerImage->id; // Associate new image
            }
        }
        // Save user profile changes
        $user->save();

        // Redirect back to the profile page with a success message
        return redirect()->route('profile.show', $user->username)
            ->with('success', 'Profile updated successfully!');
    }


    public function destroy($username)
    {
        // Check if the current user is the owner of the profile or an admin
        if (Auth::user()->id != auth()->user()->id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        // Find the user by its username
        $user = User::where('username', $username)->firstOrFail();

        // Delete user's reactions and then the account
        for ($i = 0; $i < count($user->reactions); $i++) {
            $user->reactions[$i]->update([
                'user_id' => null,
            ]);
        }

        // Make every user post as anonymous author
        for ($i = 0; $i < count($user->posts); $i++) {
            $user->posts[$i]->update([
                'user_id' => null,
            ]);
        }

        // Make every user comment as anonymous author
        for ($i = 0; $i < count($user->comments); $i++) {
            $user->comments[$i]->update([
                'user_id' => null,
            ]);
        }

        $user->delete();

        return redirect()->route('home')->with('status', 'User deleted successfully');
    }


    public function toggleFollow($username)
    {
        $user = User::where('username',$username)->firstOrFail();
        $authUserId = Auth::id();

        $existingFollow = Follow::where('follower_id', $authUserId)
            ->where('followed_id', $user->id)
            ->first();

        if ($existingFollow) {
            $existingFollow->delete();
            return redirect()->route('profile.show', $username)->with('success', 'You have successfully unfollowed this user!');
        } else {
            Follow::create([
                'follower_id' => $authUserId,
                'followed_id' => $user->id,
            ]);
            return redirect()->route('profile.show', $username)->with('success', 'You have successfully followed this user!');
        }
    }

    public function manageFollowers($username) {
        $user = User::where('username',$username)->firstOrFail();
        if (auth()->user()->id != $user->id) {
            abort(403, "This isn't your account");
        } 
        $followers = $user->followers;

        return view("profile.manageFollowers", compact('user', 'followers'));
    }

    public function manageRequests($username) {
        $user = User::where('username',$username)->firstOrFail();
        if (auth()->user()->id != $user->id) {
            abort(403, "This isn't your account");
        } 
        $follower_requests = $user->follower_requests;

        return view("profile.manageRequests", compact('user', 'follower_requests'));
    }

    public function removeFollower($username, $followerId)
{
    $user = User::where('username', $username)->firstOrFail();

    if (auth()->user()->id != $user->id) {
        abort(403, "This isn't your account");
    }

    $follow = Follow::where('follower_id', $followerId)
        ->where('followed_id', $user->id)
        ->first();

    if ($follow) {
        $follow->delete();
        return redirect()->route('profile.manageFollowers', $username)->with('success', 'Follower removed successfully!');
    } else {
        return redirect()->route('profile.manageFollowers', $username)->with('error', 'This user is not following you.');
    }
}

}



