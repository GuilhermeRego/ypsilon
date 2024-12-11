<?php

namespace App\Http\Controllers\Groups;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use App\Models\Group_Member;
use App\Models\Group_Owner;

use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function manageMembers($group)
    {
        $group = Group::findOrFail($group);
        if (auth()->user()->isAdmin() || $this->authorize('isOwner', $group)) {
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
        if (auth()->user()->isAdmin() || $this->authorize('isOwner', $group)) {
            return view("Groups.managerequests", ['group'=>$group]);
        } else {
            abort(403, 'Unauthorized');
        }
    }

    public function addMember(Request $request, $groupId)
    {
        $group = Group::findOrFail($groupId);

        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return redirect()->route('group-management.index', $groupId)->with('error', 'The username does not exist.');
        }
        if ($group->group_member()->where('user_id', $user->id)->exists()) {
            return redirect()->route('group-management.index', $groupId)->with('error', 'This user is already a member of the group.');
        }
        Group_Member::create([
            'group_id' => $group->id,
            'user_id' => $user->id,
        ]);
        return redirect()->route('group-management.index', $groupId)->with('success', 'User added to the group successfully.');
    }
    public function makeOwner($groupId, $userId){
        $group = Group::findOrFail($groupId);
        $memberId = $group->group_member()
            ->where('user_id', $userId)
            ->value('id');
        Group_Owner::create([
            'member_id' => $memberId,
        ]);
        return redirect()->route('group-management.index', $groupId)->with('success', 'User has been successfully made the owner of the group.');   
    }

    public function removeMember($groupId, $userId){
        $group = Group::findOrFail($groupId);
        
        $group_member = $group->group_member()
            ->where('user_id', $userId);
        $group_member->delete();
        return redirect()->route('group-management.index', $groupId)->with('success', 'Group has been successfully deleted.');
    }
}