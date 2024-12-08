<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /*
    * Display a listing of the resource.
    */
    public function index()
    {
        //
    }

    /*
    * Show the form for creating a new resource.
    */
    public function create()
    {
        //
    }

    /*
    * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        // Problemas aqui
        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    /*
    * Display the specified resource.
    */
    public function show(Post $post)
    {
        //
    }

    /*
    * Show the form for editing the specified resource.
    */
    public function edit(Post $post)
    {
        //
    }
}