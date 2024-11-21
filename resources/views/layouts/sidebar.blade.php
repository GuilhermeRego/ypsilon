<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Ypsilon') }}</title>
        <link rel="icon" href="{{ url('images/logo.png') }}" type="image/png">

        <!-- Styles -->
        <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/sidebar.css') }}" rel="stylesheet">
        <link href="{{ url('css/post.css') }}" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/minty/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Adicionado -->

        <!-- Scripts -->
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script type="text/javascript" src="{{ url('js/app.js') }}" defer></script>
    </head>

    <body>
        <div class="d-flex flex-column" style="height: 100vh;">
            <div class="d-flex flex-grow-1">
                <!-- Sidebar -->
                <aside class="sidebar d-flex flex-column p-3" style="width: 250px; background-color: #202020;">
                    <a href="{{ url('home') }}"><img src="{{ url('images/logo.png') }}" style="width: 75px; height: 75px;" alt="logo" class="sidebar-img mb-4"></a>
                    <nav class="menu flex-grow-1">
                        <ul class="nav flex-column">
                            <li class="nav-item"><a href="{{ url('home') }}" class="nav-link"><i class="bi bi-house"></i> Home</a></li>
                            <li class="nav-item"><a href="{{ url('search') }}" class="nav-link"><i class="bi bi-search"></i> Search</a></li>
                            <li class="nav-item"><a href="{{ url('notifications') }}" class="nav-link"><i class="bi bi-bell"></i> Notifications</a></li>
                            <li class="nav-item"><a href="{{ url('saved') }}" class="nav-link"><i class="bi bi-floppy"></i> Saved</a></li>
                            <li class="nav-item"><a href="{{ url('groups') }}" class="nav-link"><i class="bi bi-people-fill"></i> Groups</a></li>
                            <li class="nav-item"><a href="{{ url('support') }}" class="nav-link"><i class="bi bi-question-circle"></i> Support</a></li>
                        </ul>
                    </nav>
                    <ul class="nav flex-column mt-auto">
                        @auth
                            <li class="nav-item"><a href="{{ url('profile') }}" class="nav-link"><i class="bi bi-person-circle"></i> Profile</a></li>
                            <li class="nav-item">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                            </li>
                        @else
                            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> Login</a></li>
                            <li class="nav-item"><a href="{{ route('register') }}" class="nav-link"><i class="bi bi-pencil-square"></i> Register</a></li>
                        @endauth
                    </ul>
                </aside>

                <!-- Main content -->
                <main class="flex-grow-1 p-3">
                    <div class="container" style="margin-top: 20px;">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>