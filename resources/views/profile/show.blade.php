@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container p-4" style="overflow-y: scroll">
    <div class="profile-header container d-flex flex-column">
        <div class="image-container w-100 p-4 d-flex align-items-end" 
            style="height: 250px; background-image: url('{{ $user->bannerImage ? asset('storage/' . $user->bannerImage->url) : asset('images/banner-default.png') }}');">
            <img src="{{ $user->profileImage ? asset('storage/' . $user->profileImage->url) : asset('images/profile-default.png') }}"
                class="img-thumbnail rounded-circle mb-3" 
                alt="Profile Image" 
                style="width: 150px; height: 150px;">
        </div>
        <div class="identification p-2">
            <h2><strong>{{ $user->nickname }}</strong></h4>
            <h4>{{ $user->username }}</h2>
            <p class="bio m-0">{{ $user->bio }}</p>
        </div>
        <div class="profile-stats p-2">
            <p class="m-0"><strong>{{ $user->posts()->count() }}</strong>
                @if($user->posts()->count() == 1)
                    Post
                @else
                    Posts
                @endif
            </p>
            <p class="m-0"><strong>{{ $user->followers()->count() }}</strong>
                @if($user->followers()->count() == 1)
                    Follower
                @else
                    Followers
                @endif
            </p>
            <p class="m-0"><strong>{{ $user->following()->count() }}</strong>
                    Following
            </p>
        </div>
        <div class="interactions d-flex gap-2 pb-3 border-bottom">
        @auth
            @if (auth()->user()->id == $user->id || auth()->user()->isAdmin())
                <a href="{{ route('profile.edit', ['username' => $user->username]) }}" class="button btn-primary m-0">Edit
                    Profile</a>
                <a href="{{ route('profile.manageFollowers', ['username' => $user->username]) }}" class="button btn-primary m-0">Manage Followers</a>
                <form action="{{ route('profile.destroy', ['username' => $user->username]) }}" method="POST" class="mb-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button btn-danger m-0">Delete Profile</button>
                </form>
            @endif
            @if (auth()->user()->id != $user->id)
                @if ($isFollowedByAuth)
                    <form action="{{ route('profile.follow', ['username'=> $user->username]) }}" method="POST" class="mb-0">
                        @csrf
                        <button type="submit" class="button m-0 btn-danger">Unfollow</button>
                    </form>
                @else
                    @if (!$user->is_private)
                    <form action="{{ route('profile.follow', ['username'=> $user->username]) }}" method="POST" class="mb-0">
                        @csrf
                        <button type="submit" class="button m-0 btn-primary">Follow</button>
                    </form>
                    @else
                        @if (!$hasFollowRequest)
                        <form action="{{ route('profile.followRequest', ['username'=> $user->username]) }}" method="POST" class="mb-0">
                            @csrf
                            <button type="submit" class="button m-0 btn-primary">Send Follow Request</button>
                        </form>
                        @else
                        <form action="{{ route('profile.followRequest', ['username'=> $user->username]) }}" method="POST" class="mb-0">
                            @csrf
                            <button type="submit" class="button m-0 btn-danger">Cancel Follow Request</button>
                        </form>
                        @endif 
                    @endif
                @endif
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
        @if($user->posts()->count() == 0)
            <div class="alert alert-info">
                No posts yet.
            </div>
        @elseif($user->is_private && !$isFollowedByAuth && !$user->isAdmin())
            <div class="alert alert-info">
                This account is private, follow this user to see their posts.
            </div>
        @else
            @foreach($user->posts()->whereNull('group_id')->orderBy('date_time', 'desc')->get() as $post)
                @can('view', $post)
                    @include('post.post')
                @endcan
            @endforeach
        @endif
    </div>
</div>
@endsection