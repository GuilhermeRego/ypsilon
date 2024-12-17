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
                    <a href="{{ route('post.show', ['post' => $notification->reaction->post_id]) }}">
                        {{ $notification->reaction->user->nickname }} 
                        {{ $notification->reaction->is_like ? 'liked' : 'disliked' }} 
                        your post.
                    </a>
                    <small class="text-muted">{{ $notification->date_time }}</small>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection