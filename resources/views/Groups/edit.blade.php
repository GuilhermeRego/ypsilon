@extends('layouts.app')

@section('content')
<div class="container p-4" style="overflow-y: scroll">
    <h2>Edit Group</h2>
    <form action="{{ route('group.update', $group->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Add this to use the PUT method -->

        <div class="mb-3">
            <label for="name" class="form-label">Group Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $group->name) }}"
                required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Group Description</label>
            <textarea class="form-control" id="description" name="description" rows="4"
                required>{{ old('description', $group->description) }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="group_image" class="form-label">Group Image (Optional)</label>
            <input type="file" class="form-control" id="group_image" name="group_image">

            {{--
            @if($group->groupImage)
            <p>Current Image: <img src="{{ asset('storage/' . $group->groupImage->url) }}" alt="Group Image"
                    width="100"></p>
            @endif
            --}}
            @error('group_image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="group_banner" class="form-label">Group Banner (Optional)</label>
            <input type="file" class="form-control" id="group_banner" name="group_banner">
            
            {{--
            @if($group->group_banner)
                <p>Current Banner: <img src="{{ asset('storage/' . $group->group_banner) }}" alt="Group Banner" width="100">
                </p>
            @endif
            --}}
            @error('group_banner')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Group</button>
    </form>
</div>
@endsection