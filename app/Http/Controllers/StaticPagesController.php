<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    public function services(){
        return view("static_pages.services");
    }
    public function faq(){
        return view("static_pages.faq");
    }
    public function aboutUs(){
        return view("static_pages.about-us");
    }
    public function contacts(){
        return view("static_pages.contacts");
    }
}
