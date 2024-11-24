@extends('layouts.groups')
@section('groups-content')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<h1 class="mb-4">Discover Communities</h1>
@endsection