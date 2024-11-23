@extends('layouts.app')

@section('content')

<body>
    <div class="profile-page">
        <!-- Profile Banner -->
        <div class="profile-banner">
            <div class="profile-info">
                <img src="{{ asset('storage/' . ($group->groupImage ? $group->groupImage->url : 'https://via.placeholder.com/50')) }}"
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
                @if ($isOwner)
                    <button class="btn">Edit Group</button>
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
            </div>
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

        <!-- Posts Section -->
        <div class="posts">
            <!-- Post 1 -->
            @foreach($posts as $post)
                <div class="post post mb-3">
                    <div class="post-body">
                        <h5 class="post-author">{{ $post->user->nickname }}</h5>
                        <p class="post-content">{{ $post->content }}</p>
                        <p class="post-date"><small class="text-muted">{{ $post->date_time }}</small></p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
@endsection