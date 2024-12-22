<?php

namespace App\Http\Controllers\Groups;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use App\Models\Group_Member;
use App\Models\Group_Owner;
use App\Models\Join_Request;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function manageMembers($group)
    {
        $group = Group::findOrFail($group);
        if ($this->authorize('isOwner', $group)) {
            $owners = [];
            $members = [];
            foreach ($group->group_member as $member) {
                if (Group_Owner::where('member_id', $member->id)->exists()) {
                    $owners[] = $member; 
                }
                else{
                    $members[] = $member;
                }
            }
            return view("Groups.managemembers", compact('group', 'owners','members'));
        } else {
            abort(403, 'Unauthorized');
        }
    }
    public function manageRequests($group)
    {
        $group = Group::findOrFail($group);
        if(!$group->is_private)abort(403, 'Not found');
        if ($this->authorize('isOwner', $group)) {
            return view("Groups.managerequests", ['group'=>$group]);
        } else {
            abort(403, 'Unauthorized');
        }
    }

    public function addMember(Request $request, $groupId)
    {
        $group = Group::findOrFail($groupId);
        if (!$this->authorize('isOwner', $group)) {
            abort(403, 'Unauthorized');
        }
        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'The username does not exist.');
        }
        if ($group->group_member()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'This user is already a member of the group.');
        }
        Group_Member::create([
            'group_id' => $group->id,
            'user_id' => $user->id,
        ]);
        return redirect()->back()->with('success', 'User added to the group successfully.');
    }
    public function makeOwner($groupId, $userId){
        $group = Group::findOrFail($groupId);
        if (!$this->authorize('isOwner', $group)) {
            abort(403, 'Unauthorized');
        }
        $memberId = $group->group_member()
            ->where('user_id', $userId)
            ->value('id');
        Group_Owner::create([
            'member_id' => $memberId,
        ]);
        return redirect()->back()->with('success', 'User has been successfully made the owner of the group.');   
    }

    public function removeMember($groupId, $userId){
        $group = Group::findOrFail($groupId);
        if (!$this->authorize('isOwner', $group)) {
            abort(403, 'Unauthorized');
        }
        $group_member = $group->group_member()
            ->where('user_id', $userId);
        $group_member->delete();
        return redirect()->back()->with('success', 'Group member has been successfully deleted.');
    }
    public function acceptRequest($requestId){
        $request = Join_Request::findOrFail($requestId);
        if (!$this->authorize('isOwner', $request->group)) {
            abort(403, 'Unauthorized');
        }
        Group_Member::create([
            'user_id' => $request->user_id,
            'group_id' => $request->group_id,
        ]);
        $request->delete();
        return redirect()->back()->with('success', 'User added to the group!');
    }
    public function declineRequest($requestId){
        $request = Join_Request::findOrFail($requestId);
        if (!$this->authorize('isOwner', $request->group)) {
            abort(403, 'Unauthorized');
        }
        $request->delete();
        return redirect()->back()->with('success', 'Request declined successfully!');
    }
}