@extends('layouts.app')

@section('content')
<div class="container" style="overflow-y: scroll;">
    <h1 class="my-4">All Users</h1>
    <div class="row">
        @foreach ($users as $user)
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <a href="{{ route('profile.show', $user->username) }}" class="text-decoration-none">
                        <h5 class="card-title text-primary">{{ $user->username }}</h5>
                    </a>
                    <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="card-text"><strong>Birth Date:</strong> {{ $user->birth_date }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('profile.edit', ['username' => $user->username]) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('profile.destroy', ['username' => $user->username]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection