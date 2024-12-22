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

    <form id="messageForm" action="{{ route('chat.storeMessage', ['chat' => $chat->id]) }}" method="POST" class="mt-3">
        @csrf
        <div class="input-group">
            <textarea name="content" class="form-control" placeholder="Type a message..." required></textarea>
            <button type="submit" class="btn btn-primary">Send</button>
        </div>
    </form>
</div>

<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    const chatId = {{ $chat->id }};
    const userId = {{ auth()->id() }};
    const messagesContainer = document.querySelector('.messages');

    // Initialize Pusher
    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        encrypted: true
    });

    // Subscribe to the chat channel
    const channel = pusher.subscribe(`private-chat.${chatId}`);
    channel.bind('MessageSent', function (data) {
        console.log('Recieved')
        addMessageToUI(data.message);
    });

    document.getElementById('messageForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const content = this.content.value;
        const token = '{{ csrf_token() }}'; // CSRF token for Laravel

        fetch(`/direct/${chatId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ content: content })
        })
        .then(response => response.json())
        .then(data => {
            this.content.value = '';
            addMessageToUI(data.message);
        })
        .catch(error => console.error('Error:', error));
    });

    // Add message to UI
    function addMessageToUI(message) {
        const isOwnMessage = message.sender_id === userId;
        const messageDiv = document.createElement('div');
        messageDiv.className = `mb-3 d-flex justify-content-${isOwnMessage ? 'end' : 'start'}`;
        messageDiv.innerHTML = `
            <div class="message-${isOwnMessage ? 'sent' : 'received'} p-3" style="background-color: ${isOwnMessage ? '#1b70f7' : '#cfcfcf'}; color: ${isOwnMessage ? '#fff' : '#242424'}">
                <strong>${message.sender.nickname}:</strong>
                <p>${message.content}</p>
                <small class="text-muted">${new Date(message.date_time).toLocaleString()}</small>
            </div>
        `;
        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight; // Scroll to bottom
    }
</script>
@endsection