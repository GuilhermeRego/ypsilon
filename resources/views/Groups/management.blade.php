@extends('layouts.app')

@section('content')
<div class="container p-4" style="overflow-y: scroll">
    <h1>Manage Group Members</h1>

    {{-- Lista de proprietários --}}
    <h2>Group Owners:</h2>
    <ul>
        @foreach ($owners as $owner)
                <li>
                    {{ $owner->user->nickname }}
                    @if (auth()->user()->id === $owner->user_id)
                        <span class="badge bg-primary">You</span>
                    @endif
                    <span class="badge bg-success">Owner</span>
                </li>
        @endforeach
    </ul>

    {{-- Lista de membros não proprietários --}}
    <h2>Members:</h2>
    <ul>
        @foreach ($members as $member)
            <li>
                {{ $member->user->nickname }}
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