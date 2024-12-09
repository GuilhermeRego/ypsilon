@extends('layouts.app')

@section('content')
<!-- Group Banner -->
<div class="profile-banner">
    <div class="profile-info">
        <img src="{{ $group->groupImage ? asset('storage/' . $group->groupImage->url) : asset('images/group-default.png') }}"
            class="rounded-circle me-3" alt="Group Image">
        <div class="profile-details">
            <h2>{{ $group->name }}</h2>
            <p>
                {{ $group->description }}
            </p>
        </div>
    </div>
    <div class="profile-stats">
        <div class="stat"><strong>{{ $group->memberCount() }}</strong>
            @if($group->memberCount() == 1)
                Member
            @else
                Members
            @endif
        </div>
    </div>
    <div class="profile-actions">
        @auth
            @if ($isOwner || auth()->user()->isAdmin())
                <a href="{{ route('group.edit', $group->id) }}" class="btn btn-warning">Edit Group</a>
                <a href="{{ route('group-management.index', $group->id) }}" class="btn btn-warning">Manage Group</a>
                <form action="{{ route('group.destroy', $group->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Group</button>
                </form>
            @endif
            @if ($isMember)
                <form action="{{ route('group.leave', $group->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Leave Group</button>
                </form>
            @else
                <form action="{{ route('group.join', $group->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Join Group</button>
                </form>
            @endif
        @endauth
        @guest
            <a href="{{ route('login') }}" class="btn btn-primary">Join Group</a>
        @endguest

    </div>
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
</div>

<div class="container p-4" style="overflow-y: auto; max-height: 80vh;">
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

    @if ($isMember)
        @include('post.create')
    @endif

    <!-- Posts Section -->
    <div class="posts">
        @foreach($posts as $post)
            @include('post.post')
        @endforeach
    </div>
</div>
@endsection