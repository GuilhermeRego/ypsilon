<div class="container p-4">
    <div class="createpost mb-4">
        <div class="comment">
            <div class="comment-body">
                <form action="{{ route('comment.store') }}" method="POST" id="comment-form">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <input type="hidden" name="date_time" value="{{ now() }}">
                <div class="form-group mb-3">
                    <div id="editor-container" style="height: 100px;"></div>
                    <input type="hidden" id="content" name="content">
                    @error('content')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                @if(isset($group))
                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                @endif
                <button type="submit" class="btn btn-primary">Comment</button>
                </form>
            </div>
        </div>
    </div>
</div>

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
        var form = document.getElementById('comment-form');
        form.onsubmit = function() {
            var content = document.querySelector('input[name=content]');
            content.value = quill.root.innerHTML;
        };
    });
</script>
@endsection