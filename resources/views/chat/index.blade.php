@extends('Layout.main')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.1/dist/echo.iife.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>



    <script>
        import Pusher from 'pusher-js';

        const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true,
            authEndpoint: '/pusher/auth',
            auth: {
                headers: {
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }
        });

        const channel = pusher.subscribe(`private-chat.${subjectId}`);
        channel.bind('MessageSent', handleMessage);

        function handleMessage(data) {
            if (data.message.student_id != userId) {
                appendMessage(data.message);
            }
        }

        function appendMessage(message) {
            const messageList = document.getElementById('message-list');
            const listItem = document.createElement('li');
            listItem.textContent = `${message.student.name}: ${message.message}`;
            messageList.appendChild(listItem);
        }
    </script>


    <h1>Welcome, {{ auth()->user()->name }}</h1>
    <div class="container">
        <div class="container">
            <h1>Students in Subject: {{ $subject->name }} </h1>
            @foreach ($students as $student)
                <li>
                    {{ $student->user->name }} - <a href="{{ route('chat.index') }}">Chat Room </a>
                </li>
            @endforeach
        </div>

        {{-- <h2>Your Subjects</h2>
        <ul>
            @if (auth()->check() && auth()->user()->student && auth()->user()->student->subjects->isNotEmpty())
                @foreach (auth()->user()->student->subjects as $subject)
                    <li>
                        {{ $student->user->name }} - <a href="{{ route('chat.index', $subject->id) }}">Chat Room</a>
                    </li>
                @endforeach
            @else
                <p>No subjects found.</p>
            @endif
        </ul> --}}
    </div>
@endsection
