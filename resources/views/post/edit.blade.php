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
                            var input = document.createElement('input');
                            input.setAttribute('type', 'file');
                            input.setAttribute('accept', 'image/*');
                            input.click();

                            input.onchange = function() {
                                var file = input.files[0];
                                if (/^image\//.test(file.type)) {
                                    var formData = new FormData();
                                    formData.append('image', file);

                                    fetch('{{ route('image.upload') }}', {
                                        method: 'POST',
                                        body: formData,
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(result => {
                                        var range = quill.getSelection();
                                        quill.insertEmbed(range.index, 'image', result.url);
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                    });
                                } else {
                                    console.warn('You could only upload images.');
                                }
                            };
                        }
                    }
                }
            }
        });

        quill.root.innerHTML = '{!! $post->content !!}';

        var form = document.getElementById('post-form');
        form.onsubmit = function() {
            var content = document.querySelector('input[name=content]');
            content.value = quill.root.innerHTML;
        };
    });
</script>
@endsection