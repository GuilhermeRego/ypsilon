@extends('layouts.sidebar')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Welcome to the Home Page</h1>
    <p>This is the home page of your application.</p>

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
            @guest
                <div class="post post mb-3">
                    <div class="post-body">
                        <h5 class="post-author">{{ $post->user->nickname }}</h5>
                        <p class="post-content">{{ $post->content }}</p>
                        <p class="post-date"><small class="text-muted">{{ $post->date_time }}</small></p>
                    </div>
                </div>
            @else
                @if ($post->user_id != auth()->user()->id)
                    <div class="post post mb-3">
                        <div class="post-body">
                            <h5 class="post-author">{{ $post->user->nickname }}</h5>
                            <p class="post-content">{{ $post->content }}</p>
                            <p class="post-date"><small class="text-muted">{{ $post->date_time }}</small></p>
                        </div>
                    </div>
                @endif
            @endguest
        @endforeach
    </div>
</div>
@endsection
