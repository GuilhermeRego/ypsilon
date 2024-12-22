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
    @elseif (Request::is('information/about-us') || Request::is('information/services') || Request::is('information/contacts') || Request::is('information/faq'))
        <a href="{{ url('/information/about-us') }}" class="{{ Request::is('information/about-us') ? 'selected' : '' }}">About us</a>
        <a href="{{ url('/information/services') }}" class="{{ Request::is('information/services') ? 'selected' : '' }}">Services</a>
        <a href="{{ url('/information/contacts') }}" class="{{ Request::is('information/contacts') ? 'selected' : '' }}">Contacts</a>
        <a href="{{ url('/information/faq') }}" class="{{ Request::is('information/faq') ? 'selected' : '' }}">FAQ's</a>
    
    @elseif (isset($group) && (Request::is('groups/' . $group->id . '/management/members') || Request::is('groups/' . $group->id . '/management/requests')))
        <a href="{{ url('groups/' . $group->id . '/management/members') }}" class="{{ Request::is('groups/' . $group->id . '/management/members') ? 'selected' : '' }}">Manage Members</a>
        <a href="{{ url('groups/' . $group->id . '/management/requests') }}" class="{{ Request::is('groups/' . $group->id . '/management/requests') ? 'selected' : '' }}">Manage Join Requests</a>
    @elseif (isset($user) && (Request::is('profile/' . $user->username . '/management/followers') || Request::is('profile/' . $user->username . '/management/requests')))
        <a href="{{ url('profile/' . $user->username . '/management/followers') }}" class="{{ Request::is('profile/' . $user->username . '/management/followers') ? 'selected' : '' }}">Manage Followers</a>
        <a href="{{ url('profile/' . $user->username . '/management/requests') }}" class="{{ Request::is('profile/' . $user->username . '/management/requests') ? 'selected' : '' }}">Manage Follow Requests</a>
    @endif
</div>