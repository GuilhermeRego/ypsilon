@extends('layouts.app')

@section('content')
<div class="container my-5" style="overflow-y: scroll">
    <h1 class="mb-4 text-center">Group Management</h1>

    <!-- Table Wrapper -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Members</th>
                        <th>Posts</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groups as $group)
                    <tr>
                        <!-- Group Name -->
                        <td>
                            <a href="{{ route('group.show', $group->id) }}" class="text-primary fw-bold text-decoration-none">
                                <i class="fas fa-users me-2"></i>{{ $group->name }}
                            </a>
                        </td>

                        <!-- Description -->
                        <td class="text-truncate" style="max-width: 300px;">
                            {{ Str::limit($group->description, 50, '...') }}
                        </td>

                        <!-- Members -->
                        <td>
                            <span class="badge bg-primary">
                                <i class="fas fa-user-friends me-1"></i>{{ $group->memberCount() }}
                            </span>
                        </td>

                        <!-- Posts -->
                        <td>
                            <span class="badge bg-secondary">
                                <i class="fas fa-pen-nib me-1"></i>{{ $group->post_count }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td>
                            <div>
                                <a href="{{ route('group.edit', $group->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('group.destroy', $group->id) }}" method="POST" class="d-inline-block">
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
