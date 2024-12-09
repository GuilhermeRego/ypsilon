@extends('layouts.app')

@section('content')
<div class="container p-4" style="overflow-y: scroll">
    <h2>Edit Comment</h2>
    <form action="{{ route('comment.update', ['comment' => $comment->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="3" required>{{ $comment->content }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Comment</button>
    </form>
</div>
@endsection