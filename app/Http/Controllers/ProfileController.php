<?php

namespace App\Http\Controllers;

use App\Models\Follow_Request;
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
        $isFollowedByAuth = Follow::where('follower_id', auth()->id())
            ->where('followed_id', $user->id)
            ->exists();
        $hasFollowRequest = Follow_Request::where('follower_id', auth()->id())
            ->where('followed_id', $user->id)
            ->exists();
        $posts = $user->posts()->whereNull('group_id')->orderBy('date_time', 'desc')->get();
        $reposts = $user->reposts()->with('post')->orderBy('created_at', 'desc')->get();

        // Combine posts and reposts
        $combinedPosts = $posts->merge($reposts->pluck('post')->each(function ($post) use ($reposts) {
            $repost = $reposts->firstWhere('post_id', $post->id);
            if ($repost) {
                $post->repost_created_at = $repost->created_at;
            }
        }))->sortByDesc(function ($post) {
            return $post->repost_created_at ?? $post->date_time ?? $post->created_at;
        });
        return view('profile.show', compact('user', 'isFollowedByAuth', 'hasFollowRequest', 'username', 'combinedPosts'));

    }

    /**
     * Edit user profile
     */
    public function edit($username)
    {
        // Check if the current user is the owner of the profile
        if (auth()->user()->username != $username && !(auth()->user()->isAdmin()))
            abort(403);

        // Find the user by its username
        $user = User::where('username', $username)->firstOrFail();

        return view('profile.edit', compact('user'));
    }

    /**
     * Update user profile
     */
    public function update(Request $request, $username)
    {
        if (auth()->user()->username != $username && !(auth()->user()->isAdmin()))
            abort(403);

        $user = User::where('username', $username)->firstOrFail();

        $validatedData = $request->validate([
            'nickname' => 'required|string|max:16',
            'bio' => 'nullable|string|max:1000',
            'profile_image' => 'nullable|image|mimes:jpeg,gif,png,jpg|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->nickname = $request->nickname;
        $user->bio = $request->bio;
        $user->is_private = $request->has('is_private') ? 1 : 0;

        if ($request->hasFile('profile_image')) {
            $imageName = time() . '_' . $request->file('profile_image')->getClientOriginalName();
            $imagePath = $request->file('profile_image')->move(public_path('profile_images'), $imageName);

            if ($user->profile_image) {
                $user->profileImage->update(['url' => 'profile_images/' . $imageName]);
            } else {
                $profileImage = Image::create([
                    'url' => 'profile_images/' . $imageName,
                    'type' => 'user_profile',
                ]);
                $user->profile_image = $profileImage->id;
            }
        }

        if ($request->hasFile('banner_image')) {
            $bannerName = time() . '_' . $request->file('banner_image')->getClientOriginalName();
            $bannerPath = $request->file('banner_image')->move(public_path('profile_banners'), $bannerName);

            if ($user->banner_image) {
                $user->bannerImage->update(['url' => 'profile_banners/' . $bannerName]);
            } else {
                $bannerImage = Image::create([
                    'url' => 'banner_images/' . $bannerName,
                    'type' => 'user_banner',
                ]);
                $user->banner_image = $bannerImage->id;
            }
        }

        $user->save();

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
        $user = User::where('username', $username)->firstOrFail();
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

    public function manageFollowers($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        if (auth()->user()->id != $user->id) {
            abort(403, "This isn't your account");
        }
        $followers = $user->followers;

        return view("profile.manageFollowers", compact('user', 'followers'));
    }

    public function manageRequests($username)
    {
        $user = User::where('username', $username)->firstOrFail();
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

    public function toggleFollowRequest($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $authUserId = Auth::id();

        $existingFollowRequest = Follow_Request::where('follower_id', $authUserId)
            ->where('followed_id', $user->id)
            ->first();

        if ($existingFollowRequest) {
            $existingFollowRequest->delete();
            return redirect()->route('profile.show', $username)->with('success', 'You have cancelled your follow request.');
        } else {
            Follow_Request::create([
                'follower_id' => $authUserId,
                'followed_id' => $user->id,
            ]);
            return redirect()->route('profile.show', $username)->with('success', 'You have requested to follow this user!');
        }
    }
}



