<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group; 

class HomeGroupsController extends Controller
{
    /**
     * Display the home groups page.
     */
    public function index()
    {
        // Fetch groups
        $groups = Group::all(); // Use all() to get all groups
        return view('Groups.homegroups', [
            'groups' => $groups,
        ]);
    }
}
