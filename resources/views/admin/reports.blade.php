@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 text-center">All Reports</h1>

    <!-- Table Wrapper -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Reporter</th>
                        <th>Reported</th>
                        <th>Reason</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                    <tr>
                        <!-- Reporter -->
                        <td>
                            <a href="{{ route('profile.show', $report->reporter->username) }}" class="text-primary text-decoration-none">
                                <i class="fas fa-user me-2"></i>{{ $report->reporter->username }}
                            </a>
                        </td>

                        <!-- Reported Item -->
                        <td>
                            @if ($report->reported_user)
                                <div><strong>User:</strong> 
                                    <a href="{{ route('profile.show', $report->reported_user->username) }}" class="text-decoration-none">
                                        {{ $report->reported_user->username }}
                                    </a>
                                </div>
                            @endif
                            @if ($report->group)
                                <div><strong>Group:</strong> 
                                    <a href="{{ route('group.show', $report->group->id) }}" class="text-decoration-none">
                                        {{ $report->group->name }}
                                    </a>
                                </div>
                            @endif
                            @if ($report->post)
                                <div><strong>Post:</strong> 
                                    <a href="{{ route('post.show', $report->post->id) }}" class="text-decoration-none">
                                        {!! Str::limit($report->post->content, 30, '...') !!}
                                    </a>
                                </div>
                            @endif
                            @if ($report->comment)
                                <div><strong>Comment:</strong> 
                                    <a href="{{ route('post.show', $report->comment->post) }}" class="text-decoration-none">
                                        {!! Str::limit($report->comment->content, 30, '...') !!}
                                    </a>
                                </div>
                            @endif
                        </td>

                        <!-- Reason -->
                        <td class="text-truncate" style="max-width: 200px;">{{ $report->justification }}</td>

                        <!-- Date -->
                        <td>{{ $report->date_time }}</td>

                        <!-- Actions -->
                        <td>
                            <form action="{{ route('report.destroy', ['report' => $report->id]) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-check"></i> Resolve
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination-container mt-4">
        {{ $reports->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
