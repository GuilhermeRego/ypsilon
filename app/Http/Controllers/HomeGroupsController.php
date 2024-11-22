<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group; 

class HomeGroupsController extends Controller
{
    /**
     * Display the home groups page.
     */
    public function discover()
    {
        // Fetch groups
        $groups = Group::all(); 
        return view('Groups.discover', [
            'groups' => $groups,
        ]);
    }

    public function showUserGroups()
    {
        return view('Groups.usergroups'); 
    }
}
