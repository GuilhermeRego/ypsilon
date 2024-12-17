@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Notifications</h1>
    @if($notifications->isEmpty())
        <p>No notifications found.</p>
    @else
        <p>No notifications found.</p>
    @endif
</div>
@endsection