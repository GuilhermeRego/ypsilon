<!-- FILE: resources/views/post/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container p-4" style="overflow-y: scroll">
    <form action="{{ route('post.update', ['post' => $post->id]) }}" method="POST" id="post-form">
        @csrf
        @method('PUT') <!-- Adicionado para usar o método PUT -->
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
                            if(value){
                                this.quill.insertEmbed(range.index, 'image', value, Quill.sources.USER);
                            }
                        }
                    }
                }
            }
        });

        // Preencher o editor Quill com o conteúdo do post
        quill.root.innerHTML = `{!! $post->content !!}`;

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