@extends('layouts.app')

@section('content')
<div class="container" style="overflow-y: scroll;">
    <h1 class="my-4">All Posts</h1>
    <div class="row">
        @foreach ($posts as $post)
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    @if ($post->user_id == NULL)
                        <h5 class="card-title text-dark ">Anonymous</h5>
                    @else
                        <a href="{{ route('profile.show', $post->user->username) }}" class="text-decoration-none">
                            <h5 class="card-title text-primary">{{ $post->user->username }}</h5>
                        </a>
                    @endif
                    <p class="card-text"><strong>Created At:</strong> {{ $post->date_time }}</p>
                    <div class="card-text">
                        <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none text-dark">
                            <strong>Content:</strong>
                            <p>{!! $post->content !!}</p>
                        </a>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('post.destroy', $post->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection