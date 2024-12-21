<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reaction_Notification;
use App\Models\Follow_Notification;
use App\Models\Comment_Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $reactionNotifications = Reaction_Notification::where('notified_id', $user->id)->get();
        $followNotifications = Follow_Notification::where('notified_id', $user->id)->get();
        $commentNotifications = Comment_Notification::where('notified_id', $user->id)->get();

        $notifications = $reactionNotifications->merge($followNotifications)->merge($commentNotifications)->sortByDesc('date_time');
        $unreadCount = $notifications->where('is_read', false)->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }
}