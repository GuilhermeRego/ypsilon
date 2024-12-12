@extends('layouts.app')
@section('content')
@include('layouts.upperbarmenu')
<div class="request-list">
    @foreach ($group->join_request as $request)
        <div class="request-item">
            <span class="nickname">{{ $request->user->nickname }}</span>
            <div class="actions">
                <a href="{{ route('accept_request', ['id' => $request->id]) }}" class="icon accept-icon" title="Accept">
                    <i class="fas fa-check"></i>
                </a>
                <a href="{{ route('decline_request', ['id' => $request->id]) }}" class="icon decline-icon" title="Decline">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </div>
    @endforeach
</div>
@endforeach
@endsection