<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Other head elements -->
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/minty/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/post.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>