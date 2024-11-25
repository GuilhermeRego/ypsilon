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
        <ul class="list-group mt-2">
            @foreach($results as $result)
                @if($type === 'users')
                    <li class="list-group-item">
                        <a href="{{ route('profile.show', ['username' => $result->username]) }}">
                            {{ $result->name }} ({{ $result->username }})
                        </a>
                    </li>
                @elseif($type === 'posts')
                    <li class="list-group-item">
                        <a href="{{ route('posts.show', ['id' => $result->id]) }}">
                            {{ $result->title }}
                        </a>
                    </li>
                @elseif($type === 'groups')
                    <li class="list-group-item">
                        <a href="{{ route('groups.show', ['id' => $result->id]) }}">
                            {{ $result->name }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    @endif
</div>
@endsection