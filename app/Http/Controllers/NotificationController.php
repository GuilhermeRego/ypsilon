<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reaction_Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = Reaction_Notification::where('notified_id', $user->id)->get();

        return view('notifications.index', compact('notifications'));
    }
}