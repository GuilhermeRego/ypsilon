<!-- resources/views/post/show.blade.php -->
@extends('layouts.app')

@section('content')
@can('view', $post)
    <!-- Post -->
    @include('post.post')


    <!-- Create Comment -->
    <div class="comments p-4" style="overflow-y: scroll">
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
            <div class="col-md-10 d-flex flex-column justify-content-between pb-3 mb-3 border border-1 rounded">
                <div class="post-body">
                    <!-- If the user id is null, it is anonymous, otherwise, display the username -->
                    <div class="post-author d-flex flex-row align-items-center mb-3">
                        @if ($comment->user_id == null)
                            <h5 class="post-username">Anonymous</h5>
                        @else
                            <img src="{{ $comment->user->profileImage ? asset($comment->user->profileImage->url) : asset('images/profile-default.png') }}"
                            class="border border-2 rounded-circle mr-2" alt="Profile Image"
                            style="width: 40px; height: 40px;">
                            <a href="{{ route('profile.show', ['username' => $comment->user->username]) }}" style="font-size: 1.5em; text-decoration: none" >
                                {{ $comment->user->nickname }}</a>
                            <p class="m-0 pl-1 fw-light" style="color: #a4a4a4">&#64{{ $comment->user->username}}</p>
                        @endif
                    </div>
                    <div>{!! $comment->content !!}</div>
                    <p class="post-date"><small class="text-muted">{{ $comment->date_time }}</small></p>
                    </a>
                </div>
                <div class="post-footer d-flex gap-2">
                @auth
                    @if (auth()->check() && auth()->user()->id == $comment->user_id || auth()->user()->isAdmin())
                        <div class="post-edit">
                            <a href="{{ route('comment.edit', ['comment' => $comment->id]) }}" class="btn btn-outline-primary btn-sm mb-0"><i
                                    class="bi bi-pencil-square"></i> Edit</a>
                        </div>
                        <div class="post-delete">
                            <form action="{{ route('comment.destroy', ['comment' => $comment->id]) }}" method="POST" class="mb-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" style="height: fit-content"><i class="bi bi-trash"></i> Delete</button>
                            </form>
                        </div>
                    @endif
                    @if (auth()->user()->id != $comment->user_id)
                        <div class="post-report">
                            <a href="{{ route('comment.post', ['comment' => $comment->id]) }}" class="btn btn-outline-danger btn-sm"><i
                                    class="bi bi-flag"></i> Report
                            </a>
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