@extends('layouts.app')

@section('content')
<div class="container p-4" style="overflow-y: scroll">
    <h2>Edit Profile</h2>
    <form action="{{ route('profile.update', ['username' => $user->username]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="nickname" class="form-label">Nickname</label>
            <input type="text" class="form-control" id="nickname" name="nickname" value="{{ $user->nickname }}" required>
            @error('nickname')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="bio" class="form-label">Bio</label>
            <textarea class="form-control" id="bio" name="bio" rows="3">{{ $user->bio }}</textarea>
            @error('bio')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="profile_image" class="form-label">Profile Image (Optional)</label>
            <input type="file" class="form-control" id="profile_image" name="profile_image">
            @error('profile_image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="banner_image" class="form-label">Banner Image (Optional)</label>
            <input type="file" class="form-control" id="banner_image" name="banner_image">
            @error('banner_image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <div class="mb-3 d-flex align-items-center">
                <label for="is_private" class="form-label">Private Account</label>
                <div class="form-check form-switch" style="transform: scale(1.5);">
                    <input type="checkbox" class="form-check-input" id="is_private" name="is_private" value="1" 
                    {{ $user->is_private ? 'checked' : '' }}>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection