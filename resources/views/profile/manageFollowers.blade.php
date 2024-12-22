@extends('layouts.app')
@section('content')
@include('layouts.upperbarmenu')
<div class="container p-4" style="overflow-y: scroll">
    @if ($user->followers->count() == 0)
        <div class="alert alert-info">
            You have no followers.
        </div>
    @else   
    <h1>Displaying all followers for {{$user->username}}:</h1>
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
        @foreach ($user->followers as $follow)
            <div class="container p-2 d-flex align-items-center justify-content-between border border-1 rounded m-0 mb-2" style="width:300px">
                <div class="follower-left d-flex align-items-center">
                <img src="{{ $follow->follower->profileImage ? asset('storage/' . $follow->follower->profileImage->url) : asset('images/profile-default.png') }}"
                                class="rounded-circle mr-3 border border-2" 
                                alt="Profile Image" 
                                style="width: 50px; height: 50px;">
                <a href="{{ route('profile.show', ['username' => $follow->follower->username]) }}" style="font-size: 1.5em; text-decoration: none" >{{ $follow->follower->nickname }}</a>
            </div>
                <form action="{{ route('profile.removeFollower', ['username' => $user->username, 'followerId' => $follow->follower_id]) }}" method="POST" style="display:inline;" class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger mr-2" style="width:40px;height:40px"><strong>X</strong></button>
                </form>            
            </div>
        @endforeach
    @endif
</div>
@endsection