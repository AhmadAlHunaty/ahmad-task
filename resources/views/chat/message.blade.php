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
        </div>

        <form id="chat-form" action="{{ route('pusher.auth', $subject->id) }}" method="POST">
            @csrf
            <div class="input-group">
                <input type="text" name="message" class="form-control" placeholder="Type a message..." required>
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
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('03d440e0081a131d2a68', {
            cluster: 'ap2',
            forceTLS: true,
        });

        var channel = pusher.subscribe('proud-prize-879');
        channel.bind('MessageSent', function(data) {
            //alert(JSON.stringify(data));
            console.log(data);
        });
        var message = 'Hello, This is my first real time message';
        $.ajax({
            type: 'POST',
            cache: false,
            dataType: 'json',
            url: '{{ route('pusher.auth') }}',
            contentType: false,
            processData: false,
            data: {
                message: message
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                if (result.response_code == 1) {
                    alert("Message has been sent");
                } else {
                    alert("Fail to send message");
                }
            },
            error: function() {
                alert("Something went wrong please try again later");
            }
        });
    </script>
@endsection
