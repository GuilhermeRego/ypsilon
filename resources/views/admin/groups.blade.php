@extends('layouts.app')

@section('content')
<div class="container" style="overflow-y: scroll;">
    <h1 class="my-4">All Groups</h1>
    <div class="row">
        @foreach ($groups as $group)
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <a href="{{ route('group.show', $group->id) }}" class="text-decoration-none">
                        <h5 class="card-title text-primary">{{ $group->name }}</h5>
                    </a>
                    <p class="card-text"><strong>Description:</strong> {{ $group->description }}</p>
                    <p class="card-text"><strong>Members:</strong> {{ $group->memberCount() }}</p>
                    <p class="card-text"><strong>Posts:</strong> {{ $group->post_count }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            
                            <a href="{{ route('group.edit', $group->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('group.destroy', $group->id) }}" method="POST" style="display:inline-block;">
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