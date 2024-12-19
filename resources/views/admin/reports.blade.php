@extends('layouts.app')

@section('content')
<div class="container" style="overflow-y: scroll;">
    <h1 class="my-4">All Reports</h1>
    <div class="row">
        @foreach ($reports as $report)
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <p class="card-text"><strong>Reporter:</strong><a href="{{ route('profile.show', $report->reporter->username) }}" class="text-decoration-none"> {{ $report->reporter->username }}</a></p>
                    @if ($report->reported_user)
                        <p><strong>Reported User:</strong><a href="{{ route('profile.show', $report->reported_user->username) }}" class="card-title text-decoration-none"> {{ $report->reported_user->username }}</a></p>
                    @endif
                    @if ($report->group)
                        <p><strong>Reported Group:</strong><a href="{{ route('group.show', $report->group->id) }}" class="card-title text-decoration-none"> {{ $report->group->name }}</a></p>
                    @endif
                    @if ($report->post)
                        <p><strong>Reported Post:</strong><a href="{{ route('post.show', $report->post->id) }}" class="card-title text-decoration-none"> {!! $report->post->content !!}</a></p>
                    @endif
                    @if ($report->comment)
                        <p><strong>Reported Comment:</strong><a href="{{ route('post.show', $report->comment->post) }}" class="card-title text-decoration-none"> {!! $report->comment->content !!}</a></p>
                    @endif
                    <p class="card-text"><strong>Reason:</strong> {{ $report->justification }}</p>
                    <p class="card-text"><strong>Date:</strong> {{ $report->date_time }}</light></p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection