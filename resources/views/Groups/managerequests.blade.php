@extends('layouts.app')
@section('content')
@if ($group->is_private)
@include('layouts.upperbarmenu')
@endif
<div class="request-list" style="overflow-y: scroll">
    <h1>Manage Join Requests</h1>
    @foreach ($group->join_request as $request)
        <div class="request-item">
            <a href="{{ route('profile.show', ['username' => $request->user->username]) }}"
                style="font-size: 1.5em; text-decoration:none">
                {{ $request->user->nickname }}</a>
                <p class="m-0 pl-1" style="display: inline;">&#64{{ $request->user->username }}</p>
            <div class="actions">
                <form action="{{ route('group.accept-request', ['id' => $request->id]) }}" method="POST"
                    style="display:inline;">
                    @csrf
                    @method('POST')
                    <button type="submit" class="icon accept-icon" title="Accept">
                        <i class="fas fa-check"></i>
                    </button>
                </form>

                <form action="{{ route('group.decline-request', ['id' => $request->id]) }}" method="POST"
                    style="display:inline;">
                    @csrf
                    @method('POST')
                    <button type="submit" class="icon decline-icon" title="Decline">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
            </div>
        </div>
    @endforeach
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