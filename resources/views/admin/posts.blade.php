@extends('layouts.app')

@section('content')
<div class="container my-5" style="overflow-y: scroll;">
    <h1 class="mb-4 text-center">Post Management</h1>

    <!-- Search Form -->
    <form action="{{ route('admin.posts.search') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Search posts..." value="{{ request('query') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- Table Wrapper -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Author</th>
                        <th>Content</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                        <!-- Author -->
                        <td>
                            @if ($post->user_id == NULL)
                                <span class="text-secondary"><i class="fas fa-user-slash me-2"></i>Anonymous</span>
                            @else
                                <a href="{{ route('profile.show', $post->user->username) }}" class="text-primary fw-bold text-decoration-none">
                                    <i class="fas fa-user-circle me-2"></i>{{ $post->user->username }}
                                </a>
                            @endif
                        </td>

                        <!-- Content -->
                        <td class="text-truncate" style="max-width: 250px;">
                            {!! Str::limit(strip_tags($post->content), 50, '...') !!}
                        </td>

                        <!-- Created At -->
                        <td>{{ $post->date_time }}</td>

                        <!-- Actions -->
                        <td>
                            <div>
                                <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('post.destroy', $post->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
