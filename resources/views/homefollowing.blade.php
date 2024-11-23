@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Welcome to the Following Page</h1>

    @if(session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @auth
    <div class="createpost mb-4">
        <div class="post">
            <div class="post-body">
                <form action="{{ route('post.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="date_time" value="{{ now() }}">
                    <div class="form-group mb-3">
                        <textarea class="form-control" id="content" name="content" rows="3" required placeholder="Write something..."></textarea>
                    </div>
                    <input type="hidden" name="group_id" value="1">
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
            </div>
        </div>
    </div>
    @endauth

    <div class="posts">
        @foreach($posts as $post)
            <div class="post post mb-3">
                <div class="row">
                    <div class="col-md-10">
                        <div class="post-body">
                        <a href="{{ route('profile.show', ['username' => $post->user->username]) }}" class="btn btn-outline-primary btn-sm mb-0" style="font-size: 1.5em"> {{ $post->user->nickname }}</a>
                            <p class="post-content">{{ $post->content }}</p>
                            <p class="post-date"><small class="text-muted">{{ $post->date_time }}</small></p>
                        </div>
                    </div>
                    <div class="col-md-2 post-stats">
                        <form action="{{ route('reaction.store') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <input type="hidden" name="is_like" value="true">
                            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-hand-thumbs-up"></i> {{ $post->likesCount() }}</button>
                        </form>
                        <form action="{{ route('reaction.store') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <input type="hidden" name="is_like" value="false">
                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-hand-thumbs-down"></i> {{ $post->dislikesCount() }}</button>
                        </form>
                        <span><i class="bi bi-arrow-repeat"></i> {{ $post->repostsCount() }}</span>
                        <span><i class="bi bi-chat"></i> 0</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection