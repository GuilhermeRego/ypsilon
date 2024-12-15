<!-- FILE: resources/views/post/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container p-4" style="overflow-y: scroll">
    <form action="{{ route('post.update', ['post' => $post->id]) }}" method="POST" id="post-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <input type="hidden" name="date_time" value="{{ now() }}">
        <div class="form-group mb-3">
            <div id="editor-container" style="height: 200px;"></div>
            <input type="hidden" id="content" name="content">
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Post</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: {
                    container: [
                        [{ 'header': [1, 2, false] }],
                        ['bold', 'italic', 'underline'],
                        ['image', 'code-block']
                    ],
                    handlers: {
                        'image': function() {
                            var range = this.quill.getSelection();
                            var value = prompt('What is the image URL');
                            if (value) {
                                // Ensure the URL is valid
                                if (isValidUrl(value)) {
                                    this.quill.insertEmbed(range.index, 'image', value, Quill.sources.USER);
                                } else {
                                    alert('Invalid URL');
                                }
                            }
                        }
                    }
                }
            }
        });

        quill.root.innerHTML = '{!! $post->content !!}';

        // Function to validate URL
        function isValidUrl(string) {
            try {
                new URL(string);
                return true;
            } catch (_) {
                return false;  
            }
        }

        // Update the hidden input with the content of the editor
        var form = document.getElementById('post-form');
        form.onsubmit = function() {
            var content = document.querySelector('input[name=content]');
            content.value = quill.root.innerHTML;
        };
    });
</script>
@endsection