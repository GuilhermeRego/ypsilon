@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Create a New Group</h2>
    <form action="{{ route('group.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Group Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Group Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea required>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="group_image" class="form-label">Group Image (Optional)</label>
            <input type="file" class="form-control" id="group_image" name="group_image">
            @error('group_image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="group_banner" class="form-label">Group Banner (Optional)</label>
            <input type="file" class="form-control" id="group_banner" name="group_banner">
            @error('group_banner')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create Group</button>
    </form>
</div>

@endsection