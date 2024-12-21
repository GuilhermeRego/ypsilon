<?php

namespace App\Providers;

use App\Models\Chat_Member;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::routes();

        // Channel to send messages to users in a chat
        Broadcast::channel('private-chat.{chatId}', function ($user, $chatId) {
            return Chat_Member::where('chat_id', $chatId)
                ->where('user_id', $user->id)
                ->exists();
        });

        require base_path('routes/channels.php');
    }
}