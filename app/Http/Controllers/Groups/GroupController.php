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

        $memberId = Group_Member::where('user_id', Auth()->user()->id)
            ->where('group_id', $group->id)
            ->value('id');

        $isMember = $memberId ? true : false;

        $isOwner = $isMember && Group_Owner::where('member_id', $memberId)->exists();
        $has_join_request = ($group->join_request()->where('user_id', auth()->id())->exists());
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
        $request->validate([
            'name' => 'required|string|max:30',
            'description' => 'required|string|max:1000',
            'is_private' => 'nullable|boolean',
            'group_image' => 'nullable|image|mimes:jpeg,gif,png,jpg|max:2048',
            'group_banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $groupImageId = null;
        if ($request->hasFile('group_image')) {
            $imageName = time() . '_' . $request->file('group_image')->getClientOriginalName();
            $imagePath = $request->file('group_image')->move(public_path('group_images'), $imageName);

            $groupImage = Image::create([
                'url' => 'group_images/' . $imageName,
                'type' => 'group_profile',
            ]);
            $groupImageId = $groupImage->id;
        }

        $groupBannerId = null;
        if ($request->hasFile('group_banner')) {
            $bannerName = time() . '_' . $request->file('group_banner')->getClientOriginalName();
            $bannerPath = $request->file('group_banner')->move(public_path('group_banners'), $bannerName);

            $groupBanner = Image::create([
                'url' => 'group_banners/' . $bannerName,
                'type' => 'group_banner',
            ]);
            $groupBannerId = $groupBanner->id;
        }

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'group_image' => $groupImageId,
            'group_banner' => $groupBannerId,
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
        if (!Auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to join a group.');
        }

        $existingMember = Group_Member::where('user_id', Auth()->user()->id)
            ->where('group_id', $groupId)
            ->exists();

        if ($existingMember) {
            return redirect()->route('group.show', $groupId)->with('error', 'You are already a member of this group.');
        }

        Group_Member::create([
            'user_id' => Auth()->user()->id,
            'group_id' => $groupId
        ]);

        return redirect()->route('group.show', $groupId)->with('success', 'You have successfully joined the group!');

    }
    public function leaveGroup($groupId)
    {
        if (!Auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to leave a group.');
        }

        $groupMember = Group_Member::where('user_id', Auth()->user()->id)
            ->where('group_id', $groupId);

        if (!$groupMember) {
            return redirect()->route('group.show', $groupId)->with('error', 'You are not a member of this group.');
        }

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
            'name' => 'required|string|max:30',
            'description' => 'required|string|max:1000',
            'group_image' => 'nullable|image|mimes:jpeg,gif,png,jpg|max:2048',
            'group_banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $previousIsPrivate = $group->is_private;
        $group->name = $request->name;
        $group->description = $request->description;
        $group->is_private = $request->has('is_private');
    
        if ($previousIsPrivate && !$group->is_private) {
            $joinRequests = $group->join_request;
    
            foreach ($joinRequests as $joinRequest) {
                Group_Member::create([
                    'user_id' => $joinRequest->user_id,
                    'group_id' => $group->id,
                ]);
            }
    
            Join_Request::where('group_id', $group->id)->delete();
        }
    
        if ($request->hasFile('group_image')) {
            $imageName = time() . '_' . $request->file('group_image')->getClientOriginalName();
            $imagePath = $request->file('group_image')->move(public_path('group_images'), $imageName);
    
            if ($group->group_image) {
                $group->groupImage->update(['url' => 'group_images/' . $imageName]);
            } else {
                $groupImage = Image::create([
                    'url' => 'group_images/' . $imageName,
                    'type' => 'group_profile',
                ]);
                $group->group_image = $groupImage->id;
            }
        }
        if ($request->hasFile('group_banner')) {
            $bannerName = time() . '_' . $request->file('group_banner')->getClientOriginalName();
            $bannerPath = $request->file('group_banner')->move(public_path('group_banners'), $bannerName);
    
            if ($group->group_banner) {
                $group->groupBanner->update(['url' => 'group_banners/' . $bannerName]);
            } else {
                $groupBanner = Image::create([
                    'url' => 'group_banners/' . $bannerName,
                    'type' => 'group_banner',
                ]);
                $group->group_banner = $groupBanner->id;
            }
        }
    
        $group->save();
    
        return redirect()->route('group.show', $group)->with('success', 'Group updated successfully!');
    }
        public function destroy(Group $group)
    {
        foreach ($group->post as $post)
            $post->delete();
        $group->delete();
        return redirect()->route('groups.my-groups')->with('success', 'Group deleted successfully!');
    }

    public function sendJoinRequest($groupId)
    {
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
    public function cancelJoinRequest($groupId)
    {
        $group = Group::findOrFail($groupId);
        $joinRequest = Join_Request::where('group_id', $groupId)
            ->where('user_id', auth()->id());
        if ($joinRequest) {
            $joinRequest->delete();

            return redirect()->route('group.show', $groupId)->with('success', 'Join request has been canceled.');
        } else {
            return redirect()->route('group.show', $groupId)->with('error', 'No join request found to cancel.');
        }
    }
}
