@extends('layouts.app')

@section('content')
<div class="container p-4" style="overflow-y: scroll">
    <h1>Saved Posts</h1>
    @if ($posts->count()==0)
        <p>No saved posts found.</p>
    @else
        @foreach($posts as $post)
            @include('post.post')
        @endforeach
    @endif
</div>
@endsection