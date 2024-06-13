{{-- @extends('Layout.main')

@section('content')
    <div class="container">
        @csrf
        <h1>Chat Room {{ $subject->name }}</h1>

        <div id="chat-box" class="border p-3 mb-3" style="height: 400px; overflow-y: scroll;">
            <ul id="message-list" class="list-unstyled">
                @foreach ($messages as $message)
                    <li><strong>{{ $message->student->user->name }}:</strong> {{ $message->message }}</li>
                @endforeach
            </ul>
        </div>

        <form id="chat-form" action="{{ route('chat.store', $subject->id) }}" method="POST">
            @csrf
            <div class="input-group">
                <input type="text" name="message" class="form-control" placeholder="Type a message..." required>
                <button class="btn btn-primary" type="submit">Send</button>
            </div>
        </form>
    </div>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable Pusher logging - for debugging purposes only
        Pusher.logToConsole = true;

        // Initialize Pusher
        var pusher = new Pusher('03d440e0081a131d2a68', {
            cluster: 'ap2'
        });

        // Subscribe to the relevant private channel
        var channel = pusher.subscribe('chat.{{ $subject->id }}');

        // Bind to the event and handle incoming messages
        channel.bind('MessageSent', function(data) {
            alert(JSON.stringify(data));
        });
    </script>
@endsection --}}
@extends('Layout.main')

@section('content')
    <div class="container">
        @csrf
        <h1>Chat Room {{ $subject->name }}</h1>


        <div id="chat-box" class="border p-3 mb-3" style="height: 400px; overflow-y: scroll;">
            <ul id="message-list" class="list-unstyled">
                @foreach ($messages as $message)
                    <li><strong>{{ $message->student->user->name }}:</strong> {{ $message->message }}</li>
                @endforeach
            </ul>
            <p id="latest-message">No new messages</p>
        </div>

        <form id="chat-form" action="{{ route('chat.store') }}" method="POST">
            @csrf
            <div class="input-group">
                <input type="text" name="message" class="form-control" placeholder="Type a message..." required>
                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                <input type="hidden" name="student_id" value="{{ $student->id }}">

                <button class="btn btn-primary" type="submit">Send</button>
            </div>
        </form>
        {{-- <h1>Pusher Test</h1>
        <p>
            Try publishing an event to channel <code>proud-prize-879</code>
            with event name <code>MessageSent</code>.
            Event(new MyEvent('hello world'));
        </p> --}}
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
        //  import Pusher from 'pusher-js';
        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;
        // var pusher = new Pusher('03d440e0081a131d2a68', {
        //     cluster: 'ap2',
        //     forceTLS: true,
        // });

        // var channel = pusher.subscribe('proud-prize-879');
        // channel.bind('MessageSent', function(data) {
        //     alert(JSON.stringify(data));
        //     console.log(data);
        // });

        // Pusher.logToConsole = true;

        // var pusher = new Pusher('03d440e0081a131d2a68', {
        //     cluster: 'ap2',
        //     forceTLS: true
        // });

        // var channel = pusher.subscribe('proud-prize-879');
        // channel.bind('MessageSent', function(data) {
        //     // Extract the message and student data from the event
        //     var message = data.message.message;
        //     var studentName = data.message.student.user.name;

        //     // Create a new list item and append it to the message list
        //     var messageItem = '<li><strong>' + studentName + ':</strong> ' + message + '</li>';
        //     $('#message-list').append(messageItem);

        //     // Optionally scroll to the bottom of the chat box
        //     var chatBox = $('#chat-box');
        //     chatBox.scrollTop(chatBox[0].scrollHeight);
        // });


        // import Pusher from 'pusher-js';

        // const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        //     cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        //     encrypted: true,
        //     authEndpoint: '/pusher/auth',
        //     auth: {
        //         headers: {
        //             'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //         }
        //     }
        // });

        // const channel = pusher.subscribe(`chat.${subjectId}`);
        // channel.bind('MessageSent', handleMessage);

        // function handleMessage(data) {
        //     if (data.message.student_id != userId) {
        //         appendMessage(data.message);
        //     }
        // }

        // function appendMessage(message) {
        //     const messageList = document.getElementById('message-list');
        //     const listItem = document.createElement('li');
        //     listItem.textContent = `${message.student.name}: ${message.message}`;
        //     messageList.appendChild(listItem);
        // }
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('03d440e0081a131d2a68', {
            cluster: 'ap2',
            forceTLS: true
        });

        // Replace `subjectId` with the actual subject ID of the chat
        var subjectId = 'your-subject-id-here';
        var channel = pusher.subscribe('chat.' + subjectId);

        channel.bind('MessageSent', function(data) {
                    // Extract the message and student data from the event
                    var message = data.message.message;
                    var studentName = data.message.student.user.name;

                    // Update the content of the <p> tag with the new message
                    var latestMessage = '<strong>' + studentName + ':</strong> ' + message;
                    $('#latest-message').html(latestMessage);

                    // Optionally scroll to the bottom of the chat box
                    var chatBox = $('#chat-box');
                    chatBox.scrollTop(chatBox[0].scrollHeight);
    </script>
@endsection
