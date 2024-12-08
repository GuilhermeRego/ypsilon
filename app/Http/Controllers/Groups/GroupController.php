<?php

namespace App\Http\Controllers\Groups;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Image;
use App\Models\Group_Member;
use App\Models\Group_Owner;
use App\Models\Join_Request;

class GroupController extends Controller
{

    public function index($group)
    {
        // Get the group with the given ID and its posts
        $group = Group::findOrFail($group);
        $posts = $group->post()->orderBy('date_time', 'desc')->get();

        // Check if the current user is a guest
        if (!Auth()->check()) {
            return view('Groups.index', [
                'group' => $group,
                'isMember' => false,
                'isOwner' => false,
                'posts' => $posts,
            ]);
        }

        // Check if the current user is a member of the group
        $memberId = Group_Member::where('user_id', Auth()->user()->id)
            ->where('group_id', $group->id)
            ->value('id');

        $isMember = $memberId ? true : false;

        $isOwner = $isMember && Group_Owner::where('member_id', $memberId)->exists();
        $has_join_request=($group->join_request()->where('user_id', auth()->id())->exists());
        return view('Groups.index', [
            'group' => $group,
            'isMember' => $isMember,
            'isOwner' => $isOwner,
            'posts' => $posts,
            'has_join_request' => $has_join_request,
        ]);
    }

    public function create()
    {
        return view('Groups.creategroup');

    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:16',
            'description' => 'required|string|max:1000',
            'is_private' => 'nullable|boolean'

        ]);

        // Construct group
        $groupImageId = null;
        if ($request->hasFile('group_image')) {
            $imagePath = $request->file('group_image')->store('group_images', 'public');
            $groupImage = Image::create([
                'url' => $imagePath,
                'type' => 'group_profile',
            ]);
            $groupImageId = $groupImage->id;
        }

        $groupBannerId = null;
        if ($request->hasFile('group_banner')) {
            $bannerPath = $request->file('group_banner')->store('group_banners', 'public');
            $groupBanner = Image::create([
                'url' => $bannerPath,
                'type' => 'group_banner',
            ]);
            $groupBannerId = $groupBanner->id; // Get the ID of the created banner
        }

        // Store the group along with the image and banner IDs
        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'group_image' => $groupImageId,  // Store the ID of the group image
            'group_banner' => $groupBannerId, // Store the ID of the group banner
            'is_private' => $request->has('is_private'),
        ]);

        $group_member = Group_Member::create([
            'group_id' => $group->id,
            'user_id' => auth()->user()->id,
        ]);
        Group_Owner::create([
            'member_id' => $group_member->id,
        ]);
        return redirect()->route('groups.my-groups')->with('success', 'Group created successfully.');
    }

    public function joinGroup($groupId)
    {
        // Check if the user is a guest
        if (!Auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to join a group.');
        }

        // Check if the user is already a member of the group
        $existingMember = Group_Member::where('user_id', Auth()->user()->id)
            ->where('group_id', $groupId)
            ->exists();

        // If the user is already a member, redirect with an error message
        if ($existingMember) {
            return redirect()->route('group.show', $groupId)->with('error', 'You are already a member of this group.');
        }

        // If not, create a new group member with the user ID and group ID
        Group_Member::create([
            'user_id' => Auth()->user()->id,
            'group_id' => $groupId
        ]);

        return redirect()->route('group.show', $groupId)->with('success', 'You have successfully joined the group!');

    }
    public function leaveGroup($groupId)
    {
        // Check if the user is a guest
        if (!Auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to leave a group.');
        }

        // Check if the user is a member of the group
        $groupMember = Group_Member::where('user_id', Auth()->user()->id)
            ->where('group_id', $groupId);

        // If the user is not a member, redirect with an error message
        if (!$groupMember) {
            return redirect()->route('group.show', $groupId)->with('error', 'You are not a member of this group.');
        }

        // If the user is a member, delete the group member record
        $groupMember->delete();

        return redirect()->route('group.show', $groupId)->with('success', 'You have successfully left the group!');
    }

    public function edit($group)
    {
        $group = Group::findOrFail($group);
        $memberId = Group_Member::where('user_id', Auth()->user()->id)
            ->where('group_id', $group->id)
            ->value('id');

        $isMember = $memberId ? true : false;

        $isOwner = $isMember && Group_Owner::where('member_id', $memberId)->exists();
        if (!$isOwner && !auth()->user()->isAdmin()) {
            return redirect()->route('groups.discover')->with('error', 'You are not authorized to edit this group.');
        }
        return view('Groups.edit', ['group' => $group]);
    }

    public function update(Request $request, Group $group)
    {

        $request->validate([
            'name' => 'required|string|max:16',
            'description' => 'required|string|max:1000',
        ]);

        $group->name = $request->name;
        $group->description = $request->description;
        $group->is_private = $request->has('is_private');

        if ($request->hasFile('group_image')) {
            $groupImagePath = $request->file('group_image')->store('group_images', 'public');
            if ($group->group_image) {
                $group->groupImage->update(['url' => $groupImagePath]);
            } else {
                $groupImage = Image::create([
                    'url' => $groupImagePath,
                    'type' => 'group_profile',
                ]);
                $group->group_image = $groupImage->id;
            }
        }

        if ($request->hasFile('group_banner')) {
            $groupBannerPath = $request->file('group_banner')->store('group_banners', 'public');
            if ($group->group_banner) {
                $group->groupBanner->update(['url' => $groupBannerPath]);
            } else {
                $groupBanner = Image::create([
                    'url' => $groupBannerPath,
                    'type' => 'group_banner',
                ]);
                $group->group_banner = $groupBanner->id;
            }
        }


        $group->save();

        return redirect()->route('group.show', $group)->with('success', 'Group updated successfully!');
    }
    public function destroy(Group $group){
        foreach ($group->post as $post)
            $post->delete();
        $group->delete();
        return redirect()->route('groups.my-groups')->with('success', 'Group deleted successfully!');
    }

    public function sendJoinRequest($groupId){
        $group = Group::findOrFail($groupId);
        if (!$group->is_private) {
            return redirect()->route('group.show', $groupId)->with('error', 'This group is not private.');
        }
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to request to join a group.');
        }
        if ($group->group_member()->where('user_id', auth()->id())->exists()) {
            return redirect()->route('group.show', $groupId)->with('error', 'You are already a member of this group.');
        }
        if ($group->join_request()->where('user_id', auth()->id())->exists()) {
            return redirect()->route('group.show', $groupId)->with('error', 'You have already sent a request to join this group.');
        }
        Join_Request::Create([
            'user_id' => auth()->id(),
            'group_id' => $groupId,
        ]);
        return redirect()->route('group.show', $groupId)->with('success', 'Your join request has been sent!');
    }
}
