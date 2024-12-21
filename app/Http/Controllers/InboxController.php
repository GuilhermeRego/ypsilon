<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->back()->with('failed','You must be logged in to view your inbox.');
        }
        $chats = auth()->user()->chats()->with('chat_member.user')->get();
        $usersArray = [];
        foreach ($chats as $chat) {
            foreach ($chat->chat_member as $member) {
                if ($member->user && $member->user->id != auth()->user()->id) {
                    $usersArray[$chat->id] = $member;
                    break;
                }
            }
        }
        
        return view('chat.inbox',['chats' => $chats,'usersArray' => $usersArray]);
    }
}
