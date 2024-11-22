<?php

namespace App\Http\Controllers\Groups;
use App\Http\Controllers\Controller;
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
        $groups = Group::all(); 
        return view('Groups.discover', [
            'groups' => $groups,
        ]);
    }

    
}
