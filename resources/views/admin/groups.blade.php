@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Groups</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Group ID</th>
                <th>Group Name</th>
                <th>Number of Members</th>
                <th>Number of Posts</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groups as $group)
            <tr>
                <td>{{ $group->id }}</td>
                <td>{{ $group->name }}</td>
                <td>{{ $group->memberCount }}</td>
                <td>{{ $group->postCount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection