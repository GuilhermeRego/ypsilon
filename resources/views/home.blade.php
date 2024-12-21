@extends('layouts.app')

@section('content')
@include('layouts.upperbarmenu')
<div class="container p-4" style="overflow-y: scroll">
    <div class="container-fluid">
        <form action="{{ route('results') }}" method="GET" id="searchForm">
            <input type="text" id="userSearch" name="query" placeholder="Search users..." class="form-control">
        </form>
        <ul id="userResults" class="list-group mt-2"></ul>
    </div>
    <script src="{{ asset('js/search.js') }}"></script>  
    <h1 class="mb-4">Welcome to the Trending Page</h1>

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