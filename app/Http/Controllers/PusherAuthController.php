<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;

class PusherAuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true
            ]
        );

        $channel = $request->input('channel_name');
        $socket_id = $request->input('socket_id');

        $user = auth()->user();  // Assuming you're using Laravel's built-in auth

        if ($user) {
            if (strpos($channel, 'private-') === 0) {
                $auth = $pusher->socket_auth($channel, $socket_id);
            } else {
                $auth = $pusher->presence_auth($channel, $socket_id, $user->id, [
                    'user_info' => [
                        'nickname' => $user->nickname,
                    ]
                ]);
            }

            return response($auth);
        }

        return response('Unauthorized', 403);
    }   
}