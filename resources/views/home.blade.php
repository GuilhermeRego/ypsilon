@extends('layouts.app')

@section('content')
@include('layouts.upperbarmenu')
<div class="container p-4" style="overflow-y: scroll">
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
                @if (!$post->user->is_private)
                    @include('post.post')
                @endif
            @else
                @can('view', $post)
                    @if ($post->user_id != auth()->user()->id)
                        @include('post.post')
                    @endif
                @endcan
            @endguest
        @endforeach
    </div>
</div>
@endsection