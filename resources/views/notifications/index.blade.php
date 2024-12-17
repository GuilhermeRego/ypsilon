<!-- resources/views/notifications/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Notifications</h1>
    @if($notifications->isEmpty())
        <p>No notifications found.</p>
    @else
        <ul class="list-group">
            @foreach($notifications as $notification)
                <li class="list-group-item">
                    @if($notification instanceof App\Models\Reaction_Notification)
                        <a href="{{ route('post.show', ['post' => $notification->reaction->post_id]) }}">
                            {{ $notification->reaction->user->nickname }} 
                            {{ $notification->reaction->is_like ? 'liked' : 'disliked' }} 
                            your post.
                        </a>
                    @elseif($notification instanceof App\Models\Follow_Notification)
                        <a href="{{ route('profile.show', ['username' => $notification->follow->follower->username]) }}">
                            {{ $notification->follow->follower->nickname }} started following you.
                        </a>
                    @endif
                    <small class="text-muted">{{ $notification->date_time }}</small>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection