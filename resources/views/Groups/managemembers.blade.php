@extends('layouts.app')
@section('content')
@include('layouts.upperbarmenu')
<div class="container p-4" style="overflow-y: scroll">
    <h1>Manage Group Members</h1>

    <h2>Group Owners:</h2>
    <ul>
        @foreach ($owners as $owner)
                <li>
                    <a href="{{ route('profile.show', ['username' => $owner->user->username]) }}" style="font-size: 1.5em; text-decoration:none">
                    {{ $owner->user->nickname }}</a> 
                    <p class="m-0 pl-1" style="display: inline;">&#64{{ $owner->user->username }}</p>
                    @if (auth()->user()->id === $owner->user_id)
                        <span class="badge bg-primary">You</span>
                    @endif
                    <span class="badge bg-success">Owner</span>
                </li>
        @endforeach
    </ul>

    <h2>Members:</h2>
    <ul>
        @foreach ($members as $member)
            <li>
            <a href="{{ route('profile.show', ['username' => $member->user->username]) }}" style="font-size: 1.5em; text-decoration:none">
            {{ $member->user->nickname }}</a>
            <p class="m-0 pl-1" style="display: inline;">&#64{{ $member->user->username }}</p>
                <form action="{{ route('group.removeMember', ['group' => $group->id, 'member' => $member->user_id]) }}"
                    method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                </form>
                <form action="{{ route('group.makeOwner', ['group' => $group->id, 'member' => $member->user_id]) }}"
                    method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-sm">Make Owner</button>
                </form>
            </li>
        @endforeach
    </ul>

    <form action="{{ route('group.addMember', $group->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="username">Add member by username:</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Member</button>
    </form>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection