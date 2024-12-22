@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="container-fluid">
        <form action="{{ route('results') }}" method="GET" id="searchForm">
            <input type="text" id="userSearch" name="query" placeholder="Search users..." class="form-control" value="{{ request('query') }}">
            <input type="hidden" name="type" id="searchType" value="{{ request('type', 'users') }}">
        </form>
        <ul id="userResults" class="list-group mt-2"></ul>
    </div>
    <script src="{{ asset('js/search.js') }}"></script>  
    <!-- If we are at /results*, show the following:  -->
     @if(request('query'))
        <h1>Search Results for "{{ $query }}"</h1>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ $type === 'users' ? 'active' : '' }}" href="{{ route('results', ['query' => $query, 'type' => 'users']) }}">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $type === 'posts' ? 'active' : '' }}" href="{{ route('results', ['query' => $query, 'type' => 'posts']) }}">Posts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $type === 'groups' ? 'active' : '' }}" href="{{ route('results', ['query' => $query, 'type' => 'groups']) }}">Groups</a>
            </li>
        </ul>

        @if($results->isEmpty())
            <p>No results found</p>
        @else
            <ul class="list-group mt-2" style="overflow-y: scroll; max-height: 750px;">
                @foreach($results as $result)
                    @if($type === 'users')
                        <li class="list-group-item">
                            <a href="{{ route('profile.show', ['username' => $result->username]) }}">
                                {{ $result->name }} ({{ $result->username }})
                            </a>
                        </li>
                    @elseif($type === 'posts')
                        <li class="list-group-item">
                            @include('post.post', ['post' => $result])
                        </li>
                    @elseif($type === 'groups')
                        <li class="list-group-item">
                            <a href="{{ url('groups/' . $result->id) }}" class="text-decoration-none text-dark">
                                <div class="card my-2 p-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . ($result->groupImage ? $result->groupImage->url : 'https://via.placeholder.com/50')) }}" class="rounded-circle me-3" alt="Group Image">
                                        <div>
                                            <h3>{{ $result->name }}</h3>
                                            <p>{{ $result->memberCount() }} Members | {{ $result->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
    @else
        <h1>Search for users, posts, or groups</h1>
    @endif
</div>
@endsection