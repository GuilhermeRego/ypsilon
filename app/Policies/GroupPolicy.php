<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Group;
use App\Models\Group_Member;
use App\Models\Group_Owner;


class GroupPolicy
{
    public function isMember(User $user, Group $group)
    {
        return $group->group_member()
                 ->where('user_id', $user->id)
                 ->exists();
    }

    /**
     * Determine if the user is the owner of the group.
     */
    public function isOwner(User $user, Group $group)
    {
        $memberId = Group_Member::where('user_id', $user->id)
            ->where('group_id', $group->id)
            ->value('id');

        $isMember = $memberId ? true : false;
        return $isMember && Group_Owner::where('member_id', $memberId)->exists();
    }
}
