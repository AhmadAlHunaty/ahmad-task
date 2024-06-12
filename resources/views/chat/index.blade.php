@extends('Layout.main')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.1/dist/echo.iife.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>



    <script>
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env('PUSHER_APP_KEY') }}',
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true,
            authEndpoint: '/pusher/auth',
            auth: {
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}'
                }
            }
        });
        // Subscribe to the private channel for the specific subject
        window.Echo.private(`chat.${subjectId}`)
            .listen('MessageSent', (e) => {
                // Append message if the sender is not the current user
                if (e.message.student_id != userId) {
                    appendMessage(e.message);
                }
            });

        // Function to append a new message to the message list
        function appendMessage(message) {
            const messageList = document.getElementById('message-list');
            const listItem = document.createElement('li');
            listItem.textContent = `${message.student.name}: ${message.message}`;
            messageList.appendChild(listItem);
        };
    </script>


    <h1>Welcome, {{ auth()->user()->name }}</h1>
    <div class="container">
        <div class="container">
            <h1>Students in Subject: {{ $subject->name }} </h1>
            @foreach ($students as $student)
                <li>
                    {{ $student->user->name }} - <a href="{{ route('chat.index', $subject->id) }}">Chat Room </a>
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
