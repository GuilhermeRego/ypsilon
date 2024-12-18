<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\Reaction_Notification;
use App\Models\Follow_Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(env('FORCE_HTTPS',false)) {
            error_log('configuring https');

            $app_url = config("app.url");
            URL::forceRootUrl($app_url);
            $schema = explode(':', $app_url)[0];
            URL::forceScheme($schema);
        }

        View::composer('layouts.sidebar', function ($view) {
            $user = auth()->user();
            if ($user) {
                $reactionNotifications = Reaction_Notification::where('notified_id', $user->id)->get();
                $followNotifications = Follow_Notification::where('notified_id', $user->id)->get();
                $notifications = $reactionNotifications->merge($followNotifications);
                $unreadCount = $notifications->where('is_read', false)->count();
                $view->with('unreadCount', $unreadCount);
            }
        });
    }
}
