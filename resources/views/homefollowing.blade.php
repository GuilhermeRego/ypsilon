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
        @include('post.create')
    @endauth

    <div class="posts">
        @foreach($posts as $post)
            @if ($post->group_id === null)
                @include('post.post')
            @endif
        @endforeach
    </div>
</div>
@endsection