@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container p-4">
    <div class="profile-header container d-flex flex-column">
        <div class="image-container w-100 p-4 d-flex align-items-end" style="height: 250px; background-image: url({{ url('images/' . ($user->bannerImage ? $user->bannerImage->url : 'banner-default.png')) }})">
            <img src="{{ url('images/' . ($user->profileImage ? $user->profileImage->url : 'profile-default.png')) }}"
                class="img-thumbnail rounded-circle mb-3" alt="Profile Image" style="width: 150px; height: 150px;">
        </div>
        <div class="identification p-2">
            <h2>{{ $user->username }}</h2>
            <h4>{{ $user->nickname }}</h4>
            <p>{{ $user->bio }}</p>
        </div>
        <div class="interactions d-flex gap-2 pb-3 border-bottom">
        @auth
            @if (auth()->user()->id == $user->id || auth()->user()->isAdmin())
                <a href="{{ route('profile.edit', ['username' => $user->username]) }}" class="button btn-primary m-0">Edit
                    Profile</a>
                <form action="{{ route('profile.destroy', ['username' => $user->username]) }}" method="POST" class="mb-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button btn-danger m-0">Delete Profile</button>
                </form>
            @endif
            @if (auth()->user()->id != $user->id)
                <button id="followButton" data-user-id="{{ $user->id }}"
                    class="button {{ $isFollowedByAuth ? 'btn-secondary' : 'btn-primary' }}">{{ $isFollowedByAuth ? 'Unfollow' : 'Follow' }}</button>
                <script src="{{ asset('js/follow.js') }}"></script>
            @endif
        @endauth
        </div>
    </div>
    <div class="post-container pt-3">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h2>Posts</h2>
        @foreach($user->posts()->orderBy('date_time', 'desc')->get() as $post)
            @include('post.post')
        @endforeach
    </div>
</div>
@endsection