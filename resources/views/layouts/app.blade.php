<!-- FILE: resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Other head elements -->
        <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/minty/bootstrap.min.css" rel="stylesheet">
        <link href="{{ asset('css/post.css') }}" rel="stylesheet">
        <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
        <link href="{{ asset('css/group.css') }}" rel="stylesheet">
        <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    </head>
    <body>
        <main>
            <div class="page">
                <div class="sidebar-container">
                    @include('layouts.sidebar')
                </div>
                <div class="content d-flex flex-column">
                    @yield('content')
                </div>
            </div>
        </main>
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        @yield('scripts')
    </body>
</html>
