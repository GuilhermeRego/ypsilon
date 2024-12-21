@extends('layouts.app')

@section('content')
<div class="container my-5" style="overflow-y: scroll;">
    <h1 class="mb-4 text-center">User Management</h1>

    <!-- Table Wrapper -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Birth Date</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>
                            <a href="{{ route('profile.show', $user->username) }}" class="text-primary fw-bold text-decoration-none">
                                <i class="fas fa-user-circle me-2"></i>{{ $user->username }}
                            </a>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->birth_date }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <div>
                                <a href="{{ route('profile.edit', ['username' => $user->username]) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('profile.destroy', ['username' => $user->username]) }}" method="POST" class="d-inline-block">
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
