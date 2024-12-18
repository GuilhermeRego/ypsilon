<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function show(Chat $chat)
    {
        // Ensure the logged-in user is part of the chat
        $user = auth()->user();
        $isMember = $chat->chat_member()->where('user_id', $user->id)->exists();

        if (!$isMember) {
            return redirect()->route('inbox.index')->with('error', 'You are not a member of this chat.');
        }

        $chats = auth()->user()->chats()->with('chat_member.user')->get();
        $usersArray = [];
        foreach ($chats as $chatItem) {
            foreach ($chatItem->chat_member as $member) {
                if ($member->user && $member->user->id != auth()->user()->id) {
                    $usersArray[$chatItem->id] = $member;
                    break;
                }
            }
        }

        // Fetch messages and other chat members
        $messages = $chat->message()->with('sender')->orderBy('date_time', 'asc')->get();
        $chatMembers = $chat->chat_member()->with('user')->get();

        // Pass the data to the view
        return view('chat.show', [
            'chat' => $chat,
            'messages' => $messages,
            'chatMembers' => $chatMembers,
            'usersArray' => $usersArray,
            'chats' => $chats
        ]);
    }
}

