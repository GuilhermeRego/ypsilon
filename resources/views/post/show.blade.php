<!-- resources/views/post/show.blade.php -->
@extends('layouts.app')

@section('content')
@can('view', $post)
    <!-- Post -->
    @include('post.post')


    <!-- Create Comment -->
    <div class="comments" style="overflow-y: scroll">
        @auth
            @if ($post->group)
                @if (auth()->user()->can('isMember', $post->group))
                    @include('comment.create')
                @endif
            @else
                @include('comment.create')
            @endif
        @endauth
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <!-- Comments -->
        <div class="comments mt-3">
            @forelse ($post->comments as $comment)
                <div class="comment mt-3 p-3 bg-white rounded shadow-sm">
                    <div class="comment-body">
                        <div class="comment-author d-flex flex-row align-items-center mb-2">
                            @if ($comment->user_id == null)
                                <h5 class="comment-username">Anonymous</h5>
                            @else
                                <a href="{{ route('profile.show', ['username' => $comment->user->username]) }}" style="font-size: 1.5em; text-decoration:none">
                                    {{ $comment->user->nickname }}</a>
                                <p class="m-0 pl-1">&#64{{ $comment->user->username }}</p>
                            @endif
                        </div>
                        <p class="comment-content">{!! $comment->content !!}</p>
                        <p class="comment-date"><small class="text-muted">{{ $comment->date_time }}</small></p>
                        @auth
                            @if (auth()->check() && (auth()->user()->id == $comment->user_id || auth()->user()->isAdmin()))
                                <div class="comment-actions mt-3">
                                    <a href="{{ route('comment.edit', ['comment' => $comment->id]) }}"
                                        class="btn btn-outline-primary btn-sm mb-0"><i class="bi bi-pencil-square"></i> Edit</a>
                                    <form action="{{ route('comment.destroy', ['comment' => $comment->id]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i>
                                            Delete</button>
                                    </form>
                                </div>
                            @endif
                            @if (auth()->user()->id != $comment->user_id)
                                <div class="comment-actions mt-3">
                                    <a href="{{ route('report.comment', ['comment' => $comment->id]) }}"
                                        class="btn btn-outline-danger btn-sm"><i class="bi bi-flag"></i> Report</a>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    No comments yet.
                </div>
            @endforelse
        </div>
    </div>
@endcan
@endsection