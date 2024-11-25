<!-- FILE: resources/views/layouts/upperbarmenu.blade.php -->
<div class="upperbar">
    @if (Request::is('home/*'))
        <a href="{{ url('/home/trending') }}" class="{{ Request::is('home/trending') ? 'active' : '' }}">Trending</a>
        @auth
            <a href="{{ url('/home/following') }}" class="{{ Request::is('home/following') ? 'active' : '' }}">Following</a>
        @else
            <a href="{{ url('/login') }}">Following</a>
        @endauth
    @elseif (Request::is('groups/discover') || Request::is('groups/my-groups'))
        <a href="{{ url('/groups/discover') }}" class="{{ Request::is('groups/discover') ? 'active' : '' }}">Discover</a>
        @auth
            <a href="{{ url('/groups/my-groups') }}" class="{{ Request::is('groups/my-groups') ? 'active' : '' }}">My Groups</a>
        @else
            <a href="{{ url('/login') }}">My Groups</a>
        @endauth
    @endif
</div>
