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
                    <input type="file" id="imageInput" style="display:none;">
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
                            // Trigger hidden file input
                            document.querySelector('#imageInput').click();
                        }
                    }
                }
            }
        });
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
        document.querySelector('#comment-form').addEventListener('submit', function() {
            var content = document.querySelector('#editor-container .ql-editor').innerHTML;
            document.querySelector('#content').value = content;
        });
    });
</script>
@endsection