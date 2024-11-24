@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Banner Image -->
        <div class="col-12 mb-4">
            <img src="{{ asset('storage/' . ($user->bannerImage ? $user->bannerImage->url : 'https://via.placeholder.com/50')) }}" class="img-fluid rounded" alt="Banner Image">
        </div>
        <!-- Profile Image and Info -->
        <div class="col-md-4 text-center">
            <img src="{{ asset('storage/' . ($user->profileImage ? $user->profileImage->url : 'https://via.placeholder.com/50')) }}" class="img-fluid rounded-circle mb-3" alt="Profile Image" style="width: 150px; height: 150px;">
            <h2>{{ $user->username }}</h2>
            <h4>{{ $user->nickname }}</h4>
            <p>{{ $user->bio }}</p>
            @auth
                @if (auth()->user()->id == $user->id || auth()->user()->admin())
                    <a href="{{ route('profile.edit', ['username' => $user->username]) }}" class="btn btn-primary">Edit Profile</a>
                    <a href="{{ route('profile.delete', ['username' => $user->username]) }}" class="btn btn-danger">Delete Profile</a>
                @endif
            @endauth
        </div>
        <!-- User Posts -->
        <div class="col-md-8">
            <h3>Posts</h3>
            @foreach($user->posts()->orderBy('date_time', 'desc')->get() as $post)
                @include('post.post')
            @endforeach
        </div>
    </div>
</div>
@endsection