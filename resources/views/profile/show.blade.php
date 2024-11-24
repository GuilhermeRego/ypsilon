@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <h2>{{ $user->username }}</h2>
            <p>{{ $user->bio }}</p>
        </div>
        <div>
            <h3>Posts</h3>
            @foreach($user->posts()->orderBy('date_time', 'desc')->get() as $post)
                @include('post.post')
            @endforeach
        </div>
    </div>
</div>
@endsection