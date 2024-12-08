@extends('layouts.app')

@section('content')

<body>
    <div class="profile-page">
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
                    @elseif (!$isMember && !$group->is_private)
                        <form action="{{ route('group.join', $group->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Join Group</button>
                        </form>
                    @elseif (!$isMember && $group->is_private && !$has_join_request)
                        <form action="{{ route('group.join-request', $group->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Join Request</button>
                        </form>
                    @elseif ($has_join_request)
                        <button type="button" class="btn btn-primary" disabled>
                            You have already requested to join
                        </button>

                    @endif
                @endauth
                @guest
                    @if(!$group->is_private)
                        <a href="{{ route('login') }}" class="btn btn-primary">Join Group</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Join Request</a>
                    @endif
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
        @if (!$group->is_private || ($group->is_private && ($isMember || auth()->user()?->isAdmin())))
            <!-- Posts Section -->
            <div class="posts">
                <!-- Post 1 -->
                @foreach($posts as $post)
                    @include('post.post')
                @endforeach
            </div>
        @else
            <h2>This is a private group</h2>
        @endif
    </div>
</body>
@endsection