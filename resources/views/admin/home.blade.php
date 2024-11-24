@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Admin Dashboard</h1>

    <!-- Users List -->
    <div class="card mt-5">
        <div class="card-header" class="text-center">
            <strong>Users</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td><a href="{{ route('profile.show', ['username' => $user->username]) }}" class="btn btn-outline-primary btn-sm mb-0" style="font-size: 1.5em">{{ $user->nickname }}</a></td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Posts List -->
    <div class="card mt-5">
        <div class="card-header" class="text-center">
            <strong>Posts</strong>
        </div>
        <div class="card-body">
            @foreach($posts as $post)
                @include('post.post')
            @endforeach
        </div>
    </div>

    <!-- Groups List -->
     <div class="card mt-5">
        <div class="card-header" class="text-center">
            <strong>Groups</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Members</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groups as $group)
                    <tr>
                        <td><a href="{{ route('groups.discover', ['group' => $group->id]) }}" class="btn btn-outline-primary btn-sm mb-0" style="font-size: 1.5em">{{ $group->name }}</a></td>
                        <td>{{ $group->memberCount()}} Members </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>
@endsection