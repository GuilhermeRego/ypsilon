@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="container-fluid">
        <input type="text" id="userSearch" placeholder="Search users..." class="form-control">
        <ul id="userResults" class="list-group mt-2"></ul>
    </div>
    <script src="{{ asset('js/search.js') }}"></script>  
    <h1 class="mb-4">Welcome to the Trending Page</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
            @guest
                @include('post.post')
            @else
                @if ($post->user_id != auth()->user()->id)
                    @include('post.post')
                @endif
            @endguest
        @endforeach
    </div>
</div>
@endsection