<div class="upperbar w-100 d-flex justify-content-around align-items-center p-2">
    @if (Request::is('home/*'))
        <a href="{{ url('/home/trending') }}" class="{{ Request::is('home/trending') ? 'selected' : '' }}">Trending</a>
        @auth
            <a href="{{ url('/home/following') }}" class="{{ Request::is('home/following') ? 'selected' : '' }}">Following</a>
        @else
            <a href="{{ url('/login') }}">Following</a>
        @endauth
    @elseif (Request::is('groups/discover') || Request::is('groups/my-groups'))
        <a href="{{ url('/groups/discover') }}" class="{{ Request::is('groups/discover') ? 'selected' : '' }}">Discover</a>
        @auth
            <a href="{{ url('/groups/my-groups') }}" class="{{ Request::is('groups/my-groups') ? 'selected' : '' }}">My
                Groups</a>
        @else
            <a href="{{ url('/login') }}">My Groups</a>
        @endauth
    @elseif (Request::is('groups/' . $group->id . '/management/members') || Request::is('groups/' . $group->id . '/management/requests'))
        <a href="{{ url('groups/' . $group->id . '/management/members') }}"class="{{ Request::is('groups/' . $group->id . '/management/members') ? 'selected' : '' }}">Manage Members</a>
        <a href="{{ url('groups/' . $group->id . '/management/requests') }}" class="{{ Request::is('groups/' . $group->id . '/management/requests') ? 'selected' : '' }}">Manage Join Requests</a>
    @endif
</div>