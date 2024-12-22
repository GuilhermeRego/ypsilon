@extends('layouts.app')

@section('content')
    <div class="inbox-container">
        <div class="inbox-bar border-end border-2" style="overflow-y:scroll">
            @foreach ($chats as $chat)
                @php
                    $member = $usersArray[$chat->id] ?? null;
                    $user = $member ? $member->user : null;
                @endphp
                @if ($user)
                    <a href="{{ route('chat.show', ['chat' => $chat->id]) }}" class="text-decoration-none text-dark">
                        <div class="border-bottom d-flex align-items-center p-4" style="height: 100px">
                            <img src="{{ $user->profileImage ? asset($user->profileImage->url) : asset('images/profile-default.png') }}"
                                class="img-thumbnail rounded-circle mr-3" alt="Profile Image"
                                style="width: 75px; height: 75px;">
                            <h3 class="text-break">{{ $user->nickname }}</h3>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
        <div>
            @yield('chat-content')
        </div>
    </div>
@endsection
