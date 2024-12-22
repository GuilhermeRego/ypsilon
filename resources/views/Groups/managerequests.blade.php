@extends('layouts.app')
@section('content')
@include('layouts.upperbarmenu')
<div class="container p-4" style="overflow-y: scroll">
    <h1>Manage Join Requests</h1>
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
    @if ($group->join_request->count() == 0)
    <div class="alert alert-info">
        You have no follow requests.
    </div>
    @else
        @foreach ($group->join_request as $request)
            <div class="container p-2 d-flex align-items-center justify-content-between border border-1 rounded m-0 mb-2" style="width:300px">
                <div class="follower-left d-flex align-items-center">
                    <img src="{{ $request->user->profileImage ? asset($request->user->profileImage->url) : asset('images/profile-default.png') }}"
                                    class="rounded-circle mr-3 border border-2" 
                                    alt="Profile Image" 
                                    style="width: 50px; height: 50px;">
                                    <a href="{{ route('profile.show', ['username' => $request->user->username]) }}" style="font-size: 1.5em; text-decoration: none;" >{{ $request->user->nickname }}</a>
                </div>
                <div>
                    <form action="{{ route('group.accept-request', ['id' => $request->id]) }}" method="POST" style="display:inline;" class="m-0">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-primary mr-2" style="width:40px;height:40px"><i class="bi bi-check-lg"></i></button>
                    </form> 
                    <form action="{{ route('group.decline-request', ['id' => $request->id]) }}" method="POST" style="display:inline;" class="m-0">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-danger mr-2" style="width:40px;height:40px"><i class="bi bi-x-lg"></i></button>
                    </form>  
                </div>          
            </div>
        @endforeach
    @endif
</div>
@endsection