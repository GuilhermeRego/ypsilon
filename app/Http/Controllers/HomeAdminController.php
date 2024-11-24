<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeAdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin())
        return view('admin.home');
        else abort(403);
    }
}
