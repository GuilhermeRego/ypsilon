<!-- resources/views/post/show.blade.php -->
@extends('layouts.app')

@section('content')
<!-- Post -->
<div class="post mb-3 p-3 bg-white rounded shadow-sm d-flex">
    <div class="post-body flex-grow-1">
        <div class="post-author d-flex flex-row align-items-center mb-2">
            @if ($post->user_id == null)
                <h5 class="post-username">Anonymous</h5>
            @else
                <a href="{{ route('profile.show', ['username' => $post->user->username]) }}" class="btn btn-outline-primary btn-sm mb-0" style="font-size: 1.5em"> {{ $post->user->nickname }}</a>
                <p class="m-0 pl-1">&#64{{ $post->user->username}}</p>
            @endif
        </div>
        <div>{!! $post->content !!}</div>
        <p class="post-date"><small class="text-muted">{{ $post->date_time }}</small></p>
        @auth
            @if (auth()->check() && (auth()->user()->id == $post->user_id || auth()->user()->isAdmin()))
                <div class="post-edit mt-3">
                    <a href="{{ route('post.edit', ['post' => $post->id]) }}" class="btn btn-outline-primary btn-sm mb-0"><i class="bi bi-pencil-square"></i> Edit</a>
                </div>
                <div class="post-delete mt-2">
                    <form action="{{ route('post.destroy', ['post' => $post->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
    <div class="post-stats d-flex flex-column align-items-end ml-3">
        @guest
            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm mb-2"><i class="bi bi-hand-thumbs-up"></i> {{ $post->likesCount() }}</a>
            <a href="{{ route('login') }}" class="btn btn-outline-danger btn-sm"><i class="bi bi-hand-thumbs-down"></i> {{ $post->dislikesCount() }}</a>
        @endguest
        @auth
            <form action="{{ route('reaction.store') }}" method="POST" class="d-inline reaction-form mb-2">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <input type="hidden" name="is_like" value="true">
                <button type="submit" class="btn btn-outline-primary btn-sm mb-0"><i class="bi bi-hand-thumbs-up"></i> {{ $post->likesCount() }}</button>
            </form>
            <form action="{{ route('reaction.store') }}" method="POST" class="d-inline reaction-form mb-2">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <input type="hidden" name="is_like" value="false">
                <button type="submit" class="btn btn-outline-danger btn-sm mb-0"><i class="bi bi-hand-thumbs-down"></i> {{ $post->dislikesCount() }}</button>
            </form>
        @endauth
        <span class="mb-2"><i class="bi bi-arrow-repeat"></i> {{ $post->repostsCount() }}</span>
        <span class="mb-2"><i class="bi bi-chat"></i> {{ $post->commentsCount() }}</span>
    </div>
</div>

<!-- Create Comment -->
 @auth
    <div class="create-comment mt-3 p-3 bg-white rounded shadow-sm">
        <form action="{{ route('comment.store') }}" method="POST">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="date_time" value="{{ now() }}">
            <div class="form-group mb-3">
                <textarea class="form-control" id="content" name="content" rows="3" required placeholder="Write a comment..."></textarea>
            <button type="submit" class="btn btn-primary">Comment</button>
        </form>
    </div>
@endauth
<!-- Comments -->
<div class="comments mt-3">
    @forelse ($post->comments as $comment)
        <div class="comment mt-3 p-3 bg-white rounded shadow-sm">
            <div class="comment-body">
                <div class="comment-author d-flex flex-row align-items-center mb-2">
                    @if ($comment->user_id == null)
                        <h5 class="comment-username">Anonymous</h5>
                    @else
                        <a href="{{ route('profile.show', ['username' => $comment->user->username]) }}" class="btn btn-outline-primary btn-sm mb-0" style="font-size: 1.5em">{{ $comment->user->nickname }}</a>
                        <p class="m-0 pl-1">&#64{{ $comment->user->username }}</p>
                    @endif
                </div>
                <p class="comment-content">{{ $comment->content }}</p>
                <p class="comment-date"><small class="text-muted">{{ $comment->date_time }}</small></p>
                @auth
                    @if (auth()->check() && (auth()->user()->id == $comment->user_id || auth()->user()->isAdmin()))
                        <div class="comment-actions mt-3">
                            <a href="{{ route('comment.edit', ['comment' => $comment->id]) }}" class="btn btn-outline-primary btn-sm mb-0"><i class="bi bi-pencil-square"></i> Edit</a>
                            <form action="{{ route('comment.destroy', ['comment' => $comment->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    @empty
        <p>No comments yet.</p>
    @endforelse
</div>
@endsection