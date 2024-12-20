@extends('layouts.app')

@section('content')
<div class="container p-4">
    <div class="editcomment mb-4">
        <div class="comment">
            <div class="comment-body">
                <form action="{{ route('comment.update', $comment->id) }}" method="POST" id="comment-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="post_id" value="{{ $comment->post_id }}">
                    <input type="hidden" name="date_time" value="{{ now() }}">
                    <div class="form-group mb-3">
                        <div id="editor-container" style="height: 100px;">{!! $comment->content !!}</div>
                        <input type="hidden" id="content" name="content">
                        @error('content')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="file" id="imageInput" style="display:none;">
                    <button type="submit" class="btn btn-primary">Update Comment</button>
                </form>
            </div>
        </div>
    </div>
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
                            // Trigger hidden file input
                            document.querySelector('#imageInput').click();
                        }
                    }
                }
            }
        });

        // Load existing content into Quill editor
        quill.root.innerHTML = `{!! $comment->content !!}`;

        // File input event listener
        document.querySelector('#imageInput').addEventListener('change', function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var range = quill.getSelection();
                    quill.insertEmbed(range.index, 'image', e.target.result, Quill.sources.USER);
                };
                reader.readAsDataURL(file); // Convert image to Base64
            }
        });

        // Sync Quill content to hidden input before form submit
        document.querySelector('#comment-form').addEventListener('submit', function(event) {
            var content = document.querySelector('#editor-container .ql-editor').innerHTML;
            document.querySelector('#content').value = content;

            // Check if content is empty
            var trimmedContent = content.replace(/<p><br><\/p>/g, '').replace(/<[^>]*>/g, '').trim();
            if (trimmedContent === '') {
                event.preventDefault();
                alert('Comment cannot be empty!');
            }
        });
    });
</script>
@endsection