<?php

namespace App\Http\Controllers\Groups;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group; 
use App\Models\User; 


class HomeGroupsController extends Controller
{
    /**
     * Display the home groups page.
     */
    public function index()
    {
        if (auth()->check()) {
            $user = User::find(1);
    
            $groups = Group::whereNotIn('id', $user->groupMembers->pluck('group_id'))->get();
        } else {
            $groups = Group::all();
        }
        return view('Groups.discover', [
            'groups' => $groups,
        ]);
    }

    
}
