@extends('layouts.app')

@section('content')


<div class="container p-4">
    <div class="profile-header container d-flex flex-column">
        <div class="image-container w-100 p-4 d-flex align-items-end" 
            style="height: 250px; background-image: url('{{ $group->bannerImage ? asset('storage/' . $group->groupBanner->url) : asset('images/banner-default.png') }}');">
        <img src="{{ $group->groupImage ? asset('storage/' . $group->groupImage->url) : asset('images/group-default.png') }}"
            class="img-thumbnail rounded-circle mb-3" 
            alt="Group Image"
            style="width: 150px; height: 150px;">
        </div>
        <div class="identification p-2">
            <h2>{{ $group->name }}</h2>
            <p class="bio m-0">{{ $group->description }}</p>
        </div>
        <div class="profile-stats p-2">
            <p class="m-0"><strong>{{ $group->memberCount() }}</strong>
                @if($group->memberCount() == 1)
                    Member
                @else
                    Members
                @endif
            </div>
        </p>
        <div class="interactions d-flex gap-2 pb-3 border-bottom">
            @auth
                @if ($isOwner || auth()->user()->isAdmin())
                    <a href="{{ route('group.edit', $group->id) }}" class="button btn-primary m-0">Edit Group</a>
                    <a href="{{ route('group-management-members.index', $group->id) }}" class="button btn-primary m-0">Manage
                        Group</a>
                    <form action="{{ route('group.destroy', $group->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button btn-danger m-0">Delete Group</button>
                    </form>
                @endif
                @if ($isMember)
                    <form action="{{ route('group.leave', $group->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button btn-danger m-0">Leave Group</button>
                    </form>
                @elseif (!$isMember && !$group->is_private)
                    <form action="{{ route('group.join', $group->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="button btn-primary m-0">Join Group</button>
                    </form>
                @elseif (!$isMember && $group->is_private && !$has_join_request)
                    <form action="{{ route('group.join-request', $group->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="button btn-primary m-0">Join Request</button>
                    </form>
                @elseif ($has_join_request)
                    <form action="{{ route('group.cancel-request', $group->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button btn-danger m-0">Cancel Join Request</button>
                    </form>
    
                @endif
            @endauth
        </div>
    </div>
@if (!$group->is_private || ($group->is_private && ($isMember || auth()->user()?->isAdmin())))
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
        @if ($isMember)
        <div class="createpost mb-4">
            <div class="post">
                <div class="post-body">
                    <form action="{{ route('post.store.group', $group->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="date_time" value="{{ now() }}">
                        <div class="form-group mb-3">
                            <textarea class="form-control" id="content" name="content" rows="3" required
                                placeholder="Write something..."></textarea>
                        </div>
                        <input type="hidden" name="group_id" value="{{ $group->id}}">
                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                </div>
            </div>
        </div>
@endif
    @if($posts->count() == 0)
        <div class="alert alert-info">
            No posts yet.
        </div>
    @else
        @foreach($posts as $post)
            @include('post.post')
        @endforeach
    @endif
    </div>
@else
    <h2>This is a private group</h2>
@endif
</div>
@endsection
