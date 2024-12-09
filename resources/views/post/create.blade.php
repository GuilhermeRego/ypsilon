<div class="container p-4" style="overflow-y: scroll">
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
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'code-block']
                ]
            }
        });

        document.getElementById('post-form').onsubmit = function(event) {
            // Prevenir o envio do formulário até que o campo de entrada oculto seja preenchido
            event.preventDefault();

            // Copie o conteúdo do editor Quill para o campo de entrada oculto
            var content = quill.root.innerHTML;
            document.getElementById('content').value = content;

            // Verifique se o conteúdo está sendo copiado corretamente
            console.log('Content:', content);

            // Verifique se o campo de entrada oculto está sendo preenchido corretamente
            console.log('Hidden input value:', document.getElementById('content').value);

            // Envie o formulário após preencher o campo de entrada oculto
            if (content.trim() !== '') {
                this.submit();
            } else {
                alert('Content field is required.');
            }
        };
    });
</script>
@endsection