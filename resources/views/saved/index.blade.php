@extends('layouts.app')

@section('content')
<div class="container p-4" style="overflow-y: scroll"></div>
    <h1>Saved Posts</h1>
    @if ($posts->isEmpty())
        No saved posts
    @else
        @foreach($posts as $post)
            @include('post.post')
        @endforeach
    @endif
</div>
@endsection