@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Following</h1>

    @if(session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
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
                <div class="post-body">
                    <h5 class="post-author">{{ $post->user->nickname }}</h5>
                    <p class="post-content">{{ $post->content }}</p>
                    <p class="post-date"><small class="text-muted">{{ $post->date_time }}</small></p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection