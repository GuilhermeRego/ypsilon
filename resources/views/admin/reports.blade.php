@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Reports</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Report ID</th>
                <th>Reporter Username</th>
                <th>Reported Item</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr>
                <td>{{ $report->id }}</td>
                <td>{{ $report->reporter_user_id->username }}</td>
                <td>
                    @if($report->reported_user_id != NULL)
                        User: {{ $report->reported_user_id }}
                    @elseif($report->type != NULL)
                        Post ID: {{ $report->reported_post_id }}
                    @elseif($report->type != NULL)
                        Comment ID: {{ $report->reported_comment_id }}
                    @elseif($report->type != NULL)
                        Group: {{ $report->reported_group_id }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection