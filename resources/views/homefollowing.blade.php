@extends('layouts.app')

@section('content')
@include('layouts.upperbarmenu')
<div class="container p-4" style="overflow-y: scroll">
    <h1 class="mb-4">Welcome to the Following Page</h1>

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