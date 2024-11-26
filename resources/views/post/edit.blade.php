<!-- FILE: resources/views/post/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container p-4">
    <h2>Edit Post</h2>
    <form action="{{ route('post.update', ['post' => $post->id]) }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="3" required>{{ $post->content }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Post</button>
    </form>
</div>
@endsection