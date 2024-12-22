<div class="container p-4">
    <div class="createpost mb-4">
        <div class="post">
            <div class="post-body">
                @if(isset($group))
                    <form action="{{ route('post.store.group', $group->id) }}" method="POST" id="post-form">
                @else
                    <form action="{{ route('post.store') }}" method="POST" id="post-form">
                @endif
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="date_time" value="{{ now() }}">
                    
                    <!-- Quill Editor -->
                    <div class="form-group mb-3">
                        <div id="editor-container" style="height: 100px;"></div>
                        <input type="hidden" id="content" name="content">
                        @error('content')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Hidden File Input -->
                    <input type="file" id="imageInput" accept="image/*" style="display: none;" />

                    @if(isset($group))
                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                    @endif
                    <button type="submit" class="btn btn-primary">Post</button>
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
                placeholder: 'Create a new post...',
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
            document.querySelector('#post-form').addEventListener('submit', function() {
                var content = document.querySelector('#editor-container .ql-editor').innerHTML;
                document.querySelector('#content').value = content;
            });
        });
</script>
@endsection