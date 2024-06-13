import Pusher from 'pusher-js';

// Initialize Pusher
const pusher = new Pusher(import.meta.env.VITE_REVERB_APP_KEY, {
    cluster: import.meta.env.VITE_REVERB_APP_CLUSTER,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
    authEndpoint: '/pusher/auth',
    auth: {
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }
});

// Subscribe to the private channel for the specific subject
const channel = pusher.subscribe(`private-chat.${subjectId}`);
channel.bind('MessageSent', handleMessage);

// Function to handle incoming messages
function handleMessage(data) {
    if (data.message.student_id != userId) {
        appendMessage(data.message);
    }
}

// Function to append a new message to the message list
function appendMessage(message) {
    const messageList = document.getElementById('message-list');
    const listItem = document.createElement('li');
    listItem.textContent = `${message.student.name}: ${message.message}`;
    messageList.appendChild(listItem);
}
