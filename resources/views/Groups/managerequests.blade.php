@extends('layouts.app')
@section('content')
@include('layouts.upperbarmenu')
<div class="request-list" style="overflow-y: scroll">
    @foreach ($group->join_request as $request)
    <div class="request-item">
        <span class="nickname">{{ $request->user->nickname }}</span>
        <div class="actions">
            <form action="{{ route('group.accept-request', ['id' => $request->id]) }}" method="POST" style="display:inline;">
                @csrf
                @method('POST')
                <button type="submit" class="icon accept-icon" title="Accept">
                    <i class="fas fa-check"></i>
                </button>
            </form>

            <form action="{{ route('group.decline-request', ['id' => $request->id]) }}" method="POST" style="display:inline;">
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