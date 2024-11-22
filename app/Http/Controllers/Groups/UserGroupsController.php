<?php

namespace App\Http\Controllers\Groups;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;

class UserGroupsController extends Controller
{
    public function index()
    {

        $user = User::find(1);
        $groups = Group::whereIn('id', $user->groupMembers->pluck('group_id'))->get();
        return view('Groups.usergroups', [
            'groups' => $groups,
        ]); 
    }
}
