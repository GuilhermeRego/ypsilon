@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Notifications</h1>
    <form action="{{ route('notifications.markAsRead') }}" method="POST" class="mb-3">
        @csrf
        <button type="submit" class="btn btn-primary">Mark All as Read</button>
    </form>
    @if($notifications->isEmpty())
        <p>No notifications found.</p>
    @else
        <ul class="list-group">
            @foreach($notifications as $notification)
                <li class="list-group-item {{ $notification->is_read ? 'bg-light' : 'bg-white' }}">
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
                    @elseif($notification instanceof App\Models\Comment_Notification)
                        <a href="{{ route('post.show', ['post' => $notification->comment->post_id]) }}">
                            {{ $notification->comment->user->nickname }} commented on your post.
                        </a>
                    @endif
                    <small class="text-muted">{{ \Carbon\Carbon::parse($notification->date_time)->format('Y-m-d H:i') }}</small>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection