@extends('chat.inbox')

@section('chat-content')
<div class="p-4">
    <h2>Chat with 
        @foreach ($chatMembers as $member)
            @if ($member->user->id != auth()->id())
                {{ $member->user->nickname }}
            @endif
        @endforeach
    </h2>
    <div class="messages border rounded p-3" style="height: 500px; overflow-y: auto;">
        @foreach ($messages as $message)
            @if(Auth::user()->id === $message->sender->id)
                <div class="mb-3 d-flex justify-content-end">
                    <div class="message-sent p-3" style="background-color: #1b70f7; color: #fff">
            @else 
                <div class="mb-3 d-flex justify-content-start">
                    <div class="message-recieved p-3" style="background-color: #cfcfcf; color: #242424">
            @endif
                    <strong>{{ $message->sender->nickname }}:</strong>
                    <p>{{ $message->content }}</p>
                    <small class="text-muted">{{ $message->date_time }}</small>
                </div>
            </div>
        @endforeach
    </div>

    <form action="" method="POST" class="mt-3">
        @csrf
        <div class="input-group">
            <textarea name="content" class="form-control" placeholder="Type a message..." required></textarea>
            <button type="submit" class="btn btn-primary">Send</button>
        </div>
    </form>
</div>
@endsection