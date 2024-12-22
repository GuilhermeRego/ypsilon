@extends('layouts.app')
@section('content')
@if ($group->is_private)
@include('layouts.upperbarmenu')
@endif
<div class="container p-4" style="overflow-y: scroll">
    <h1>Manage Group Members</h1>
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
    <h2>Group Owners:</h2>
        @foreach ($owners as $owner)
            <div class="container d-flex gap-2 m-0 p-0 mb-2 ">
                <div class="container p-2 d-flex align-items-center border border-1 rounded m-0" style="width:250px">
                    <img src="{{ $owner->user->profileImage ? asset($owner->user->profileImage->url) : asset('images/profile-default.png') }}"
                                    class="rounded-circle mr-3 border border-2" 
                                    alt="Profile Image" 
                                    style="width: 50px; height: 50px;">
                    <a href="{{ route('profile.show', ['username' => $owner->user->username]) }}" style="font-size: 1.5em; text-decoration: none" >{{ $owner->user->nickname }}</a>
                </div>
                @if (auth()->user()->id === $owner->user_id)
                    <div class="bg-primary d-flex align-content-center justify-content-center border border-1 rounded" style="width:60px; color: #FFF">
                        <p class="align-content-center mb-0">You</p>
                    </div>
                @endif
                <div class="bg-success d-flex align-content-center justify-content-center border border-1 rounded" style="width:60px; color: #FFF">
                    <p class="align-content-center mb-0">Owner</p>
                </div>
            </div>
        @endforeach
    @if (count($members) == 0)
        <div class="alert alert-info">
            This group has no members that aren't owners.
        </div>
    @else
    <h2>Members:</h2>
        @foreach ($members as $member)
        <div class="container d-flex gap-2 m-0 p-0 mb-2 ">
            <div class="container p-2 d-flex align-items-center border border-1 rounded m-0" style="width:250px">
                <img src="{{ $member->user->profileImage ? asset($member->user->profileImage->url) : asset('images/profile-default.png') }}"
                                class="rounded-circle mr-3 border border-2" 
                                alt="Profile Image" 
                                style="width: 50px; height: 50px;">
                <a href="{{ route('profile.show', ['username' => $member->user->username]) }}" style="font-size: 1.5em; text-decoration: none" >{{ $member->user->nickname }}</a>
            </div>
                <form action="{{ route('group.removeMember', ['group' => $group->id, 'member' => $member->user_id]) }}"
                    method="POST" class="m-0" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm h-100" style="width: 60px">Remove</button>
                </form>
                <form action="{{ route('group.makeOwner', ['group' => $group->id, 'member' => $member->user_id]) }}"
                    method="POST" class="m-0" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-sm h-100">Make Owner</button>
                </form>
        </div>
        @endforeach
    @endif
    <form action="{{ route('group.addMember', $group->id) }}" method="POST">
        @csrf
        <label for="username">Add member by username:</label>
        <div class="form-group d-flex gap-2">
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
            <button type="submit" class="btn btn-primary">Add Member</button>
        </div>
    </form>
</div>
@endsection