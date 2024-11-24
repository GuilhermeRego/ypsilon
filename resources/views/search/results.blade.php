@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="container-fluid">
        <form action="{{ route('results') }}" method="GET" id="searchForm">
            <input type="text" id="userSearch" name="query" placeholder="Search users..." class="form-control" value="{{ request('query') }}">
        </form>
        <ul id="userResults" class="list-group mt-2"></ul>
    </div>
    <script src="{{ asset('js/search.js') }}"></script>  
    <h1>Search Results for "{{ $query }}"</h1>
    @if($users->isEmpty())
        <p>No users found</p>
    @else
        <ul class="list-group">
            @foreach($users as $user)
                <li class="list-group-item">{{ $user->name }} ({{ $user->username }})</li>
            @endforeach
        </ul>
    @endif
</div>
@endsection